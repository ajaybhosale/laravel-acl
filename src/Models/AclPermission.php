<?php

namespace Codebank\Acl\Models;

use Illuminate\Database\Eloquent\Model;
use App\User as User;

class AclPermission extends Model {

    /**
     * Making relation between user table and role (acl_roles) tables.
     * 
     * @name	role
     * @access	public      
     * @author	AB
     * @return	Object of acl_roles table/data
     */
    public function role()
    {
        try
        {
            return $this->belongsTo('App\AclRole');
        }
        catch (Exception $e)
        {
            return false;
        }
    }

}
