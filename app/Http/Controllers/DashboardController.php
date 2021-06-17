<?php

namespace App\Http\Controllers;

use App\Models\CrudModel;
use App\Models\MasterModel;
use App\Models\PostModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $logged_user = session('logged_user');
       // dd($logged_user);
        $total_nasters = MasterModel::countMaters();
        $total_users = UserModel::countUsers();
        $where = 'post.next_action_priority>0 AND post.next_action_date >= CURDATE()';
        //$where .= ' AND post.next_action_time >= CURTIME()';
        if ($logged_user['role'] != env('ADMIN_ID')) {
            $where .= ' AND assigned_user_id=' . $logged_user['id'];
        }
        $total_cases_priority = PostModel::getPostByPriority($where, 20);
        $where = '';
        $csv_uploaded = PostModel::getCsvUploadedHistory($where, 10);

        $response = [
            'total_nasters' => $total_nasters,
            'total_users' => $total_users,
            'total_cases_priority' => $total_cases_priority,
            'csv_uploaded' => $csv_uploaded,
        ];
        //dd($response);
        return view('dashboard', ['response' => $response]);
    }
}
