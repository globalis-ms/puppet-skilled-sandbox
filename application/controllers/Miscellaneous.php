<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Miscellaneous extends \App\Core\Controller\Base
{
    protected $isPublic = true;

    protected $layout = 'simple';

    /**
     * 404 Error
     */
    public function not_found()
    {
        // Display 404 only if user is logged in
        $this->mustLoggedIn();
        $this->layout = ($this->session->last_layout ?: 'default');
        $this->breadcrumb = [];
        $this->output->set_status_header(404);
        $this->render(['page_title' => 'lang:general_title_not_found'], 'error/404');

    }

    private function mustLoggedIn()
    {
        if (!$this->authenticationService->isLoggedIn()) {
            redirect('authentication/login');
        }
    }
}
