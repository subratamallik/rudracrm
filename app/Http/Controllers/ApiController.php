<?php

namespace App\Http\Controllers;

use App\Models\CrudModel;
use App\Models\PostModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Auth;

class ApiController extends Controller
{
    public function loggedUser(Request $request)
    {
        $loggedUser = (array) $request->loggedUser;
        unset($loggedUser['password']);
        unset($loggedUser['token']);
        $response = [
            "status" => true,
            "loggedUser" => $loggedUser,
        ];
        return response()->json($response);
    }

    public function dashboard(Request $request)
    {
        $where = 'bajaj_post.status!="delete" && bajaj_post.assigned_user_id=' . $request->loggedUser->id;
        $postPost = CrudModel::count('bajaj_post', $where);

        $response = [
            "status" => true,
            "bajajCount" => $postPost,
        ];
        return response()->json($response);
    }

    public function login(Request $request)
    {
        $payload = $request->json()->all();
        $payload = [
            'username' => $payload['username'],
            'password' => $payload['password']
        ];
        $authResult = Auth::attempt($payload);
        if ($authResult) {
            $userId = Auth::id();
            $where = 'id="' . $userId . '"';
            $user = CrudModel::readData('users', $where, '', 1);
            $token = $user->token;
            if ($token == "") {
                $token = hpRanddomStr(75);
                CrudModel::updateRecord('users', ['token' => $token], $where);
            }
            $response = [
                "status" => true,
                "token" => $token,
            ];
        } else {
            $response = [
                "status" => false,
                "msg" => "Invalid Credentials!",
            ];
        }

        return response()->json($response);
    }


    public function bajajPostList(Request $request)
    {
        $payload = $request->json()->all();
        $where = 'bajaj_post.status!="delete" && bajaj_post.assigned_user_id=' . $request->loggedUser->id;
        if (isset($payload['q']) && $payload['q'] != "") {
            $where .= ' AND (bajaj_post.hoid LIKE "%' . $payload['q'] . '%" OR bajaj_post.insured_name LIKE "%' . $payload['q'] . '%" OR bajaj_post.city LIKE "%' . $payload['q'] . '%" OR bajaj_post.policy_numbers LIKE "%' . $payload['q'] . '%" OR bajaj_post.claim_number LIKE "%' . $payload['q'] . '%")';
        }
        $post = PostModel::getPostBajaj($where, 20);
        $response = [
            "status" => true,
            "post" => $post,
        ];
        return response()->json($response);
    }


    public function bajajPostDetails($id, Request $request)
    {
        $where = 'bajaj_post.id=' . $id;
        $post = PostModel::getPostBajaj($where, 1);
        $documents = CrudModel::readData('bajaj_post_documents', 'source="crm" AND bajaj_post_id=' . $id);
        if ($documents) {
            $documentsNew = [];
            foreach ($documents as $item) {
                $item->file_name = env('APP_URL') . '/storage/app/public/' . $item->file_name;
                $documentsNew[] = $item;
            }
        }
        $bajaj_post_feedback = CrudModel::readData('bajaj_post_feedback', 'bajaj_post_id=' . $id, '', 1);
        $response = [
            'post' => $post,
            'documents' => $documentsNew,
            'bajaj_post_feedback' => $bajaj_post_feedback
        ];
        return response()->json($response);
    }

    public function bajajDocuments(Request $request)
    {
        $payload = $request->json()->all();
        $where = 'bajaj_post_id=' . $payload['post_id'];
        if (isset($payload['source']) && $payload['source'] != "") {
            $where .= ' AND source="' . $payload['source'] . '"';
        }
        $documents = CrudModel::readData('bajaj_post_documents', $where,'id DESC');
        if ($documents) {
            $documentsNew = [];
            foreach ($documents as $item) {
                $item->file_name = env('APP_URL') . '/storage/app/public/' . $item->file_name;
                $documentsNew[] = $item;
            }
        }
        $response = [
            'status' => true,
            'documents' => $documentsNew,
        ];
        return response()->json($response);
    }


    public function bajajPostFeedbackSave(Request $request)
    {
        $payload = $request->json()->all();
        $insertData = [
            "bajaj_post_id" => $payload['bajaj_post_id'],
            "submited_user_id" => $request->loggedUser->id
        ];
        $fields = [
            'insured_information', 'insured_family_details', 'movable_property', 'immovable_property', 'investigator_opinion', 'iib_site_details', 'cus_single_window_details'
        ];
        foreach ($fields as $field) {
            if (isset($payload[$field]) && $payload[$field] != "") {
                $insertData[$field] = json_encode($payload[$field]);
            }
        }
        $result = CrudModel::createOnDuplicateKey('bajaj_post_feedback', $insertData);
        if ($result) {
            $response = [
                'status' => true,
                'msg' => "Data has been saved successfully !"
            ];
        } else {
            $response = [
                'status' => false,
                'msg' => "nothing to update, something wrong please try again!"
            ];
        }
        return response()->json($response);
    }

    public function bajajDocumentsUpload(Request $request)
    {
        $formData = $request->input();
        if ($request->hasFile('file')) {
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $request->file('file')->storeAs('public', $fileNameToStore);
            //
            $payload = [
                'bajaj_post_id' => $formData['bajaj_post_id'],
                'title' => $formData['title'],
                'file_name' => $fileNameToStore,
                'source' => $formData['source'],
            ];
            CrudModel::createNewRecord('bajaj_post_documents', $payload);
            $response = [
                'status' => true,
                'payload' => $payload
            ];
        } else {
            $response = [
                'status' => false,
                'msg' => 'Invalid file, try again'
            ];
        }
        return response()->json($response);
    }
}
