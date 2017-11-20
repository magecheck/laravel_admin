<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
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
        'name','system','type','value'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'configs';
    
    /**
     * Return config id
     * @return string $id
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Update config name
     */
    public function setName($value) {
        $this->name = $value;
    }

    /**
     * Return config name
     * @return string $name
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Update config system
     */
    public function setSystem($value) {
        $this->system = $value;
    }

    /**
     * Return config system
     * @return string $system
     */
    public function getSystem() {
        return $this->system;
    }
    
    /**
     * Update config name
     */
    public function setType($value) {
        $this->type = $value;
    }

    /**
     * Return config type
     * @return string $type
     */
    public function getType() {
        return $this->type;
    }
    
    /**
     * Update config value
     */
    public function setValue($value) {
        $this->value = $value;
    }

    /**
     * Return config value
     * @return string $value
     */
    public function getValue() {
        return $this->value;
    }
    
    /**
     *  Load the config knowing it's name
     * @param string $param
     * @return object Config
     */
    public function getConfigByName($param) {
        return Config::where('name', $param)->get();
    }
    
}
