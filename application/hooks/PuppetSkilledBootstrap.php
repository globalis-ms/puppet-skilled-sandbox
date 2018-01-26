<?php
use \Globalis\PuppetSkilled\Core\Application;

class PuppetSkilledBootstrap
{
    public function boot()
    {
        $application = Application::getInstance();

        $container = $application->getContainer();

        // Register Settings Service
        $container['settings'] = function ($c) {
            return new \Globalis\PuppetSkilled\Settings\Settings(new \Globalis\PuppetSkilled\Settings\SettingsDatabase($c['db'], 'settings'));
        };

        // Register Event Dispatcher
        $container['eventDispatcher'] = function () {
            return new \Globalis\PuppetSkilled\Event\Dispatcher();
        };

        // Register authentication Service
        $container['authenticationService'] = function () {
            $auth = new \Globalis\PuppetSkilled\Auth\Authentication();
            return $auth;
        };

        // Datababse
        $container['database.grammar'] = function () {
            return new \Globalis\PuppetSkilled\Database\Query\Grammar\MySqlGrammar();
        };

        $container['db'] = function ($c) {
            if (!isset($c['CI']->db)) {
                $c['CI']->load->database();
            }
            // Insert Get grammar function for ORM
            $c['CI']->db->getQueryGrammar = $c['database.grammar'];
            return $c['CI']->db;
        };

        $container['queryBuilder'] = $container->factory(function ($c) {
            return new \Globalis\PuppetSkilled\Database\Query\Builder($c['CI']->db, $c['database.grammar']);
        });

        $container['session'] = function ($c) {
            if (!isset($c['CI']->session)) {
                $c['CI']->load->library('session');
            }
            return $c['CI']->session;
        };

        // Queue
        $container['queueConnection'] = function ($c) {
            return new \Globalis\PuppetSkilled\Queue\DatabaseQueue($c['db'], 'jobs');
        };

        $container['queueService'] = function ($c) {
            return new \Globalis\PuppetSkilled\Queue\Service($c['queueConnection']);
        };

        // Init ORM
        \Globalis\PuppetSkilled\Database\Magic\Model::setConnectionResolver($container['db']);
        \Globalis\PuppetSkilled\Database\Magic\Model::setEventDispatcher($container['eventDispatcher']);
        \Globalis\PuppetSkilled\Database\Magic\Revisionable\Revision::setUserModel('\App\Model\User');
    }
}
