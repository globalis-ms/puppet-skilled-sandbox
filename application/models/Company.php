<?php
namespace App\Model;

use Globalis\PuppetSkilled\Database\Magic\Model;

class Company extends Model
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
    protected $table = 'companies';

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
        'name',
    ];

    
    protected $nonRevisionable = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
