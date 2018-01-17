<?php
namespace App\Service\Secure;

class Company extends \Globalis\PuppetSkilled\Auth\Resource
{
    public function buildFromUserHasRoleid($userhasRoleId)
    {
        $this->resources = [];
        $table = new \App\Model\Resource();
        $pivot = \App\Model\UsersRoles::find($userhasRoleId);
        $resources = $table
            ->where('user_id', $pivot->user_id)
            ->where('resource_type', 'App\Model\Company')
            ->get();
        foreach ($resources as $resource) {
            $this->resources[] = $resource->row_id;
        }
    }
}
