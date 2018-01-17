<?php
namespace App\Model;

class Permissions extends \Globalis\PuppetSkilled\Database\Magic\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles_permissions';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
