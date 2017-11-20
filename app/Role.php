<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'roles';
    
    /**
     * Update role name
     */
    public function setName($value) {
        $this->name = $value;
    }

    /**
     * Return role name
     * @return string name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * The users that belong to the group.
     */
    public function routes()
    {
        return $this->belongsToMany('App\Route');
    }

    /**
     * Getting all the roles only id and name
     * @return array Role $role
     */
    public static function getAllRolesToArray()
    {
        $roles = array();
        foreach (Role::all(['id', 'name'])->toArray() as $role) {
           $roles[$role['id']] = $role['name']; 
        }
        return $roles;
    }
}
