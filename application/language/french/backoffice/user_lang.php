<?php
// Titres
$lang['user_title_index'] = 'Utilisateurs';
$lang['user_title_edit'] = 'Éditer un utilisateur';
$lang['user_title_add'] = 'Ajouter un utilisateur';

// Breadcrumb
$lang['user_breadcrumb_index'] = 'Utilisateurs';
$lang['user_breadcrumb_edit'] = 'Édition';
$lang['user_breadcrumb_add'] = 'Ajout';

// Label
$lang['user_label_username'] = 'Adresse email';
$lang['user_label_password'] = 'Mot de passe';
$lang['user_label_first-name'] = 'Prénom';
$lang['user_label_last-name'] = 'Nom';
$lang['user_label_email'] = 'Courriel';
$lang['user_label_company'] = 'Organisation';
$lang['user_label_phone'] = 'Téléphone';
$lang['user_label_mobile'] = 'Mobile';
$lang['user_label_address_1'] = 'Adresse';
$lang['user_label_address_2'] = 'Complément d\'adresse';
$lang['user_label_postcode'] = 'Code postal';
$lang['user_label_town'] = 'Ville';
$lang['user_label_first-and-last-name'] = 'Prénom et Nom';
$lang['user_label_general'] = 'Général';
$lang['user_label_role'] = 'Rôle';
$lang['user_label_configuration'] = 'Configuration';
$lang['user_label_date_format'] = 'Format d\'affichage des dates';
$lang['user_label_timezone'] = 'Fuseau horaire';
$lang['user_label_enable'] = 'Actif';
$lang['user_label_actions'] = 'Actions';
$lang['user_label_notify'] = 'Notifier l\'utilisateur de la création de son compte';

// Email
$lang['user_email_title_notify_setup'] =  'Mise à disposition de votre compte';
$lang['user_email_content_notify_setup'] = "Bonjour {{first_name}} {{last_name}},"
    . "<p>Votre compte a été créé par un administrateur. Votre identifiant de connexion est **{{username}}**.</p>"
    . "<p>Pour vous connecter, cliquez sur le lien ci-dessous :"
    . "<br/><a href='{{link}}' title='Se connecter à PuppetSkilled'>Se connecter à PuppetSkilled</a></p>";

// Error
$lang['user_error_not_unique_email'] = 'Cet email est utilisé par un autre utilisateur.';
$lang['user_error_company_does_not_exist'] = 'Cette organisation n\'existe pas.';
