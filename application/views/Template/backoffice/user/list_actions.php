<?php if (!$this->fetch('item')->isLocked()): ?>

    <?php if (app()->authenticationService->userCanEditUser($this->fetch('item'))) : ?>

        <?= $this->element(
            'crud/active_action',
            ['item' => $this->fetch('item')]
        ) ?>

        <?= navigation_anchor(
            'backoffice/user/edit/' . $this->fetch('item')->getRouteKey(),
            '<i class="material-icons">mode_edit</i>',
            [
                'class' => 'btn btn-sm btn-primary',
                'title' => lang('general_action_edit'),
                'data-toggle' => "tooltip",
                'data-placement' => 'top',
            ],
            false,
            false
        ) ?>

        <?php if ($this->fetch('item')->getKey() != app()->authenticationService->user()->getKey()) : ?>
            <?= csrf_anchor(
                'backoffice/user/delete/' . $this->fetch('item')->getRouteKey(),
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
    <?php endif; ?>

<?php else: ?>
    <?= lang('general_message_already-lock') ?>
<?php endif; ?>
