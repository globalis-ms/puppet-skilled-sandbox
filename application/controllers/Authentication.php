<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\FormValidation;
use \App\Model\User;

class Authentication extends \App\Core\Controller\Base
{
    protected $layout = 'empty';

    protected $isPublic = true;

    public function login()
    {
        if ($this->authenticationService->isLoggedIn()) {
            redirect('frontoffice/home');
        }

        $validator = $this->authenticationService->login();
        if ($validator->isValid()) {
            redirect('frontoffice/home');
        }
        $this->render(['validator' => $validator]);
    }

    public function logout()
    {
        $this->authenticationService->logout();
        redirect('authentication/login');
    }

    public function forgot_password()
    {
        if ($this->authenticationService->isLoggedIn()) {
            redirect('frontoffice/home');
        }

        $validator = new FormValidation();
        $validator->set_rules(
            'username',
            'lang:authentication_label_username',
            [
                'trim',
                [
                    'authentication_error_invalid_reset_account',
                    function ($value) use ($validator) {
                        if ($value !== '') {
                            if ($user = User::where('username', $value)->first()) {
                                $validator->validation_data['userEntity'] = $user;
                                return true;
                            }
                            return false;
                        }
                    }
                ],
                'required',
            ]
        );

        if ($validator->run() === true) {
            $this->sendResetEmail($validator->validation_data['userEntity']);
            $this->flashMessage('lang:authentication_message_token_created', 'lang:general_message_title-success', 'success');
            redirect('authentication/login');
        }
        $this->render(['validator' => $validator]);
    }

    public function reset($token = null)
    {
        $validator = $this->setPassword($token);
        if ($validator->isValid()) {
            $this->flashMessage('lang:authentication_message_password_reset', 'lang:general_message_title-success', 'success');
            redirect('authentication/login');
        }
        $this->render(['validator' => $validator]);
    }

    public function setup($token = null)
    {
        $validator = $this->setPassword($token);
        if ($validator->isValid()) {
            $this->flashMessage('lang:authentication_message_password_setup', 'lang:general_message_title-success', 'success');
            redirect('authentication/login');
        }
        $this->render(['validator' => $validator]);
    }

    private function setPassword($token)
    {
        if ($this->authenticationService->isLoggedIn()) {
            redirect('frontoffice/home');
        }

        if (!($token = $this->authenticationService->retrieveResetToken($token))) {
            redirect('authentication/login');
        }

        $user = User::find($token->user_id);

        $validator = new FormValidation();
        $validator->set_rules(
            'username',
            'lang:authentication_label_username',
            [
                'trim',
                'required',
                [
                    'authentication_error_invalid_reset_account',
                    function ($value) use ($user) {
                        return $user->username === $value;
                    }
                ],
            ]
        );
        $validator->set_rules(
            'password',
            'lang:authentication_label_password',
            [
                'trim',
                [
                    'authentication_error_password_bad_format',
                    function ($value) {
                        if (!empty($value)) {
                            return $this->isValidPassword($value);
                        }
                        return true;
                    }
                ],
                'required',
            ]
        );
        $validator->set_rules(
            'password_confirm',
            'lang:authentication_label_password',
            [
                'trim',
                'matches[password]',
            ]
        );
        if ($validator->run() === true) {
            // Change password
            $user->password = $validator->set_value('password');
            $user->save();
            // Delete Token
            $this->authenticationService->deleteToken($token->token);
        }
        return $validator;
    }

    protected function sendResetEmail($user)
    {
        // Get content
        $token  = $this->authenticationService->registerToken($user);
        $email = new \App\Job\Mailer();

        $content = str_replace(
            [
                '{{link}}',
                '{{first_name}}',
                '{{last_name}}',
                '{{username}}',
            ],
            [
                site_url('authentication/reset/' . $token),
                $user->first_name,
                $user->last_name,
                $user->username,
            ],
            $this->lang->line('authentication_email_content_reset_password')
        );

        $email->to($user->email)
            ->subject($this->lang->line('authentication_email_title_reset_password'))
            ->message($content);
        $this->queueService->dispatch($email);
    }

    private function isValidPassword($password)
    {
        // Minimum 8 characters at least 1 Uppercase Alphabet, 1 Lowercase Alphabet, 1 Number and 1 Special Character
        return (boolean)preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/', $password);
    }
}
