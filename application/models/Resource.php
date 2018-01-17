<?php
namespace App\Model;

use Globalis\PuppetSkilled\Database\Magic\Model;

class Resource extends Model
{
    protected $table = 'resources';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * Resource morphs to models in resource_type.
     *
     * @return \Globalis\PuppetSkilled\Database\Magic\Relations\MorphTo
     */
    public function resource()
    {
        return $this->morphTo('resource', 'resource_type', 'resource_id');
    }
}
