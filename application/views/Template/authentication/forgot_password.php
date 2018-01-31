<?php $preprendId = uniqid(); ?>
<?= form_open($this->fetch('validator'), 'authentication/forgot_password', ['class' => 'forgot_password']) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-dark text-white"><?= lang('authentication_title_forgot_password') ?></h2>
    <div class="card-body">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'username',
                'input_element' => 'form/input',
                'label' => 'lang:authentication_label_username',
                'id' =>  $preprendId . 'username'
            ]
        ) ?>
    </div>
</fieldset>
<div class="text-center">
    <button type='submit' class="btn btn-primary"><?= lang('authentication_label_forgot_submit') ?></button>
    <?= anchor('authentication/login', lang('authentication_label_back-to-login'), ['class' => 'btn btn-link']) ?>
</div>
