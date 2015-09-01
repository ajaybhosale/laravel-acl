<?php

namespace Codebank\Acl\Models;

use Illuminate\Database\Eloquent\Model;

class AclRole extends Model {

    public $timestamps = false;

    /**
     * Established relation between user table and role (acl_roles) tables.
     * 
     * @name	users
     * @access	public      
     * @author	AB
     * @return	Object of acl_roles table/data
     */
    public function users()
    {
        try
        {
            return $this->belongsToMany('App\User');
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /**
     * Established relation between acl_permissions table and acl_roles tables.
     * 
     * @name	permissions
     * @access	public      
     * @author	AB
     * @return	Object of acl_permissions table/data
     */
    public function permissions()
    {
        try
        {
            return $this->hasMany('App\AclPermission', 'role_id');
        }
        catch (Exception $e)
        {
            return false;
        }
    }

}
