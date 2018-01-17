<?php
// Page Title
$lang['authentication_title_login'] = 'Identification';
$lang['authentication_title_forgot_password'] = 'Mot de passe perdu ?';
$lang['authentication_title_reset'] = 'Réinitialiser mot de passe';
$lang['authentication_title_setup'] = 'Créer mot de passe';
$lang['authentication_title_renew'] = 'Définir un nouveau mot de passe';

// Labels
$lang['authentication_label_username'] = 'Adresse email';
$lang['authentication_placeholder_username'] = 'Adresse email';
$lang['authentication_label_password'] = 'Mot de passe';
$lang['authentication_placeholder_password'] = 'Mot de passe';
$lang['authentication_label_password_confirm'] = 'Confirmer votre mot de passe';
$lang['authentication_label_login_submit'] = 'Se connecter';
$lang['authentication_label_forgotpass'] = 'Mot de passe perdu ?';
$lang['authentication_label_back-to-login'] = 'Retour à la page de connexion';
$lang['authentication_label_reset_submit'] = 'Réinitialiser mot de passe';
$lang['authentication_label_forgot_submit'] = 'Réinitialiser';
$lang['authentication_label_password_new'] = 'Nouveau mot de passe';
$lang['authentication_label_password_new_confirm'] = 'Confirmer votre nouveau mot de passe';
$lang['authentication_label_renew_submit'] = 'Enregistrer et continuer';
$lang['authentication_label_setup_submit'] = 'Créer mot de passe';
$lang['authentication_label_logout'] = 'Se déconnecter';

// Messages
$lang['authentication_notice_expiration'] = 'Votre mot de passe a expiré. Pour des raisons de sécurité, veuillez définir un nouveau mot de passe avant d\'accéder au site.';
$lang['authentication_message_token_created'] = 'Demande prise en compte, vous allez recevoir un email pour réinitialiser votre mot de passe';
$lang['authentication_message_password_reset'] = 'Votre mot de passe a bien été modifié. Vous pouvez maintenant vous connecter.';
$lang['authentication_message_password_setup'] = 'Votre mot de passe a bien été créé. Vous pouvez maintenant vous connecter.';
$lang['authentication_message_password_renew'] = 'Votre mot de passe a bien été modifié. Vous pouvez maintenant accéder au site.';
$lang['authentication_message_too_many_login_attemps'] = "Votre adresse IP a été bloquée suite à nombre trop important de tentatives de connexion.\nVeuillez réessayer dans %d secondes.";

// Errors
$lang['authentication_error_invalid_reset_account'] = 'Adresse email incorrecte.';
$lang['authentication_error_invalid_account'] = 'Adresse email et/ou mot de passe incorrect.';
$lang['authentication_error_password_bad_format'] = 'Votre mot de passe doit contenir au minimum 8 caractères au moins 1 lettre en majuscules, 1 lettre en minuscules, 1 numéro et 1 caractère spécial (@$!%*?&).';
$lang['authentication_error_password_already_used'] = 'Votre nouveau mot de passe doit être différent du mot de passe actuel.';


// Emails
$lang['authentication_email_title_reset_password'] = 'Réinitialisation de mot de passe';
$lang['authentication_email_content_reset_password'] = '<p>Vous avez reçu cet email car une demande de réinitialisation de mot de passe a été émise pour votre compte.</p>
<p>Cliquez sur le lien ci-dessous et vous serez redirigé vers une page afin de définir un nouveau mot de passe <a href="{{link}}">Réinitialisation de mot de passe</a></p>
<p>Si vous n\'avez pas effectué de demande de réinitialisation de mot de passe, aucune action n\'est requise.</p>';
