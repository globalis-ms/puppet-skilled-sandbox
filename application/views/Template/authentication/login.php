<?php $preprendId = uniqid(); ?>
<?= form_open($this->fetch('validator'), 'authentication/login', ['id' => 'loginForm']) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-dark text-white"><?= lang('authentication_title_login') ?></h2>
    <div class="card-body">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'username',
                'input_element' => 'form/input',
                'label' => 'lang:authentication_label_username',
                'id' =>  $preprendId . 'username',
            ]
        ) ?>
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'password',
                'input_element' => 'form/input',
                'label' => 'lang:authentication_label_password',
                'id' =>  $preprendId . 'password',
                'extra' => [
                    'type' => 'password'
                ]
            ]
        ) ?>
    </div>
</fieldset>
<div class="text-center">
    <button type='submit' class="btn btn-primary"><?= lang('authentication_label_login_submit') ?></button>
    <?= anchor('authentication/forgot_password', lang('authentication_label_forgotpass'), ['class' => 'btn btn-link']) ?>
</div>
</form>
