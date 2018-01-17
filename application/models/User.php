<?php
namespace App\Model;

use App\Model\Relations\UserFonctionPivot;
use Globalis\PuppetSkilled\Database\Magic\Model;

class User extends Model
{
    // use \Globalis\PuppetSkilled\Database\Magic\SoftDeletes;
    use \Globalis\PuppetSkilled\Database\Magic\Uuid;
    use \Globalis\PuppetSkilled\Database\Magic\Lock\Lockable;

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
        'session_id',
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
     * Get the fonction record associated with the user.
     */
    public function fonction()
    {
        return $this->belongsToMany('App\Model\Fonction', 'users_fonctions');
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

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->username;
    }
}
