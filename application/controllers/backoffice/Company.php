<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \Globalis\PuppetSkilled\Library\FormValidation;
use \App\Model\Company as CompanyModel;

class Company extends \App\Core\Controller\BackOffice
{
    protected $autoload = [
        'helper' => [
            'form',
        ],
    ];

    protected $guards = [
        'index' => 'backoffice.company.view',
        'add' => 'backoffice.company.add',
        'edit' => 'backoffice.company.edit',
        'delete' => 'backoffice.company.delete',
    ];

    public function index()
    {
        $query = CompanyModel::query()
            ->with('lock');

        $filters = new QueryFilter(
            [
                'filters' => [
                    'search' => function ($query, $value) {
                        return $query->where('name', 'like', $value.'%');
                    },
                ],
                'save' => 'backoffice_companies_filters',
            ]
        );
        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'name' => 'name',
                ],
                'save' => 'backoffice_companies_pager',
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

    public function delete($id = null)
    {
        if ($this->input->method() !== 'post' || !$id ||  !($item = CompanyModel::find($id))) {
            redirect_referrer('backoffice/company');
        }
        // Acquire Lock
        if (!$item->acquireLock()) {
            $this->flashMessage('lang:general_message_already-lock', 'lang:general_message_title-error', 'error');
            redirect_referrer('backoffice/company');
        }
        $item->delete();
        $this->flashMessage('lang:general_message_edit-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/company');
    }

    protected function addOrEdit(CompanyModel $company = null)
    {
        $validator = $this->getValidator();
        if (!$validator->run()) {
            $service = $this->languageService;
            $languages = $service->getLanguagesList();
            $this->render([
                'validator' => $validator,
                'languages' => $languages,
                'item' => $company,
            ]);
        } else {
            $flashMessage = ($company ? 'lang:general_message_edit-success' : 'lang:general_message_add-success');
            $item = ($company ?: new CompanyModel());
            $item->name = $validator->set_value('name');
            $item->save();
            $item->releaseLock();
            // redirect
            $this->flashMessage($flashMessage, 'lang:general_message_title-success', 'success');
            redirect('backoffice/company');
        }
    }

    protected function getEditItem($id)
    {
        if (!$id ||  !($item = CompanyModel::find($id))) {
            redirect_referrer('backoffice/company');
        }
        // Acquire Lock
        if (!$item->acquireLock()) {
            $this->flashMessage('lang:general_message_already-lock', 'lang:general_message_title-error', 'error');
            redirect_referrer('backoffice/company');
        }
        return $item;
    }

    protected function getValidator()
    {
        $validator = new FormValidation();
        $validator->set_rules(
            'name',
            'lang:company_label_name',
            [
                'trim',
                'required'
            ]
        );
        return $validator;
    }
}
