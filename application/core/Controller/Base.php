<?php
namespace App\Core\Controller;

abstract class Base extends \Globalis\PuppetSkilled\Controller\Base
{
    protected $layout = 'default';

    protected $autoload = [];

    protected $isPublic = false;

    protected $guards = [];

    protected $languageDomain;

    protected $breadcrumb;

    protected $homeUri = '/';

    public function __construct()
    {
        parent::__construct();

        if ((ENVIRONMENT === 'development' || $this->session->profiler_enabled) && !$this->input->is_ajax_request() && !is_cli()) {
            $this->output->enable_profiler(true);
        }

        // Sécurity
        $this->secureAccess();

        // Load site settings
        $this->config->load('site_settings');

        $this->initializeLang();

        // CSRF Protection check
        if (config_item('csrf_protection') === true && ! is_cli()) {
            $this->security->csrf_verify();
        }

        $this->autoLoader($this->autoload);

        $this->intializeBreadcrumb();
    }

    protected function initializeLang()
    {
        $langueConfig = $this->config->item('multilingual', 'site_settings');
        // Check user agent for language
        if (!$this->session->userdata('lang_site')) {
            $this->load->library('user_agent');
            $_SESSION['lang_site'] = $langueConfig['available'][$langueConfig['default']]['value'];
            $_SESSION['lang_local'] = $langueConfig['available'][$langueConfig['default']]['local'];
            $_SESSION['lang_key'] = $langueConfig['default'];
            foreach ($this->agent->languages() as $lang) {
                if (isset($langueConfig['available'][$lang])) {
                    $_SESSION['lang_site'] = $langueConfig['available'][$lang]['value'];
                    $_SESSION['lang_local'] = $langueConfig['available'][$lang]['local'];
                    $_SESSION['lang_key'] = $lang;
                    break;
                }
            }
        }
        $this->config->set_item('language', $_SESSION['lang_site']);
        $this->config->set_item('language.key', $_SESSION['lang_key']);
        $this->config->set_item('language.local', $_SESSION['lang_local']);

        if ($this->languageDomain) {
            $this->lang->addSubdirectory($this->languageDomain);
        }
        // Ajout des fichiers de langues générique
        if (!empty($langueConfig['autoload'])) {
            foreach ($langueConfig['autoload'] as $lang) {
                $this->load->language($lang);
            }
        }
    }

    protected function secureAccess()
    {
        if (!$this->isPublic) {
            if (!$this->authenticationService->isLoggedIn()) {
                redirect('authentication/login');
            }

            if ($this->getGuardCapability() && !$this->authenticationService->userCan($this->getGuardCapability())) {
                // @TODO CFR log ??
                show_404();
            }
        }
    }

    protected function getGuardCapability()
    {
        $method = $this->router->fetch_method();
        if (isset($this->guards[$method])) {
            return $this->guards[$method];
        }
        return false;
    }

    protected function autoLoader($autoload)
    {
        if (count($autoload) == 0) {
            return;
        }

        /* autoload helpers, plugins, languages */
        foreach (array('helper', 'plugin', 'language') as $type) {
            if (isset($autoload[$type])) {
                foreach ($autoload[$type] as $item) {
                    $this->load->{$type}($item);
                }
            }
        }

        if (isset($autoload['libraries'])) {
            foreach ($autoload['libraries'] as $library => $alias) {
                (is_int($library)) ? $this->load->library($alias) : $this->load->library($library, null, $alias);
            }
        }
    }

    protected function intializeBreadcrumb()
    {
        $this->breadcrumb = [
            'home' => [
                'label' => 'lang:general_breadcrumb_home',
                'uri' =>  $this->homeUri,
            ],
            'controller' => false,
            'method' => false,
            'entity' => false,
        ];

        if ($this->uri->uri_string != $this->homeUri) {
            // Not home page
            $this->breadcrumb['controller'] = [
                'label' => 'lang:' . strtolower($this->router->class) . '_breadcrumb_index',
                'uri' =>  current_base_url(),
            ];
        }
        if ($this->router->method != 'index') {
            $this->breadcrumb['method'] =  [
                'label' => 'lang:' . strtolower($this->router->class) . '_breadcrumb_' . $this->router->method,
                'uri' =>  current_url()
            ];
        }

    }

    protected function setEntityBreadcrumb($string, $routeKey)
    {
        $this->breadcrumb['entity'] =  [
            'label' => $string,
            'uri' =>  current_base_url(true) . '/' . $routeKey
        ];
    }

    protected function flashMessage($message, $title, $template = 'info', $key = 'flash_msg')
    {
        $data = (($this->session->{$key})?: []);
        $data[] = [
            'message' => $message,
            'title' => $title,
            'template' => $template,
        ];
        $_SESSION[$key] = $data;
        $this->session->mark_as_flash($key);
    }

    /**
     * Surcharge sur le render afin de mettre en session el dernier layout utilisé
     */
    protected function render(array $data = [], $template = null)
    {
        $this->data['breadcrumb'] = array_filter($this->breadcrumb);
        parent::render($data, $template);
        if ($this->layout) {
            $this->session->last_layout = $this->layout;
        }
    }
}
