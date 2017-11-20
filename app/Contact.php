<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
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
        'name','email','phone','message'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'contacts';
    
    /**
     * Update contact name
     */
    public function setName($value) {
        $this->name = $value;
    }

    /**
     * Return contact name
     * @return string $name
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Update contact email
     */
    public function setEmail($value) {
        $this->email = $value;
    }

    /**
     * Return contact email
     * @return string $email
     */
    public function getEmail() {
        return $this->email;
    }
    
    /**
     * Update contact phone
     */
    public function setPhone($value) {
        $this->phone = $value;
    }

    /**
     * Return contact phone
     * @return string $phone
     */
    public function getPhone() {
        return $this->phone;
    }
    
    /**
     * Update contact message
     */
    public function setMessage($value) {
        $this->message = $value;
    }

    /**
     * Return contact message
     * @return string $message
     */
    public function getMessage() {
        return $this->message;
    }
}
