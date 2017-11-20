<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
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
        'name','leader_id','logo','background'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'groups';

    /**
     * The users that belong to the group.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    
    /**
     * The leader that belong to the group.
     */
    public function leader()
    {
        return $this->hasOne('App\User', 'id', 'leader_id');
    }

    /**
     * Return group id
     * 
     * @return integer $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Update group name
     * 
     * @param string $value - name
     */
    public function setName($value) {
        $this->name = $value;
    }

    /**
     * Return group name
     * 
     * @return string $name
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Update group leader id
     * 
     * @param string $value - leader_id
     */
    public function setLeaderId($value) {
        $this->leader_id = $value;
    }

    /**
     * Return group leader id
     * 
     * @return string $leader_id
     */
    public function getLeaderId() {
        return $this->leader_id;
    }

    /**
     * Update group logo
     * 
     * @param string $value - logo
     */
    public function setLogo($value) {
        $this->logo = $value;
    }

    /**
     * Return group logo
     * 
     * @return string $logo
     */
    public function getLogo() {
        return $this->logo;
    }

    /**
     * Update group background
     * 
     * @param string $value - background
     */
    public function setBackground($value) {
        $this->background = $value;
    }

    /**
     * Return group background
     * 
     * @return string $background
     */
    public function getBackground() {
        return $this->background;
    }
    
    /**
     * Check if group has leader
     * 
     * @return boolean
     */
    public function hasLeader() {
        return (bool) isset($this->leader_id);
    }

    /**
     * Returns groups with only id and name
     * 
     * @return array $groups
     */
    public static function getGroupsToArray() {
        $groups = array();
        foreach (Group::all(['id', 'name'])->toArray() as $group) {
           $groups[$group['id']] = $group['name']; 
        }
        return $groups;
    }

    /**
     * Getting all the groups only id and name
     * @return array Group $groups
     */
    public static function getAllGroupsToArray()
    {
        $group = (object) new Group();
        $groups = $group->all()->toArray();
        $groupsToArray = array();
        foreach ($groups as $group)
        {
            $groupsToArray[$group['id']] = $group['name']; 
        }
        return $groupsToArray;
    }
}
