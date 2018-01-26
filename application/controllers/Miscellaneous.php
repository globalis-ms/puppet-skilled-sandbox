<?php
defined('BASEPATH') or exit('No direct script access allowed');

use App\Service\Language\Language;

class Miscellaneous extends \App\Core\Controller\Base
{
    protected $isPublic = true;

    protected $layout = 'simple';

    /**
     * Change language
     *
     * @param  string $langue
     */
    public function changelanguage($langue = null)
    {
        $service = new Language();
        $service->change($langue);
        redirect_referrer();
    }

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
