<?php
namespace App\Model;

use Globalis\PuppetSkilled\Database\Magic\Model;
use App\Model\Role;

class User extends Model
{
    use \Globalis\PuppetSkilled\Database\Magic\SoftDeletes;
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;
    use \Globalis\PuppetSkilled\Database\Magic\Lock\Lockable;
    use \Globalis\PuppetSkilled\Database\Magic\Revisionable\Revisionable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    protected $nonRevisionable = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Get the roles record associated with the user.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Model\Role', 'users_roles')->withPivot('id');
    }

    /**
     * Get the company associated with the user.
     */
    public function companies()
    {
        return $this->morphToMany('\App\Model\Company', 'resource', 'resources', 'user_id', 'row_id', true);
    }

    /**
     * Set the user's email
     *
     * @param  string  $value
     * @return void
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['username'] = $value;
        $this->attributes['email'] = $value;
    }

    /**
     * Set the user's password
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = password_hash($value, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /**
     * Set the user's datetime format
     *
     * @param string $value
     * @return void
     */
    public function setDatetimeFormatAttribute($value)
    {
        $this->attributes['datetime_format'] = $value;
        $this->attributes['date_format'] = get_date_format_from_datetime_format($value);
    }

    /**
      * Validate a user against the given password.
      *
      * @param  string  $password
      * @return bool
      */
    public function verifyPassword($password)
    {
        return password_verify($password, $this->attributes['password']);
    }

    public function isAdministrator()
    {
        return in_array(Role::ADMIN, array_pluck($this->roles, 'id'));
    }

    public function isManager()
    {
        return in_array(Role::MANAGER, array_pluck($this->roles, 'id'));
    }

    public function isUser()
    {
        return in_array(Role::USER, array_pluck($this->roles, 'id'));
    }
}
