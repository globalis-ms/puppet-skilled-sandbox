<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \Globalis\PuppetSkilled\Library\FormValidation;
use \Globalis\PuppetSkilled\Database\Query\Expression;
use \App\Model\User as UserModel;
use \App\Model\Role;
use \App\Model\Company;

class User extends \App\Core\Controller\BackOffice
{
    protected $autoload = [
        'helper' => [
            'form',
            'date'
        ],
    ];

    protected $guards = [
        'index' => 'backoffice.user.view',
        'add' => 'backoffice.user.add',
        'edit' => 'backoffice.user.edit',
        'active_toggle' => 'backoffice.user.edit',
        'delete' => 'backoffice.user.delete',
    ];

    public function index()
    {
        $query = UserModel::query()
            ->with('roles')
            ->with('companies')
            ->with('lock');

        $filters = new QueryFilter(
            [
                'filters' => [
                    'search' => function($query, $value) {
                        return $query
                            ->where('last_name', 'like', $value.'%')
                            ->orWhere('first_name', 'like', $value.'%')
                            ->orWhere('username', 'like', $value.'%')
                            ->orWhere(new Expression('CONCAT(first_name, " ", last_name)'), 'like', $value.'%')
                            ->orWhere(new Expression('CONCAT(last_name, " ", first_name)'), 'like', $value.'%');
                    },
                ],
                'save' => 'backoffice_users_filters',
            ]
        );
        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'name' => 'last_name',
                    'email' => 'email',
                ],
                'save' => 'backoffice_users_pager',
                'unique_order_key' => $query->getModel()->getKeyName()
            ]
        );

        $pager->run($filters->run($query));

        $this->render([
            'filters' => $filters,
            'pager' => $pager,
        ]);
    }

    public function add()
    {
        $this->addOrEdit();
    }

    public function edit($id = null)
    {
        $this->addOrEdit($this->getEditItem($id));
    }

    public function active_toggle($id = null)
    {
        if ($this->input->method() !== 'post' || !($item = $this->getEditItem($id))) {
            redirect_referrer('backoffice/user');
        }
        $item->active = ($item->active? 0 : 1);
        $item->save();
        $item->releaseLock();
        $this->flashMessage('lang:general_message_edit-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/user');
    }

    public function delete($id = null)
    {
        if ($this->input->method() !== 'post' || !($item = $this->getEditItem($id))) {
            redirect_referrer('backoffice/user');
        }
        // Acquire Lock
        if (!$item->acquireLock()) {
            $this->flashMessage('lang:general_message_already-lock', 'lang:general_message_title-error', 'error');
            redirect_referrer('backoffice/user');
        }
        $item->delete();
        $this->flashMessage('lang:general_message_edit-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/user');
    }

    protected function addOrEdit(UserModel $user = null)
    {
        $validator = $this->getValidator($user);
        if (!$validator->run()) {
            $service = $this->languageService;
            $languages = $service->getLanguagesList();
            $companies = array_pluck(Company::get(), 'name', 'id');
            $roles = [
                App\Model\Role::ADMIN => lang('general_label_role_admin'),
                App\Model\Role::MANAGER => lang('general_label_role_manager'),
                App\Model\Role::USER => lang('general_label_role_user'),
            ];
            $this->render([
                'validator' => $validator,
                'languages' => $languages,
                'item' => $user,
                'companies' => $companies,
                'roles' => $roles,
            ]);
        } else {
            $flashMessage = ($user ? 'lang:general_message_edit-success' : 'lang:general_message_add-success');
            $item = ($user ?: new UserModel());
            $item->first_name = $validator->set_value('first_name');
            $item->last_name = $validator->set_value('last_name');
            $item->email = $validator->set_value('email');
            $item->phone = $validator->set_value('phone');
            $item->mobile = $validator->set_value('mobile');
            $item->address_1 = $validator->set_value('address_1');
            $item->address_2 = $validator->set_value('address_2') ?: null;
            $item->postcode = $validator->set_value('postcode');
            $item->town = $validator->set_value('town');
            $item->timezone = $validator->set_value('timezone');
            $item->datetime_format = $validator->set_value('datetime_format');
            $item->language = $validator->set_value('language');
            $item->save();
            if ($this->authenticationService->user()->isAdministrator()) {
                $item->roles()->sync($validator->set_value('role'));
                $item->companies()->sync($validator->set_value('company'));
            } else {
                $item->roles()->sync(Role::USER);
                $item->companies()->sync($this->authenticationService->user()->companies[0]);
            }
            $item->releaseLock();

            // notify user
            if ($validator->set_value('notify') == 1) {
                $token = $this->authenticationService->registerToken($item);
                $email = new \App\Job\Mailer();
                $content = str_replace(
                    [
                        '{{link}}',
                        '{{first_name}}',
                        '{{last_name}}',
                        '{{username}}',
                    ],
                    [
                        site_url('authentication/setup/' . $token),
                        $item->first_name,
                        $item->last_name,
                        $item->username,
                    ],
                    $this->lang->line('user_email_content_notify_setup')
                );

                $email->to($item->email)
                    ->subject($this->lang->line('user_email_title_notify_setup'))
                    ->message($content);
                $this->queueService->dispatch($email);
            }

            // redirect
            $this->flashMessage($flashMessage, 'lang:general_message_title-success', 'success');
            redirect('backoffice/user');
        }
    }

    protected function getEditItem($id)
    {
        if (!$id || !($item = UserModel::find($id)) || !$this->authenticationService->userCanEditUser($item)) {
            redirect_referrer('backoffice/user');
        }
        // Acquire Lock
        if (!$item->acquireLock()) {
            $this->flashMessage('lang:general_message_already-lock', 'lang:general_message_title-error', 'error');
            redirect_referrer('backoffice/user');
        }
        return $item;
    }

    protected function getValidator($user = null)
    {
        $validator = new FormValidation();
        $validator->set_rules(
            'first_name',
            'lang:user_label_first-name',
            [
                'trim',
                'required'
            ]
        );
        $validator->set_rules(
            'last_name',
            'lang:user_label_last-name',
            [
                'trim',
                'required'
            ]
        );
        $validator->set_rules(
            'email',
            'lang:user_label_email',
            [
                'trim',
                'valid_email',
                [
                    'user_error_not_unique_email',
                    function ($value) use ($user) {
                        if (empty($value)) {
                            return true;
                        }
                        if ($user) {
                            $user = UserModel::where('username', $value)->where('id', '!=', $user->id)->count();
                        } else {
                            $user = UserModel::where('username', $value)->count();
                        }
                        if ($user !== 0) {
                            return false;
                        }
                        return true;
                    },
                ],
                'required'
            ]
        );
        $validator->set_rules(
            'company',
            'lang:user_label_company',
            [
                'trim',
                [
                    'user_error_company_does_not_exist',
                    function ($value) {
                        if (empty($value)) {
                            return true;
                        }
                        $company = Company::find($value);
                        if (!$company) {
                            return false;
                        }
                        return $company;
                    }
                ],
                [
                    'required',
                    function ($value) {
                        if ($this->authenticationService->user()->isAdministrator()) {
                            return !empty($value);
                        }
                        return true;
                    }
                ]
            ]
        );
        $validator->set_rules(
            'phone',
            'lang:user_label_phone',
            [
                'trim',
                'required',
                'exact_length[10]',
            ]
        );
        $validator->set_rules(
            'mobile',
            'lang:user_label_mobile',
            [
                'trim',
                'required',
                'exact_length[10]',
            ]
        );
        $validator->set_rules(
            'address_1',
            'lang:user_label_address_1',
            [
                'trim',
                'required',
            ]
        );
        $validator->set_rules(
            'address_2',
            'lang:user_label_address_2',
            [
                'trim',
            ]
        );
        $validator->set_rules(
            'postcode',
            'lang:user_label_postcode',
            [
                'trim',
                'required',
                'exact_length[5]'
            ]
        );
        $validator->set_rules(
            'town',
            'lang:user_label_town',
            [
                'trim',
                'required',
            ]
        );
        if ($this->authenticationService->user()->isAdministrator()) {
            $validator->set_rules(
                'role',
                'lang:user_label_role',
                [
                    'trim',
                    'in_list[' . implode(',', Role::roleList()) . ']',
                    'required',
                ]
            );
        }
        $validator->set_rules(
            'timezone',
            'lang:user_label_timezone',
            [
                'trim',
                'required'
            ]
        );
        $validator->set_rules(
            'datetime_format',
            'lang:user_label_date_format',
            [
                'trim',
                'required'
            ]
        );
        $validator->set_rules(
            'notify',
            'lang:user_label_notify',
            [
                'trim',
            ]
        );
        return $validator;
    }
}
