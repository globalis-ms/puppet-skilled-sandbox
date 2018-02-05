<?php
namespace App\Core\Controller;

abstract class FrontOffice extends Base
{
    protected $layout = 'default';

    protected $languageDomain = 'frontoffice';

    protected $homeUri = 'frontoffice/home';
}
