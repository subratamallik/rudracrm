<?php

namespace App\Http\Controllers;

use App\Models\CrudModel;
use App\Models\MasterModel;
use Illuminate\Http\Request;

class DispositionController extends Controller
{
    public function list(Request $request)
    {
        $process = MasterModel::getMasters('process');
        $where = 'masters.master_type="disposition"';
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $where .= ' AND masters.process_id=' . $_GET['id'];
        }
        if (isset($_GET['process_id']) && $_GET['process_id'] != '') {
            $where .= ' AND masters.process_id=' . $_GET['process_id'];
        }
        if (isset($_GET['parent_id']) && $_GET['parent_id'] != '') {
            $where .= ' AND masters.parent_id=' . $_GET['parent_id'];
        } else {
            $where .= ' AND masters.parent_id=0';
        }
        $disposition = MasterModel::getDisposition($where, 20);
        $response = [
            'disposition' => $disposition,
            'process' => $process
        ];
        //dd($response);
        return view('disposition_list', ['response' => $response]);
    }


    public function add(Request $request)
    {
        $formData = $request->input();
        $payload = [
            'process_id' => $formData['process_id'],
            'master_type' => 'disposition',
            'master_title' => $formData['master_title'],
            'master_details' => $formData['master_details'],
        ];
        if (isset($formData['parent_id'])) {
            $payload['parent_id'] = decoded($formData['parent_id']);
        }
        CrudModel::createNewRecord('masters', $payload);
        return redirect()->back()->with('success', 'Disposition has been added successfully!');
    }

    public function update($id, Request $request)
    {
        $process = MasterModel::getMasters('process');
        $where = 'masters.master_type="disposition" && masters.id=' . decoded($id);
        $disposition = MasterModel::getDisposition($where, 1);
        $response = [
            'disposition' => $disposition,
            'process' => $process
        ];
        //dd($response);
        return view('disposition_update', ['response' => $response]);
    }

    public function updatePost(Request $request)
    {
        $formData = $request->input();
        $payload = [
            'process_id' => $formData['process_id'],
            'master_title' => $formData['master_title'],
            'master_details' => $formData['master_details'],
        ];
        if (isset($formData['avaiablefor'])) {
            $payload['avaiablefor'] = implode(',', $formData['avaiablefor']);
        } else {
            $payload['avaiablefor'] = '';
        }
        //dd($payload);
        $where = 'id=' . decoded_secure($formData['disposition_id']);
        CrudModel::updateRecord('masters', $payload, $where);
        return redirect()->back()->with('success', 'Disposition has been updated successfully!');
    }
}
