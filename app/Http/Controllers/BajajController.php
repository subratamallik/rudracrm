<?php

namespace App\Http\Controllers;

use App\Models\CrudModel;
use App\Models\MasterModel;
use App\Models\PostModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Storage;

class BajajController extends Controller
{
    public function uploadCsv(Request $request)
    {
        $process = MasterModel::getMasters('process');
        $response = [
            "process" => $process
        ];
        //dd($response);
        return view('uploadCsvBajaj', ['response' => $response]);
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
        $post_id = [];
        foreach ($data as $key => $item) {
            $username = $item['crm_username'];
            $payload_post = $item;
            $payload_post['created_user_id'] = $request->user['id'];;

            unset($payload_post['crm_username']);
            $user = CrudModel::readData('users', 'username="' . $username . '"', '', 1);
            if ($user && $user->id != "") {
                $payload_post['assigned_user_id'] = $user->id;
            }
            $post_id[] = CrudModel::createOnDuplicateKey('bajaj_post', $payload_post);
        }
        // add to hostory
        $payload = [
            'user_id' => $request->user['id'],
            'filename' => $filename,
        ];
        CrudModel::createNewRecord('csv_upload_history', $payload);
        return redirect()->back()->with('success', count($post_id) . ' records has been uploaded from ' . $filename);
    }

    public function getPostList(Request $request)
    {
        $where = 'bajaj_post.status!="delete"';
        if (isset($_GET['q']) && $_GET['q'] != "") {
            $where .= ' AND (bajaj_post.hoid LIKE "%' . $_GET['q'] . '%" OR 
            bajaj_post.insured_name LIKE "%' . $_GET['q'] . '%" OR 
            bajaj_post.city LIKE "%' . $_GET['q'] . '%" OR 
            bajaj_post.policy_numbers LIKE "%' . $_GET['q'] . '%" OR 
            users.email LIKE "%' . $_GET['q'] . '%" OR 
            users.mobile LIKE "%' . $_GET['q'] . '%" OR 
            users.username LIKE "%' . $_GET['q'] . '%" OR 
            users.name LIKE "%' . $_GET['q'] . '%" OR 
            bajaj_post.claim_number LIKE "%' . $_GET['q'] . '%")';
        }
        if ($request->user['roleName'] == 'tele_caller') {
            $where .= ' AND bajaj_post.assigned_user_id=' . $request->user['id'];
        }
        //$post = CrudModel::readData('bajaj_post', $where, '', 15);
        $post = PostModel::getPostBajaj($where, 100);
        $telecallers = UserModel::getUserList('users.role IN (' . env('TC_ID') . ',' . env('FLD_ID') . ')');
        $response = [
            "post" => $post,
            "telecallers" => $telecallers,
            "user_role" => $request->user['roleName']
        ];
        //dd($response);
        return view('getPostListBajaj', ['response' => $response]);
    }

    public function postDetails($id, Request $request)
    {
        $where = 'bajaj_post.id=' . $id;
        $post = PostModel::getPostBajaj($where, 1);
        $documents = CrudModel::readData('bajaj_post_documents', 'source="crm" AND bajaj_post_id=' . $id);
        $bajaj_post_feedback = CrudModel::readData('bajaj_post_feedback', 'bajaj_post_id=' . $id, '', 1);
        $response = [
            'post' => $post,
            'documents' => $documents,
            'bajaj_post_feedback' => $bajaj_post_feedback
        ];
        //dd($response);
        return view('postDetailsBajaj', ['response' => $response]);
    }

    public function fileUpload(Request $request)
    {
        $postId = $request->input('postId');
        if ($request->hasFile('file')) {
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $request->file('file')->storeAs('public', $fileNameToStore);
            //
            $payload = [
                'bajaj_post_id' => $postId,
                'title' => $fileNameToStore,
                'file_name' => $fileNameToStore,
                'source' => 'crm',
            ];
            CrudModel::createNewRecord('bajaj_post_documents', $payload);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        return redirect()->back()->with('success', 'Documents has been uploaded !');
    }

    public function postReassign(Request $request)
    {
        $formData = $request->input();
        $payload = ['assigned_user_id' => $formData['post_assign_user_id']];        
        if (isset($formData['post_id'])) {
            $result = CrudModel::updateRecord('bajaj_post', $payload, 'bajaj_post.id IN (' . implode(',', $formData['post_id']) . ')');
            if ($result) {
                return redirect()->back()->with('success', 'Selected cases has been reassigned to selected user!');
            } else {
                return redirect()->back()->with('danger', 'Something wrong, please try again!');
            }
        } else {
            return redirect()->back()->with('danger', 'Something wrong, please try again!');
        }
    }
}
