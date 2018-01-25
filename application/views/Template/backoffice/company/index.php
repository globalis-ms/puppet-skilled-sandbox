<?= $this->element(
    'crud/global_actions',
    [
        'actions' => [
            [
                'uri' => 'backoffice/company/add/',
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
                'label' => 'lang:company_label_name',
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
