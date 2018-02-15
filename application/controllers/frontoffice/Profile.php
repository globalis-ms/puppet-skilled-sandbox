<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\FormValidation;
use App\Model\User;

class Profile extends \App\Core\Controller\FrontOffice
{
    protected $autoload = [
        'helper' => [
            'form',
            'date'
        ],
    ];

    public function index()
    {
        $item = $this->authenticationService->user();

        // Acquire Lock
        if (!$item->acquireLock()) {
            $this->flashMessage('lang:general_message_already-lock', 'lang:general_message_title-error', 'error');
            redirect_referrer('frontoffice/profile');
        }

        $validator = $this->getValidator($item);
        if (!$validator->run()) {
            $languages = $this->languageService->getLanguagesList();

            $this->render([
                'validator' => $validator,
                'item' => $item,
                'languages' => $languages,
            ]);
        } else {
            $item->email = $validator->set_value('email');
            $item->phone = $validator->set_value('phone');
            $item->mobile = $validator->set_value('mobile');
            $item->address_1 = $validator->set_value('address_1');
            $item->address_2 = $validator->set_value('address_2') ?: null;
            $item->postcode = $validator->set_value('postcode');
            $item->language = $validator->set_value('language');
            $item->town = $validator->set_value('town');
            $item->timezone = $validator->set_value('timezone');
            // @TODO GERER DATE FORMAT !
            $item->datetime_format = $validator->set_value('datetime_format');
            if (!empty($validator->set_value('password'))) {
                $item->password = $validator->set_value('password');
            }
            $item->update();
            $item->releaseLock();
            // Update language
            $this->languageService->change($item->language);
            $this->flashMessage('lang:general_message_edit-success', 'lang:general_message_title-success', 'success');
            redirect('frontoffice/profile');
        }
    }

    protected function getValidator(User $user)
    {
        $validator = new FormValidation();
        $validator->set_rules(
            'email',
            'lang:profile_label_email',
            [
                'trim',
                'valid_email',
                [
                    'profile_error_not_unique_email',
                    function ($value) use ($user) {
                        if (empty($value)) {
                            return true;
                        }
                        $user = User::where('username', $value)->where('id', '!=', $user->id)->count();
                        if ($user !== 0) {
                            return false;
                        }
                        return true;
                    }
                ],
                'required'
            ]
        );
        $validator->set_rules(
            'phone',
            'lang:profile_label_phone',
            [
                'trim',
                'required',
                'exact_length[10]',
            ]
        );
        $validator->set_rules(
            'mobile',
            'lang:profile_label_mobile',
            [
                'trim',
                'required',
                'exact_length[10]',
            ]
        );
        $validator->set_rules(
            'address_1',
            'lang:profile_label_address_1',
            [
                'trim',
                'required',
            ]
        );
        $validator->set_rules(
            'address_2',
            'lang:profile_label_address_2',
            [
                'trim',
            ]
        );
        $validator->set_rules(
            'postcode',
            'lang:profile_label_postcode',
            [
                'trim',
                'required',
                'exact_length[5]'
            ]
        );
        $validator->set_rules(
            'town',
            'lang:profile_label_town',
            [
                'trim',
                'required',
            ]
        );
        $validator->set_rules(
            'password',
            'lang:profile_label_password',
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
                ]
            ]
        );
        $validator->set_rules(
            'password_confirm',
            'lang:profile_label_password_confirm',
            [
                'trim',
                'matches[password]',
            ]
        );
        $validator->set_rules(
            'language',
            'lang:profile_label_language',
            [
                'trim',
                'required',
                'in_list[' . implode(',', array_keys($this->languageService->getLanguagesList())) . ']',
            ]
        );
        $validator->set_rules(
            'timezone',
            'lang:profile_label_timezone',
            [
                'trim',
                'required'
            ]
        );
        $validator->set_rules(
            'date_format',
            'lang:profile_label_date_format',
            [
                'trim',
                'required'
            ]
        );
        return $validator;
    }

    private function isValidPassword($password)
    {
        // Minimum 8 characters at least 1 Uppercase Alphabet, 1 Lowercase Alphabet, 1 Number and 1 Special Character
        return (boolean)preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/', $password);
    }
}
