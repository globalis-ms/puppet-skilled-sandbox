<?php if (!$this->fetch('item')->isLocked()): ?>
    <?= navigation_anchor(
        'backoffice/company/edit/' . $this->fetch('item')->getRouteKey(),
        '<i class="material-icons">mode_edit</i>',
        [
            'class' => 'btn btn-sm btn-primary',
            'title' => lang('general_action_edit'),
            'data-toggle' => "tooltip",
            'data-placement' => 'top',
        ],
        true,
        false
    ) ?>
    <?php if(route_is_accessible('backoffice/company/delete/' . $this->fetch('item')->getRouteKey())): ?>
    <?= csrf_anchor(
        'backoffice/company/delete/' . $this->fetch('item')->getRouteKey(),
        '<i class="material-icons">delete</i>',
        [
            'class' => 'btn btn-sm btn-danger',
            'title' => lang('general_action_delete'),
            'data-toggle' => "tooltip",
            'data-placement' => 'top',
            'data-confirm' => lang('general_message_delete-confirm')
        ]
    ) ?>
    <?php endif; ?>
<?php else: ?>
    <?= lang('general_message_already-lock') ?>
<?php endif; ?>
