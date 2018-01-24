<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('lang_libelle')) {
    /**
     * lang_libelle
     *
     * @param    string    $libelle        The language line
     * @return   string
     */
    function lang_libelle($libelle, $escape = true)
    {

        if (sscanf($libelle, 'lang:%s', $line) === 1 && false === ($libelle = lang($line))) {
            return $line;
        }

        return ($escape ? html_escape($libelle) : $libelle);
    }
}

if (!function_exists('phone_format')) {
    function phone_format($phone)
    {
        return preg_replace('#^([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})$#', '$1 $2 $3 $4 $5', $phone);
    }
}
