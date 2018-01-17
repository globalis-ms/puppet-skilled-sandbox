<?php $preprendId = uniqid(); ?>
<?= form_open($this->fetch('validator'), current_url(), ['class' => $this->fetch('form_class')]) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang($this->fetch('form_title_lang')) ?></h2>
    <?php if ($this->fetch('renew_password')): ?>
    <div class="alert alert-warning"><?= lang('authentication_notice_expiration') ?></div>
    <?php endif ?>
    <div class="card-block">
        <?php if (!$this->fetch('renew_password')): ?>
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'username',
                'input_element' => 'form/input',
                'label' => 'lang:authentication_label_username',
                'id' =>  $preprendId . 'username',
            ]
        ) ?>
        <?php endif ?>

        <?= $this->element(
            'form/block_input',
            [
                'name' => 'password',
                'input_element' => 'form/input',
                'label' => $this->fetch('lang_password') ?: 'lang:authentication_label_password',
                'id' => $preprendId . 'password',
                'default_value' => '',
                'extra' => [
                    'type' => 'password'
                ]
            ]
        ) ?>

        <?= $this->element(
            'form/block_input',
            [
                'name' => 'password_confirm',
                'input_element' => 'form/input',
                'label' => $this->fetch('lang_password_confirm') ?: 'lang:authentication_label_password_confirm',
                'id' => $preprendId . 'password_confirm',
                'default_value' => '',
                'extra' => [
                    'type' => 'password'
                ]
            ]
        ) ?>
    </div>
</fieldset>
<div class="text-center">
    <button type='submit' class="btn btn-primary"><?= lang($this->fetch('form_submit_lang')) ?></button>
    <?php if ($this->fetch('renew_password')): ?>
    <a href="<?= site_url('authentication/logout') ?>" class="btn btn-link"><?= lang('authentication_label_logout') ?></button>
    <?php else: ?>
    <?= anchor('authentication/login', lang('authentication_label_back-to-login'), ['class' => 'btn btn-link']) ?>
    <?php endif ?>
</div>
</form>
