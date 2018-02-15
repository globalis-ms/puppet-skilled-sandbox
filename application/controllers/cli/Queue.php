<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Globalis\PuppetSkilled\Queue\WorkerOptions;
use Globalis\PuppetSkilled\Database\Query\Builder as QueryBuilder;

class Queue extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function __construct()
    {
        parent::__construct();

        // Load email
        if (!class_exists('APP_Email')) {
            app()->load->library('email');
        }
    }

    public function index()
    {
        $this->doJobs();
    }

    public function doJobs()
    {
        $options = new WorkerOptions(0, 128, 60, 3, 10, false);
        $start = time();

        while ($this->queueService->runNextJob('default', $options) !== false && time() - $start < 50) {
        }
    }
}
