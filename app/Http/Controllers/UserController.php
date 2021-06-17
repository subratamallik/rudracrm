<?php

namespace App\Http\Controllers;

use App\Models\CrudModel;
use App\Models\MasterModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function userList(Request $request)
    {
        $where = 'users.role!=51';
        $users = UserModel::getUserList($where);
        $response = [
            'users' => $users
        ];
        //dd($response);
        return view('userList', ['response' => $response]);
    }

    public function userAdd(Request $request)
    {

        $roles = MasterModel::getMasters('user_role');
        $response = [
            'roles' => $roles
        ];
        return view('userAdd', ['response' => $response]);
    }

    public function userAddPost(Request $request)
    {
        $formData = $request->input();
        $payload = [
            'name' => $formData['name'],
            'role' => $formData['roles'],
            'email' => $formData['email'],
            'mobile' => $formData['mobile'],
            'username' => $formData['username'],
            'password' => Hash::make($formData['password']),
        ];
        //dd($payload);
        CrudModel::createNewRecord('users', $payload);
        return redirect()->back()->with('success', 'User has been added successfully!');
    }

    public function userEdit($user_id, Request $request)
    {
        $userDetails = UserModel::getUserDetailsById(decoded($user_id));
        $roles = MasterModel::getMasters('user_role');
        $response = [
            'userDetails' => $userDetails,
            'roles' => $roles
        ];
        return view('userEdit', ['response' => $response]);
    }

    public function userEditPost(Request $request)
    {
        $formData = $request->input();
        $user_id = decoded_secure($formData['user_id']);
        $where = 'users.id=' . $user_id;
        $payload = [
            'name' => $formData['name'],
            'role' => $formData['roles'],
            'email' => $formData['email'],
            'mobile' => $formData['mobile'],
            'username' => $formData['username'],
        ];
        CrudModel::updateRecord('users', $payload, $where);
        return redirect()->back()->with('success', 'User has been updated successfully!');
    }

    public function userEditPassword(Request $request)
    {
        $formData = $request->input();
        $user_id = decoded_secure($formData['user_id']);
        $where = 'users.id=' . $user_id;
        $payload = [
            'password' => Hash::make($formData['password']),
        ];
        CrudModel::updateRecord('users', $payload, $where);
        return redirect()->back()->with('success', 'Password has been updated successfully!');
    }

    public function userAssignCity($user_id, Request $request)
    {
        $city = MasterModel::getMasters('city');
        $userDetails = UserModel::getUserDetailsById(decoded($user_id));
        $city_assigned = UserModel::getAssignedCity(decoded($user_id));
        $response = [
            'city' => $city,
            'city_assigned' => $city_assigned,
            'userDetails' => $userDetails,
        ];
        //dd($response);
        return view('userAssignCity', ['response' => $response]);
    }

    public function userAssignCityPost($user_id, $city_id, Request $request)
    {
        $user_id = decoded($user_id);
        $city_id = decoded($city_id);
        $payload = [
            'user_id' => $user_id,
            'city_id' => $city_id,
            'priority' => 0,
        ];
        CrudModel::createOnDuplicateKey('users_city', $payload);
        return redirect()->back()->with('success', 'City has been assigned successfully!');
    }

    public function userAssignProcess($user_id, Request $request)
    {
        $process = MasterModel::getMasters('process');
        $userDetails = UserModel::getUserDetailsById(decoded($user_id));
        $process_assigned = UserModel::getAssignedProcess(decoded($user_id));
        $response = [
            'process' => $process,
            'process_assigned' => $process_assigned,
            'userDetails' => $userDetails,
        ];
        //dd($response);
        return view('userAssignProcess', ['response' => $response]);
    }

    public function userAssignProcessPost($user_id, $process_id, Request $request)
    {
        $user_id = decoded($user_id);
        $process_id = decoded($process_id);
        $payload = [
            'user_id' => $user_id,
            'process_id' => $process_id,
            'priority' => 0,
        ];
        CrudModel::createOnDuplicateKey('users_process', $payload);
        return redirect()->back()->with('success', 'Process has been assigned successfully!');
    }

    public function userAssignProcessRemove($user_id, $process_id, Request $request)
    {
        $user_id = decoded($user_id);
        $process_id = decoded($process_id);
        $where = 'user_id="' . $user_id . '" AND process_id="' . $process_id . '"';
        //dd($where);
        CrudModel::deleteRecord('users_process', $where);
        return redirect()->back()->with('success', 'Process has been removed successfully!');
    }

    public function userAssignCityRemove($user_id, $city_id, Request $request)
    {
        $user_id = decoded($user_id);
        $city_id = decoded($city_id);
        $where = 'user_id="' . $user_id . '" AND city_id="' . $city_id . '"';
        CrudModel::deleteRecord('users_city', $where);
        return redirect()->back()->with('success', 'City has been removed successfully!');
    }

    public function userProcessPriorityUpdate(Request $request)
    {
        $formData = $request->input();
        foreach ($formData['priority'] as $key => $value) {
            $payload = [
                'priority' => $value
            ];
            $where = 'id=' . $key;
            CrudModel::updateRecord('users_process', $payload, $where);
        }
        return redirect()->back()->with('success', 'Priority has been updated successfully!');
    }
}
