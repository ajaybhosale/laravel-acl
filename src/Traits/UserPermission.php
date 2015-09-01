<?php

namespace Codebank\Acl\Traits;

trait UserPermission {

    /**
     * Role names which login user belonging to.
     *
     * @var array
     */
    public $userRoles = [];

    /**
     * Established relation between user table and role (acl_roles) tables.
     * 
     * @name	role
     * @access	public      
     * @author	AB
     * @return	Object of acl_roles table/data
     */
    public function role()
    {         
        return $this->belongsToMany('Codebank\Acl\Models\AclRole', 'acl_user_roles', 'user_id', 'role_id');
    }

    /**
     * Will check user has access to given module and action
     * 
     * @name	checkPermission
     * @access	public
     * @author	AB	 
     * @param	$module  String  Module name which has to check
     * @param	$action  String  Action name which has to check
     * @return	Boolean  If user has access permission then it will return true else false
     */
    public function checkPermission($module, $action)
    {
        $hasRoles = $this->_getUserRoles();
        $roleIds  = '';
        if (count($hasRoles))
        {
            foreach ($hasRoles as $role)
            {
                $roleIds[] = $role->id;
            }

            return $this->_hasPermission($roleIds, $module, $action);
        }
        else
        {
            return false;
        }
    }

    /**
     * Will check user has access to given module and action
     * 
     * @name	_hasPermission
     * @access	private      
     * @author	AB
     * @param	$roleIds    Array  Roles ids
     * @param	$module     String  Module name which has to check
     * @param	$action     String  Action name which has to check
     * @return	Boolean  If user has access permission then it will return true else false
     */
    private function _hasPermission($roleIds, $module, $action)
    {        
        try
        {
            $query  = self::selectRaw('count(users.id) as hasPermission')
                    ->join('acl_user_roles AS aur', 'aur.user_id', '=', 'users.id')
                    ->join('acl_roles AS ar', 'ar.id', '=', 'aur.role_id')
                    ->join('acl_permissions AS ap', 'ap.role_id', '=', 'ar.id')
                    ->where('users.id', '=', $this->id)
                    ->whereIn('ap.role_id', $roleIds)
                    ->where('ap.module', '=', $module)
                    ->where('ap.action', '=', $action)
                    ->where('ap.status', '=', 1);
            $result = $query->get()->toArray();
            return $result[0]['hasPermission'] ? true : false;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /**
     * Get the roles id which are associated with login user
     * 
     * @name	_getUserRoles
     * @access	private      
     * @author	AB
     * @return	Object and will return roles id
     */
    private function _getUserRoles()
    {
        try
        {
            return $this->role()->select('acl_roles.id')->getResults();
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /**
     * Check login user having permission for given action and module
     * 
     * @name	can
     * @access	public      
     * @author	AB
     * @param	$action     String  Action name which has to check
     * @param	$module     String  Module name which has to check
     * @return	Boolean true or false
     */
    public function can($action, $module)
    {        
        $availablePermission = \Config::get('view.permission');
        $actionRequest       = strtolower($module . '-' . $action);

        if (is_array($availablePermission))
        {
            return in_array($actionRequest, $availablePermission) ? true : false;
        }

        return false;
    }

}
