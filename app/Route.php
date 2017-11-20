<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'routes';
    
    /**
     * The routes that belong to the role.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'route', 'name', 'action'
    ];
}
