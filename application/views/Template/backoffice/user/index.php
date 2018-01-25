<?= $this->element(
    'crud/global_actions',
    [
        'actions' => [
            [
                'uri' => 'backoffice/user/add/',
                'label' =>  '<i class="material-icons">add</i> ' .  lang('general_action_add'),
                'extra' => [
                    'title' => lang('general_action_add'),
                    'class' => 'btn btn-primary',
                ]
            ]
        ]
    ]
) ?>

<?= $this->element(
    'crud/default_filter',
    [
        'filters' => $this->fetch('filters'),
        'pager' => $this->fetch('pager')->getResult()
    ]
) ?>

<?= $this->element(
    'crud/list',
    [
        'pager'  => $this->fetch('pager'),
        'displayed_fields' => [
            [
                'query_key' => 'name',
                'label' => 'lang:user_label_first-and-last-name',
                'formater' => function ($item) {
                    return html_escape($item->first_name . ' ' . $item->last_name);
                }
            ],
            [
                'query_key' => 'company',
                'label' => 'lang:user_label_company',
                'formater' => function ($item) {
                    if (!empty($item->companies)) {
                        return html_escape($item->companies[0]->name);
                    }
                }
            ],
            [
                'query_key' => 'email',
                'label' => 'lang:user_label_email',
            ],
            [
                'query_key' => 'role',
                'label' => 'lang:user_label_role',
                'formater' => function ($item) {
                    $role = '';
                    switch ($item->roles[0]->id) {
                        case App\Model\Role::ADMIN:
                            $role = lang('general_label_role_admin');
                            break;
                        case App\Model\Role::MANAGER:
                            $role = lang('general_label_role_manager');
                            break;
                        case App\Model\Role::USER:
                            $role = lang('general_label_role_user');
                            break;
                    }
                    return $role;
                }
            ],
            [
                'label' => '',
                'class' => 'table-actions',
                'formater' => function ($item) {
                    return $this->block('list_actions', ['item' => $item]);
                }
            ],
        ],
    ]
) ?>
