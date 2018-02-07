<?php
namespace App\Service;

class Language extends \Globalis\PuppetSkilled\Service\Base
{
    /**
     * Main Navigation
     * @return string
     */
    public function change($language = null)
    {
        $languagesConfig = $this->config->item('multilingual', 'site_settings');
        if (!$language || !isset($languagesConfig['available'][$language])) {
            $language = $languagesConfig['default'];
        }
        $_SESSION['lang_site'] = $languagesConfig['available'][$language]['value'];
        $_SESSION['lang_local'] = $languagesConfig['available'][$language]['local'];
        $_SESSION['lang_key'] = $language;
        $this->config->set_item('language', $_SESSION['lang_site']);
        $this->config->set_item('language.local', $_SESSION['lang_local']);
        $this->config->set_item('language.key', $_SESSION['lang_key']);
    }

    public function getLanguagesList()
    {
        $items = $this->config->item('multilingual', 'site_settings')['available'];
        foreach ($items as $key => $value) {
            $items[$key] = $value['label'];
        }
        return $items;
    }

    public function getCurrentLanguage()
    {
        return $this->config->item('language.key');
    }
}
