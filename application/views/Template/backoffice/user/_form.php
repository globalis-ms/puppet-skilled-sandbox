<?php
$prepend = uniqid();
$item = $this->fetch('item');
?>
<?= form_open($this->fetch('validator'), current_url(), ['class' => 'user_form']) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-dark text-white"><?= lang('user_label_general') ?></h2>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6">
            <?= $this->element(
                'form/block_input',
                [
                    'name' => 'first_name',
                    'input_element' => 'form/input',
                    'label' => 'lang:user_label_first-name',
                    'id' => $prepend . 'first_name',
                    'default_value' => $item->first_name ?? null,
                ]
            ) ?>
            </div>
            <div class="col-lg-6">
            <?= $this->element(
                'form/block_input',
                [
                    'name' => 'last_name',
                    'input_element' => 'form/input',
                    'label' => 'lang:user_label_last-name',
                    'id' => $prepend . 'last_name',
                    'default_value' => $item->last_name ?? null,
                ]
            ) ?>
            </div>
        </div>

        <?= $this->element(
            'form/block_input',
            [
                'name' => 'email',
                'input_element' => 'form/input',
                'label' => 'lang:user_label_email',
                'id' => $prepend . 'email',
                'default_value' => $item->email ?? null,
            ]
        ) ?>

        <?php if (app()->authenticationService->user()->isAdministrator()) : ?>
            <?= $this->element(
                'form/block_input',
                [
                    'name' => 'company',
                    'input_element' => 'form/select',
                    'label' => 'lang:user_label_company',
                    'id' => $prepend . 'company',
                    'default_value' => !empty($item->companies) ? $item->companies[0]->getKey() : null,
                    'options' => $this->fetch('companies'),
                ]
            ) ?>
        <?php else : ?>
            <?= $this->element(
                'form/block_input',
                [
                    'name' => 'company',
                    'input_element' => 'form/info',
                    'label' => 'lang:user_label_company',
                    'id' => $prepend . 'company',
                    'default_value' => app()->authenticationService->user()->companies[0]->name
                ]
            ) ?>
        <?php endif ?>

        <div class="row">
            <div class="col-lg-6">
            <?= $this->element(
                'form/block_input',
                [
                    'name' => 'phone',
                    'input_element' => 'form/input',
                    'label' => 'lang:user_label_phone',
                    'id' => $prepend . 'phone',
                    'default_value' => $item->phone ?? null
                ]
            ) ?>
            </div>
            <div class="col-lg-6">
            <?= $this->element(
                'form/block_input',
                [
                    'name' => 'mobile',
                    'input_element' => 'form/input',
                    'label' => 'lang:user_label_mobile',
                    'id' => $prepend . 'mobile',
                    'default_value' => $item->mobile ?? null
                ]
            ) ?>
            </div>
        </div>
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'address_1',
                'input_element' => 'form/input',
                'label' => 'lang:user_label_address_1',
                'id' => $prepend . 'address_1',
                'default_value' => $item->address_1 ?? null
            ]
        ) ?>
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'address_2',
                'input_element' => 'form/input',
                'label' => 'lang:user_label_address_2',
                'id' => $prepend . 'address_2',
                'default_value' => $item->address_2 ?? null
            ]
        ) ?>
        <div class="row">
            <div class="col-lg-6">
                <?= $this->element(
                    'form/block_input',
                    [
                        'name' => 'postcode',
                        'input_element' => 'form/input',
                        'label' => 'lang:user_label_postcode',
                        'id' => $prepend . 'postcode',
                        'default_value' => $item->postcode ?? null
                    ]
                ) ?>
            </div>
            <div class="col-lg-6">
                <?= $this->element(
                    'form/block_input',
                    [
                        'name' => 'town',
                        'input_element' => 'form/input',
                        'label' => 'lang:user_label_town',
                        'id' => $prepend . 'town',
                        'default_value' => $item->town ?? null
                    ]
                ) ?>
            </div>
        </div>
    </div>
</fieldset>
<fieldset class="card mb-4">
    <h2 class="card-header bg-dark text-white"><?= lang('user_label_role') ?></h2>
    <div class="card-body">
        <?php if (app()->authenticationService->user()->isAdministrator()) : ?>
            <?= $this->element(
                'form/block_input',
                [
                    'name' => 'role',
                    'input_element' => 'form/select',
                    'label' => 'lang:user_label_role',
                    'id' => $prepend . 'role',
                    'options' => $this->fetch('roles'),
                    'default_value' => $item ? $item->roles[0]->getKey() : null,
                ]
            ) ?>
        <?php else : ?>
            <?= $this->element(
                'form/block_input',
                [
                    'name' => 'role',
                    'input_element' => 'form/info',
                    'label' => 'lang:user_label_role',
                    'id' => $prepend . 'role',
                    'default_value' => $item ? lang('general_label_role_' . $item->roles[0]->getKey()) : lang('general_label_role_user'),
                ]
            ) ?>
        <?php endif ?>
    </div>
</fieldset>

<fieldset class="card mb-4">
    <h2 class="card-header bg-dark text-white"><?= lang('user_label_configuration') ?></h2>
    <div class="card-body">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'datetime_format',
                'input_element' => 'form/select',
                'label' => 'lang:user_label_date_format',
                'id' => $prepend . 'datetime_format',
                'default_value' => $item->datetime_format ?? null,
                'options' => date_format_list(),
            ]
        ) ?>
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'timezone',
                'input_element' => 'form/select',
                'label' => 'lang:user_label_timezone',
                'id' => $prepend . 'timezone',
                'default_value' => $item->timezone ?? null,
                'options' => timezone_list(),
            ]
        ) ?>
    </div>
</fieldset>

<?php if (!$item || !$item->password): ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-dark text-white"><?= lang('user_label_actions') ?></h2>
    <div class="card-body">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'notify',
                'input_element' => 'form/radio_inline',
                'label' => 'lang:user_label_notify',
                'id' => $prepend . 'notify',
                'options' => [
                    '1' => 'lang:general_label_yes',
                    '0' => 'lang:general_label_no',
                ],
                'default_value' => '0',
            ]
        ) ?>
    </div>
</fieldset>
<?php endif; ?>

<?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
</form>
