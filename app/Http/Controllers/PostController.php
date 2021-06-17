<?php

namespace App\Http\Controllers;

use App\Models\CrudModel;
use App\Models\MasterModel;
use App\Models\PostModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function uploadCsv(Request $request)
    {
        $process = MasterModel::getMasters('process');
        $response = [
            "process" => $process
        ];
        //dd($response);
        return view('uploadCsv', ['response' => $response]);
    }

    public function uploadCsvProcess(Request $request)
    {
        $formData = $request->input();
        $file = $request->file('file');
        // File Details 
        $filename = $file->getClientOriginalName();
        /*
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();
        */

        $extension = $request->file('file')->getClientOriginalExtension();
        //dd($extension);
        $data = ImportExportController::csvToArray($request->file('file'));
        //pr($data);
        foreach ($data as $key => $item) {
            //dd($item);
            $username = $item['username'];
            $payload_post = array_slice($item, 0, env('POST_SLICE'));
            $postMeta = array_slice($item, env('POST_SLICE'));
            //dd($postMeta);
            $payload_post['post_meta'] = json_encode($postMeta);
            dd($payload_post);
            $payload_post['file_name'] =  $filename;
            $payload_post['craeted_user_id'] =   $request->user['id'];
            $payload_post['process_id'] =  $formData['process_id'];
            $payload_post['disposition_id'] =  env('DEFAULT_DISPOSITION');
            unset($payload_post['username']);
            dd($payload_post);
            $postId = CrudModel::createNewRecord('post', $payload_post);
            // assign process
            $user = CrudModel::readData('users', 'username="' . $username . '"', '', 1);
            if ($user && $user->id != "") {
                $payloadAssign = [
                    'assigned_user_id' => $user->id
                ];
                CrudModel::updateRecord('post', $payloadAssign, 'id=' . $postId);
            }
        }
        // add to hostory
        $payload = [
            'user_id' => $request->user['id'],
            'filename' => $filename,
        ];
        CrudModel::createNewRecord('csv_upload_history', $payload);
        return redirect()->back()->with('success', 'CSV has been uploaded successfully!');
    }

    public function getPost(Request $request)
    {
        $where = 'post.status!="delete"';
        if (isset($_GET['process_id']) && $_GET['process_id'] != "") {
            $where .= ' AND post.process_id=' . $_GET['process_id'];
        }
        if (isset($_GET['q']) && $_GET['q'] != "") {
            $where .= ' AND (post.account_no LIKE "%' . $_GET['q'] . '%" OR 
            post.customer_id LIKE "%' . $_GET['q'] . '%" OR 
            post.customer_name LIKE "%' . $_GET['q'] . '%" OR 
            users.username LIKE "%' . $_GET['q'] . '%"  OR 
            users.email LIKE "%' . $_GET['q'] . '%"  OR 
            users.mobile LIKE "%' . $_GET['q'] . '%" 
            )';
        }
        if (isset($_GET['disposition_id']) && $_GET['disposition_id'] != "") {
            $where .= ' AND post.disposition_id=' . $_GET['disposition_id'];
        }
        if (isset($_GET['priority']) && $_GET['priority'] != "" && $_GET['priority'] != "all") {
            $where .= ' AND post.next_action_priority=' . $_GET['priority'];
        }
        
        if (isset($_GET['priority']) && $_GET['priority'] == "all") {
            $where .= ' AND post.next_action_priority > 0';
        }
        if (
            isset($_GET['from_date']) && $_GET['from_date'] != "" &&
            isset($_GET['to_date']) && $_GET['to_date'] != "" &&
            $_GET['from_date'] <= $_GET['to_date']
        ) {
            $where .= ' AND post.create_date BETWEEN  "'.$_GET['from_date'].'" AND "'.hpNewDateAfterAddDays(1,$_GET['to_date']).'" ';
        }

        if ($request->user['roleName'] == 'tele_caller') {
            $where .= ' AND post.assigned_user_id=' . $request->user['id'];
        }

        $post = PostModel::getPost($where, 15);
        $process = MasterModel::getMasters('process');
        $telecallers = UserModel::getUserList('users.role=' . env('TC_ID'));
        $where = 'masters.master_type="disposition" AND masters.parent_id=0';
        $disposition = MasterModel::getDisposition($where);
        $response = [
            "process" => $process,
            "disposition" => $disposition,
            "post" => $post,
            "telecallers" => $telecallers,
            "user_role" => $request->user['roleName']
        ];
        //dd($response);
        return view('post_list', ['response' => $response]);
    }

    public function prodtDetails($post_id, Request $request)
    {
        $post_id = decoded($post_id);
        $where = 'post.id=' . $post_id;
        $post = PostModel::getProdtDetails($where, 1);
        $post->post_meta = json_decode($post->post_meta, true);
        $where = 'masters.master_type="disposition" AND masters.parent_id=0 AND masters.process_id=' . $post->process_id;
        $disposition = MasterModel::getDisposition($where);
        $post_contact = PostModel::getContacts($post_id);
        $response = [
            "disposition" => $disposition,
            "post_contact" => $post_contact,
            "post" => $post
        ];
        return view('prodtDetails', ['response' => $response]);
    }

    public function prodtSubmitReport(Request $request)
    {
        $formData = $request->input();
        $post_id = decoded($formData['post_id']);
        $payload = [
            'post_id' => $post_id,
            'user_id' => $request->user['id'],
            'disposition_id' => $formData['disposition_id'],
            'sub_disposition_code' => $formData['sub_disposition_code'],
            'workable_status' => $formData['workable_status'],
            'note' => $formData['note'],
            'phone' => $formData['phone'],
        ];
        if (isset($formData['calltime'])) {
            $payload['calltime'] = $formData['calltime'];
        }
        if (isset($formData['called_info_api'])) {
            $payload['called_info_api'] = $formData['called_info_api'];
        }
        CrudModel::createNewRecord('post_calling', $payload);
        // next action
        $payload = [
            'disposition_id' => $formData['disposition_id'],
            'next_action_date' => $formData['next_action_date'],
            'next_action_time' => $formData['next_action_time'],
            'next_action_priority' => $formData['next_action_priority'],
        ];
        $where = 'id=' . $post_id;
        CrudModel::updateRecord('post', $payload, $where);

        $nextCaseUrl = 'post/details/' . $formData['post_id'];
        return redirect($nextCaseUrl)->with('success', 'The case has been submitted successfully!');
    }

    public function addNewContact(Request $request)
    {
        $formData = $request->input();
        $post_id = decoded($formData['post_id']);
        $payload = [
            'post_id' => $post_id,
            'phone' => $formData['phone'],
            'address' => $formData['address'],
        ];
        CrudModel::createNewRecord('post_contact', $payload);
        $nextCaseUrl = 'post/details/' . $formData['post_id'];
        return redirect($nextCaseUrl)->with('success', 'New contact information has been added successfully!');
    }

    public function postReassign(Request $request)
    {
        $formData = $request->input();
        $payload = ['assigned_user_id' => $formData['post_assign_user_id']];
        if (isset($formData['post_id'])) {
            $result = CrudModel::updateRecord('post', $payload, 'post.id IN (' . implode(',', $formData['post_id']) . ')');
            if ($result) {
                return redirect()->back()->with('success', 'Selected cases has been reassigned to selected user!');
            } else {
                return redirect()->back()->with('danger', 'Something wrong, please try again!');
            }
        } else {
            return redirect()->back()->with('danger', 'Something wrong, please try again!');
        }
    }


    public function countPost($fileName, $status)
    {
        $where = 'file_name="' . $fileName . '" AND status="' . $status . '"';
        $checkpost = CrudModel::count('post', $where);
        $response = [
            'status' => true,
            'msg' => $checkpost . " Records has been found"
        ];
        dd($response);
    }

    public function deletePost($fileName)
    {
        $where = 'file_name="' . $fileName . '" AND status!="delete"';
        $checkpost = CrudModel::count('post', $where);
        if ($checkpost > 0) {
            $payload = [
                'status' => 'delete'
            ];
            CrudModel::updateRecord('post', $payload, $where);
            $response = [
                'status' => true,
                'msg' => $checkpost . " Records has been deleted"
            ];
        } else {
            $response = [
                'status' => false,
                'msg' => "No Records has been found"
            ];
        }
        dd($response);
    }
}
