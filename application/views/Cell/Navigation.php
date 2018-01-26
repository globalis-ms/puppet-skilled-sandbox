<?php
namespace App\View\Cell;

use App\Service\Language\Language;
use App\Service\Notification\Model as NotificationModel;

class Navigation extends \Globalis\PuppetSkilled\View\Cell
{
    /**
     * Default Navigation
     * @return string
     */
    public function default()
    {
        // Load lang
        $this->lang->load('navigation/navigation_default');

        $data = $this->getLanguagesNav();
        $data['footer_nav'] = $this->getFooterNav();
        $data['user'] = $this->authenticationService->user();

        return $this->render(
            'default',
            $data
        );
    }

    public function navbar($data)
    {
        // Load lang
        $this->lang->load('navigation/navigation_default');
        return $this->render(
            'navbar',
            $data
        );
    }

    public function offlineFooter()
    {
        $this->lang->load('navigation/navigation_default');
        $data = $this->getLanguagesNav();
        $data['footer_nav'] = $this->getFooterNav();

        return $this->render(
            'offline_footer',
            $data
        );
    }

    protected function getLanguagesNav()
    {
        $languages = $this->languageService->getLanguagesList();
        $current_language = $this->languageService->getCurrentLanguage();
        return [
            'languages' => $languages,
            'current_language' => $current_language,
        ];
    }

    protected function getFooterNav()
    {
        $footerNav = [];
        return $footerNav;
    }
}
