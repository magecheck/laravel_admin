<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Variable to store current user
     * @var array $user App\User
     */
    protected $user;

    /**
     * Variable to user permission to create
     * @var boolean $_permissionCreate
     */
    protected $_permissionCreate;

    /**
     * Variable to user permission to update
     * @var boolean $_permissionUpdate
     */
    protected $_permissionUpdate;

    /**
     * Variable to user permission to delete
     * @var boolean $_permissionDelete
     */
    protected $_permissionDelete;

    /**
     * Variable to user permission to users
     * @var boolean $_permissionUsers
     */
    protected $_permissionUsers;
    
    
    /**
     * Variable to user permission to export
     * @var boolean $_permissionExport
     */
    protected $_permissionExport;

    /**
     * Variable to store request
     * @var array $request Request
     */
    protected $request;

    /**
     * Setting the request
     * @param  Request  $request
     */
    protected function setRequest(Request $request)
    {
        $this->request = (object) $request;
    }

    /**
     * Getting the request
     * @return array Request $request
     */
    protected function getRequest()
    {
        return (object) $this->request;
    }

    /**
     * Checking create permission
     * 
     * @return boolean $_permissionCreate
     */
    protected function checkPermissionCreate()
    {
        if(!isset($this->_permissionCreate))
        {
            $this->_permissionCreate = (bool) $this->getUser()->hasPermission($this->getRouteName().".create");
        }
        
        return $this->_permissionCreate;
    }

    /**
     * Checking create permission
     * 
     * @return boolean $_permissionUpdate
     */
    protected function checkPermissionUpdate()
    {
        if(!isset($this->_permissionUpdate))
        {
            $this->_permissionUpdate = (bool) $this->getUser()->hasPermission($this->getRouteName().".update");
        }
        
        return $this->_permissionUpdate;
    }

    /**
     * Checking create permission
     * 
     * @return boolean $_permissionDelete
     */
    protected function checkPermissionDelete()
    {
        if(!isset($this->_permissionDelete))
        {
            $this->_permissionDelete = (bool) $this->getUser()->hasPermission($this->getRouteName().".delete");
        }
        
        return $this->_permissionDelete;
    }

    /**
     * Checking users permission
     * 
     * @return boolean $_permissionUsers
     */
    protected function checkPermissionUsers() 
    {
        if(!isset($this->_permissionUsers))
        {
            $this->_permissionUsers = (bool) $this->getUser()->hasPermission($this->getRouteName().".users");
        }
        
        return $this->_permissionUsers;
    }

    /**
     * Checking users permission
     * 
     * @return boolean $_permissionExport 
     */
    protected function checkPermissionExport() 
    {
        if(!isset($this->_permissionExport))
        {
            $this->_permissionExport = (bool) $this->getUser()->hasPermission($this->getRouteName().".export");
        }
        
        return $this->_permissionExport;
    }

    /**
     * Returns route name
     * @return string $_routeName 
     */
    protected function getRouteName()
    {
        return $this->_routeName;
    }

    /**
     * Setting user
     */
    protected function setUser()
    {
        $this->user = (object) Auth::user();
    }

    /**
     * Retrieve current user from request
     * @return object $user App\User
     */
    protected function getUser()
    {
        if(!isset($this->user))
        {
            $this->setUser();
        }
        return $this->user;
    }
}