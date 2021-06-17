<?php

namespace App\Http\Controllers;

use App\Models\CrudModel;
use App\Models\MasterModel;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function list($master_type, Request $request)
    {
        $where = 'masters.master_type="' . $master_type . '"';
        if (isset($_GET['audit_status']) && $_GET['audit_status'] == 1) {
            $where .= ' AND masters.audit_status=' . $_GET['audit_status'];
        }
        if (isset($_GET['q']) && $_GET['q'] != '') {
            $where .= ' AND masters.master_title LIKE "%' . $_GET['q'].'%"';
        }
        //dd($where);
        $master = MasterModel::getMastersList($where, 20);
        $response = [
            'master_type' => $master_type,
            'master' => $master
        ];
        //dd($response);
        return view('master_list', ['response' => $response]);
    }

    public function add(Request $request)
    {
        $formData = $request->input();
        $payload = [
            'master_type' => $formData['master_type'],
            'master_title' => $formData['master_title'],
            'master_details' => $formData['master_details'],
        ];
        CrudModel::createNewRecord('masters', $payload);
        return redirect()->back()->with('success', 'Data has been added successfully!');
    }

    public function update($id, Request $request)
    {
        $master = MasterModel::getMastersDetails(decoded($id));
        $response = [
            'master' => $master
        ];
        //dd($response);
        return view('master_update', ['response' => $response]);
    }

    public function updatePost($id, Request $request)
    {
        $master = MasterModel::getMastersDetails(decoded($id));
        $formData = $request->input();
        $payload = [
            'master_title' => $formData['master_title'],
            'master_details' => $formData['master_details'],
            'audit_status' => $formData['audit_status'],
        ];
        $where = 'id=' . decoded_secure($formData['master_id']);
        CrudModel::updateRecord('masters', $payload, $where);
        return redirect('master/list/' . $master->master_type)->with('success', 'Data has been updated successfully!');
    }
}
