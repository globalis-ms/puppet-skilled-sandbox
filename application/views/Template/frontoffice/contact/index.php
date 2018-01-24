<?= $this->block(
    '_filters',
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
                'query_key' => 'last_name',
                'label' => 'lang:contact_label_last_name',
                'formater' => function ($item) {
                    return html_escape($item->last_name);
                }
            ],
            [
                'query_key' => 'first_name',
                'label' => 'lang:contact_label_first_name',
                'formater' => function ($item) {
                    return html_escape($item->first_name);
                }
            ],
            [
                'query_key' => 'company',
                'label' => 'lang:contact_label_company',
                'formater' => function ($item) {
                    if (!empty($item->companies)) {
                        return html_escape($item->companies[0]->name);
                    }
                }
            ],
            [
                'query_key' => 'email',
                'label' => 'lang:contact_label_email',
            ],
            [
                'query_key' => 'phone',
                'label' => 'lang:contact_label_phone',
                'formater' => function ($item) {
                    return phone_format(html_escape($item->phone));
                }
            ],
            [
                'query_key' => 'mobile',
                'label' => 'lang:contact_label_mobile',
                'formater' => function ($item) {
                    return phone_format(html_escape($item->mobile));
                }
            ],
        ],
    ]
) ?>
