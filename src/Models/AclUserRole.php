<?php

namespace Codebank\Acl\Models;

use Illuminate\Database\Eloquent\Model;

class AclUserRole extends Model {

    /**
     * Retrive the login users permissions.
     * 
     * @name	getPermissions
     * @access	public      
     * @author	AB
     * @return	Arrya of permissions 
     */
    public static function getPermissions()
    {
        $arrPermission = [];
        try
        {
            $userId = \Auth::user()->id;
            $query  = self::selectRaw('ap.module, ap.action')
                    ->join('acl_permissions AS ap', 'ap.role_id', '=', 'acl_user_roles.role_id')
                    ->where('acl_user_roles.id', '=', $userId)
                    ->where('ap.status', '=', 1);

            $result = $query->get()->toArray();

            if (count($result))
            {
                foreach ($result as $row)
                {
                    $arrPermission[] = $row['module'] . '-' . $row['action'];
                }
            }
            return $arrPermission;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

}
