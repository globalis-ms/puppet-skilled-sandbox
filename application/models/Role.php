<?php
namespace App\Model;

use Globalis\PuppetSkilled\Database\Magic\Model;

class Role extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;

    const ADMIN = 'administrator';
    const MANAGER = 'manager';
    const USER = 'user'; 

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

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
    public $timestamps = true;

    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany('App\Model\Users');
    }

    public function permissions()
    {
        return $this->hasMany('App\Model\Permissions');
    }

    /**
     * Get the role's resources.
     *
     * @param  string  $value
     * @return string
     */
    public function getResourcesSupportAttribute($value)
    {
        return unserialize($value);
    }

    /**
     * Set the role's resources.
     *
     * @param  null|array  $value
     * @return string
     */
    public function setResourcesSupportAttribute($values)
    {
        if (is_array($values)) {
            $this->attributes['resources_support'] = serialize($values);
        } else {
            $this->attributes['resources_support'] = $values;
        }
    }
}
