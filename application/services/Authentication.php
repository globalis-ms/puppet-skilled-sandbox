<?php

namespace App\Service;

class Authentication extends \Globalis\PuppetSkilled\Auth\Authentication
{
    public function userCanEditUser($user)
    {
        return $this->authenticationService->userCan(
            'backoffice.user',
            'App\\Service\\Secure\\Company',
            !empty($user->companies) ? $user->companies[0]->getKey() : null
        ) && (
            $this->authenticationService->user()->roles[0]->getKey() == 'administrator'
            || $user->roles[0]->getKey() != 'administrator'
        );
    }
}
