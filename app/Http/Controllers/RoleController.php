<?php

namespace App\Http\Controllers;

use App\Models\CrudModel;
use App\Models\MasterModel;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function roleManager(Request $request)
    {
        
        $where = 'masters.master_type="user_role"';
        $where .=' AND masters.priority>'.$request->user['priority'];
        $roles = MasterModel::getMastersRoles($where);
        $modules = CrudModel::readData('modules');
        $role_manager = CrudModel::readData('role_manager');
        $role_manager_data = [];
        foreach ($role_manager as $item) {
            $role_manager_data[$item->role_id] = $item->module_id;
        }
        $response = [
            'roles' => $roles,
            'modules' =>  $modules,
            'role_manager' =>  $role_manager_data,
        ];
        return view('roleManager', ['response' => $response]);
    }

    public function roleManagerUpdate(Request $request)
    {
        $formData = $request->input();
        foreach ($formData['module'] as $key => $value) {
            $payload[] = [
                "role_id" => $key,
                "module_id" => implode(',', $value),
            ];
        }
        CrudModel::createOnDuplicateKey('role_manager', $payload);
        return redirect()->back()->with('success', 'Role has been configured successfully!');
    }
}
