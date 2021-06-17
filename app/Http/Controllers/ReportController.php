<?php

namespace App\Http\Controllers;

use App\Models\MasterModel;
use App\Models\PostModel;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function bulkReport(Request $request)
    {
        $process = MasterModel::getMasters('process');
        $response = [
            "process" => $process
        ];
        //dd($response);
        return view('bulkReport', ['response' => $response]);
    }

    public function callHistory($post_id, Request $request)
    {

        $post_id = decoded($post_id);
        $post = PostModel::getProdtDetails('post.id=' . $post_id, 1);
        $process = MasterModel::getMastersDetails($post->process_id);
        $where = 'post_calling.post_id=' . $post_id;
        if ($process->audit_status == 1) {
            $where .= ' AND MONTH(post_calling.create_date) = MONTH(CURRENT_DATE())';
        }
        $callHistory = PostModel::getCallHistory($where);
        $response = [
            "callHistory" => $callHistory
        ];
        //dd($response);
        return view('callHistory', ['response' => $response]);
    }

    public function agentWise(Request $request)
    {
        $response=[];
        return view('agentWise', ['response' => $response]);
    }
    public function locationtWise(Request $request)
    {
        # code...
    }
    public function teamleaderWise(Request $request)
    {
        # code...
    }
    public function managerWise(Request $request)
    {
        # code...
    }
    public function processWise(Request $request)
    {
        # code...
    }
    public function dispositionWise(Request $request)
    {
        # code...
    }
    public function remarksWise(Request $request)
    {
        # code...
    }
    public function weeklyMonthlyPerformanceWise(Request $request)
    {
        # code...
    }
}
