<?php
$prependId = uniqid();
$filters = $this->fetch('filters');
$pagers = $this->fetch('pager');
$baseUrl = $this->fetch('base_url') ?: current_base_url();
?>
<div class="card card-filter mb-4">
    <div class="card-header">
        <?= anchor(
            $baseUrl . '?'.$filters->getActionName().'='.$filters->getResetActionValue(),
            lang('general_action_reset_filters'),
            [
                'class' => 'float-right btn btn-inverse btn-sm'
            ]
        ) ?>
        <?= lang('general_label_total_element') ?> : <?= $pagers['total'] ?>
    </div>
    <div class="card-block">
        <form action="<?= site_url($baseUrl) ?>" method="get" accept-charset="utf-8">
            <?= $this->element(
                'form/input',
                [
                    'input_element' => 'form/input',
                    'name' => 'last_name',
                    'id' => $prependId . 'last_name',
                    'extra' => [
                        'placeholder' => lang('contact_label_last_name'),
                    ],
                    'default_value' => $filters->getValue('last_name'),
                ]
            ) ?>
            <?= $this->element(
                'form/input',
                [
                    'input_element' => 'form/input',
                    'name' => 'first_name',
                    'id' => $prependId . 'first_name',
                    'extra' => [
                        'placeholder' => lang('contact_label_first_name'),
                    ],
                    'default_value' => $filters->getValue('first_name'),
                ]
            ) ?>
            <?= $this->element(
                'form/input',
                [
                    'input_element' => 'form/input',
                    'name' => 'email',
                    'id' => $prependId . 'email',
                    'extra' => [
                        'placeholder' => lang('contact_label_email'),
                    ],
                    'default_value' => $filters->getValue('email'),
                ]
            ) ?>
            <?= $this->element(
                'form/input',
                [
                    'input_element' => 'form/input',
                    'name' => 'company',
                    'id' => $prependId . 'company',
                    'extra' => [
                        'placeholder' => lang('contact_label_company'),
                    ],
                    'default_value' => $filters->getValue('company'),
                ]
            ) ?>
            <div class="float-right">
                <button type='submit' value="<?= $filters->getFilterActionValue() ?>" name="<?= $filters->getActionName() ?>" class='btn btn-secondary'>
                    <?= lang('general_action_filter') ?>
                </button>
            </div>
        </form>
    </div>
</div>
