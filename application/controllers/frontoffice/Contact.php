<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \App\Model\User as User;

class Contact extends \App\Core\Controller\FrontOffice
{
    protected $autoload = [
        'helper' => [
            'form',
        ],
    ];

    public function index()
    {
        $query = User::query()
            ->with('companies');

        $filters = new QueryFilter(
            [
                'filters' => [
                    'last_name' => function ($query, $value) {
                        return $query
                            ->where('last_name', 'like', '%' . $value . '%');
                    },
                    'first_name' => function ($query, $value) {
                        return $query
                            ->where('first_name', 'like', '%' . $value . '%');
                    },
                    'email' => function ($query, $value) {
                        return $query
                            ->where('email', 'like', '%' . $value . '%');
                    },
                    'company' => function ($query, $value) {
                        return $query
                            ->whereHas('companies', function ($query) use ($value) {
                                $query->where('name', 'like', '%' . $value . '%');
                            });
                    },
                ],
                'save' => 'frontoffice_contact_filters',
            ]
        );
        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'last_name' => 'last_name',
                    'first_name' => 'first_name',
                    'email' => 'email',
                ],
                'save' => 'frontoffice_contact_pager',
                'unique_order_key' => $query->getModel()->getKeyName()
            ]
        );

        $pager->run($filters->run($query));

        $this->render([
            'filters' => $filters,
            'pager' => $pager,
        ]);
    }
}
