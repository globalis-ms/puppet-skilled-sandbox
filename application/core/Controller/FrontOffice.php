<?php
namespace App\Core\Controller;

abstract class FrontOffice extends Base
{
    protected $layout = 'default';

    protected $languageDomain = 'frontoffice';

    protected $homeUri = 'frontoffice/home';

    protected function buildPageHelp()
    {
        if (!isset($this->data['page_help'])) {
            // Controller + Method
            list($method) =  array_slice($this->uri->rsegments, 1, 1);
            $toRemove =  array_slice($this->uri->rsegments, 2);
            // Remove form segments
            if (($toRemove = count($toRemove))) {
                $segments = array_slice($this->uri->segments, 0, -count($toRemove));
            } else {
                $segments = $this->uri->segments;
            }
            if (end($segments) != $method) {
                $segments[] = $method;
            }
            $this->data['page_help'] = 'meta:page_help_' . implode('_', $segments);
        }
    }

    protected function render(array $data = [], $template = null)
    {
        $this->buildPageHelp();
        parent::render($data, $template);
    }
}
