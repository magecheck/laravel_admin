<?php

namespace App;

use Illuminate\Support\Facades\Auth;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The current user.
     *
     * @var object $currentUser App\User
     */
    private $currentUser;
    
    /**
     * The current user role.
     *
     * @var object $currentRole App\Role
     */
    private $currentRole;
    
    /**
     * The current user routes.
     *
     * @var object $currentRoutes App\Route
     */
    private $currentRoutes;

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
        'name', 'username','api_token', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token'
    ];
    
    /**
     * The groups that the user belongs to.
     */
    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }
    
    /**
     * The groups that the user belongs to.
     */
    public function leader()
    {
        return $this->belongsTo('App\Group', 'leader_id');
    }
    
    /**
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    /**
     * The Users that belong to operations.
     */
    public function operations()
    {
        return $this->belongsToMany('App\Operation')->withTimestamps();
    }

    /**
     * Return user id
     * @return integer $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Return user name
     * @return string name
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Update user name
     * 
     * @param string $value - name
     */
    public function setName($value) {
        $this->name = $value;
    }
    
    /**
     * Return App\User attribute username
     * @return string name
     */
    public function getUsername() {
        return $this->username;
    }
    
    /**
     * Update App\User attribute username
     * 
     * @param string $value - username
     */
    public function setUsername($value) {
        $this->username = $value;
    }
    
    /**
     * Return user email
     * @return string email
     */
    public function getEmail() {
        return $this->name;
    }
    
    /**
     * Update user email
     * 
     * @param string $value - email
     */
    public function setEmail($value) {
        $this->email = $value;
    }
    
    /**
     * Return user role_id
     * @return string role_id
     */
    public function getRoleId() {
        return $this->role_id;
    }
    
    /**
     * Update user role_id
     * 
     * @param string $value - role_id
     */
    public function setRoleId($value) {
        $this->role_id = $value;
    }

    /**
     * Sets the user password
     * 
     * @param string $value - password
     */
    public function setPassword($value) {
        $this->password = bcrypt($value);
    }
    
    /**
     * Setting the current user
     */
    public function setCurrentUser() {
        if(!isset($this->currentUser)){
            $this->currentUser = (object) Auth::user();
        }
    }
    
    /**
     * Return current user
     * @return object $user App\User
     */
    public function getCurrentUser() {
        if(!isset($this->currentUser)){
            $this->setCurrentUser();
        }
        return $this->currentUser;
    }
    
    /**
     * Return current user role
     * @return object $currentRole App\Role
     */
    public function getCurrentRole() {
        if(!isset($this->currentRole)){
            $this->setCurrentRole();
        }
        return $this->currentRole;
    }
    
    /**
     * Setting the current user role
     */
    public function setCurrentRole() {
        if(!isset($this->currentRole)){
            $this->currentRole = (object) $this->getCurrentUser()->role();
        }
    }
    
    /**
     * Return current user routes
     * @return object $currentRoutes App\Route
     */
    public function getCurrentRoutes() {
        if(!isset($this->currentRoutes)){
            $this->setCurrentRoutes();
        }
        return $this->currentRoutes;
    }
    
    /**
     * Setting the current user routes
     */
    public function setCurrentRoutes() {
        if(!isset($this->currentRoutes)){
            $this->currentRoutes = (object) $this->getCurrentRole()->with('routes')->first()->routes;
        }
    }
    
    /**
     * Check if user has permission for action
     * @param type $routeName
     * @return boolean
     */
    public function hasPermission($routeName) {
        foreach($this->getCurrentRoutes() as $value){
            if($value->name === $routeName){
                return true;
            }
        }
        return false;
    }
}
