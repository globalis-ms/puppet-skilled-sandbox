<?php $preprendId = uniqid(); ?>
<?= form_open($this->fetch('validator'), 'authentication/login', ['id' => 'loginForm']) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('authentication_title_login') ?></h2>
    <div class="card-block">
        <?php $error = form_error('username', '<div class="form-control-feedback"><i class="material-icons">warning</i> ', '</div>')?>
        <div class="form-group<?= ($error ? ' has-danger' : '')?>">
            <?= $this->element('form/label',
                [
                    'field' => 'username',
                    'label' => 'lang:authentication_label_username',
                    'extra' => [
                        'for' => $preprendId . 'username'
                    ]
                ]
            ) ?>
            <input type='text' name="username" class="form-control<?= (form_error('username')? ' form-control-danger' : '') ?>" id='<?= $preprendId ?>username' value="<?= set_value('username') ?>">
            <?= $error ?>
        </div>
        <?php $error = form_error('password', '<div class="form-control-feedback"><i class="material-icons">warning</i> ', '</div>')?>
        <div class="form-group<?= ($error ? ' has-danger' : '')?>">
            <?= $this->element('form/label',
                [
                    'field' => 'password',
                    'label' => 'lang:authentication_label_password',
                    'extra' => [
                        'for' => $preprendId . 'password'
                    ]
                ]
            ) ?>
            <input type='password' name="password" class="form-control<?= (form_error('password')? ' form-control-danger' : '') ?>" id='<?= $preprendId ?>password'>
            <?= $error ?>
        </div>
    </div>
</fieldset>
<div class="text-center">
    <button type='submit' class="btn btn-primary"><?= lang('authentication_label_login_submit') ?></button>
    <?= anchor('authentication/forgot_password', lang('authentication_label_forgotpass'), ['class' => 'btn btn-link']) ?>
</div>
</form>
