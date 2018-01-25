<!-- Sidebar: account and menu -->
<input type="checkbox" id="sidenav-token">
<label for="sidenav-token" class="Sidenav-overlay"></label>
<section class="Sidenav">
    <header class="Sidenav-header">
        <img class="Sidenav-header-icon" src="<?= $this->asset->getImageLink('icon.png') ?>" alt="Application icon">
<?php /* LANGUAGE SELECTION */ ?>
        <div class="Sidenav-header-lang dropdown">
            <button class="btn btn-inverse btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= html_escape($this->fetch('languages')[$this->fetch('current_language')]) ?>
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
<?php
foreach ($this->fetch('languages') as $key => $label) :
?>
            <?= anchor(
                'miscellaneous/changelanguage/'.$key, $label,
                [
                    'class' => 'dropdown-item'. (($this->fetch('current_language') === $key)? ' active' : '')
                ]
            ) ?>
<?php
endforeach;
?>
            </div>
        </div>
        <h2 class="Sidenav-header-title"><?= app()->config->item('name', 'site_settings') ?></h2>
    </header>
    <aside class="Sidenav-account">
        <div class="Sidenav-account-wrap">
    <img class="Sidenav-account-logo" src="<?= $this->asset->getImageLink('icon.png') ?>" alt="<?= lang('general_label_company_logo') ?>">
            <div class="dropdown">
                <button class="Sidenav-account-name dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= html_escape($this->fetch('user')->first_name . ' ' . $this->fetch('user')->last_name) ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?= anchor('frontoffice/profile', lang('navigation_account'), ['class' => 'dropdown-item']) ?>
                    <div class="dropdown-divider"></div>
                    <?= anchor('authentication/logout', lang('navigation_logout'), ['class' => 'dropdown-item']) ?>
                </div>
            </div>
        </div>
    </aside>
    <nav class="Sidenav-nav">
    <h2><?= lang('navigation_frontoffice') ?></h2>
    <?= navigation_anchor('frontoffice/contact', lang('navigation_frontoffice_contact')) ?>
    <?php if (route_is_accessible('backoffice.*')) : ?>
        <h2><?= lang('navigation_backoffice') ?></h2>
        <?php if (route_is_accessible('backoffice.user')) : ?>
            <ul>
                <?= navigation_anchor('backoffice/user', lang('navigation_backoffice_user')) ?>
            </ul>
        <?php endif; ?>
        <?php if (route_is_accessible('backoffice.company')) : ?>
            <ul>
                <?= navigation_anchor('backoffice/company', lang('navigation_backoffice_company')) ?>
            </ul>
        <?php endif; ?>
    <?php endif; ?>
    </nav>
    <footer class="Sidenav-footer">
    <?php if (!empty($this->fetch('footer_nav'))): ?>
        <ul>
    <?php foreach ($this->fetch('footer_nav') as $nav): ?>
            <li>
                <?= anchor(
                    $nav['uri'],
                    lang_libelle($nav['label'])
                ) ?>
            </li>
    <?php endforeach; ?>
        </ul>
    <?php endif; ?>
        <p>© 2017 <a href="https://github.com/globalis-ms/puppet-skilled-framework" rel="nofollow" target="_blank"><?= app()->config->item('name', 'site_settings') ?></a></p>
        <p><?= sprintf(lang('general_made_by'), '<a href="https://www.globalis-ms.com" rel="nofollow" target="_blank">GLOBALIS</a>') ?></p>
    </footer>
</section>
