<?php
$prepend = uniqid();
$item = $this->fetch('item');
?>
<?= form_open($this->fetch('validator'), current_url(), ['class' => 'user_form']) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-dark text-white"><?= lang('company_label_general') ?></h2>
    <div class="card-body">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'name',
                'input_element' => 'form/input',
                'label' => 'lang:company_label_name',
                'id' => $prepend . 'name',
                'default_value' => $item->name ?? null,
            ]
        ) ?>
    </div>
</fieldset>

<?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
</form>
