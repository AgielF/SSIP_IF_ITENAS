<?php

namespace App\Models;

use CodeIgniter\Model;

class RolePermissionModel extends Model
{
    protected $table            = 'role_permissions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['role_id', 'menu_key'];

    // Dates
    protected $useTimestamps = false;
    
    /**
     * Get allowed menu keys for a specific role
     */
    public function getRoleMenus($roleId)
    {
        $records = $this->where('role_id', $roleId)->findAll();
        $menus = [];
        foreach ($records as $row) {
            $menus[] = $row['menu_key'];
        }
        return $menus;
    }
    
    /**
     * Update permissions for a role
     */
    public function updateRolePermissions($roleId, $menuKeys)
    {
        $this->db->transStart();
        
        // Delete existing permissions for this role
        $this->where('role_id', $roleId)->delete();
        
        // Insert new ones
        if (!empty($menuKeys) && is_array($menuKeys)) {
            $data = [];
            foreach ($menuKeys as $key) {
                $data[] = [
                    'role_id' => $roleId,
                    'menu_key' => $key
                ];
            }
            $this->insertBatch($data);
        }
        
        $this->db->transComplete();
        return $this->db->transStatus();
    }
}
