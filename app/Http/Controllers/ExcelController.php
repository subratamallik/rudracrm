<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Importer;
use App\Models\CrudModel;

class ExcelController extends Controller
{
    public function uploadProcess(Request $request)
    {
        $formData = $request->input();
        $file = $request->file('file');
        $filename = time().'_'.$file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        if ($extension != "xlsx") {
            return redirect()->back()->with('danger', 'Accept only .xlsx file.');
        }
        $excel = Importer::make('Excel');
        $excel->load($file);
        $data = $excel->getCollection();
        foreach ($data as $key => $item) {
            if ($key <= 0) {
                $payload_post_key[] = array_slice($item, 0, env('POST_SLICE'));
                $postMeta_key[] = array_slice($item, env('POST_SLICE'));
            } else {
                $payload_post_value[] = array_slice($item, 0, env('POST_SLICE'));
                $postMeta_value[] = array_slice($item, env('POST_SLICE'));
            }
        }
        foreach ($payload_post_value as $key => $value) {
            $final_posts = array_combine($payload_post_key[0], $payload_post_value[$key]);
            $final_posts['post_meta'] = json_encode(array_combine($postMeta_key[0], $postMeta_value[$key]));
            $username = $final_posts['username'];
            unset($final_posts['username']);
            $user = CrudModel::readData('users', 'username="' . $username . '"', '', 1);
            $final_posts['assigned_user_id'] = $user->id;
            $final_posts['file_name'] =  $filename;
            $final_posts['craeted_user_id'] =   $request->user['id'];
            $final_posts['process_id'] =  $formData['process_id'];
            $final_posts['disposition_id'] =  env('DEFAULT_DISPOSITION');

            CrudModel::createNewRecord('post', $final_posts);
        }
        // add to hostory
        $payload = [
            'user_id' => $request->user['id'],
            'filename' => $filename,
        ];
        CrudModel::createNewRecord('csv_upload_history', $payload);
        return redirect()->back()->with('success', 'Excel file has been uploaded successfully!');
    }

    public function uploadBajajProcess(Request $request)
    {
        $formData = $request->input();
        $file = $request->file('file');
        $filename = time().'_'.$file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        if ($extension != "xlsx") {
            return redirect()->back()->with('danger', 'Accept only .xlsx file.');
        }
        $excel = Importer::make('Excel');
        $excel->load($file);
        $data = $excel->getCollection();
        foreach ($data as $key => $item) {
            if ($key <= 0) {
                $payload_post_key[] = array_slice($item, 0, env('POST_SLICE_BAJAJ'));
                $postMeta_key[] = array_slice($item, env('POST_SLICE_BAJAJ'));
            } else {
                $payload_post_value[] = array_slice($item, 0, env('POST_SLICE_BAJAJ'));
                $postMeta_value[] = array_slice($item, env('POST_SLICE_BAJAJ'));
            }
        }
        foreach ($payload_post_value as $key => $value) {
            
            $final_posts = array_combine($payload_post_key[0], $payload_post_value[$key]);
            $final_posts['post_meta'] = json_encode(array_combine($postMeta_key[0], $postMeta_value[$key]));
            $username = $final_posts['crm_username'];
            unset($final_posts['crm_username']);
            $user = CrudModel::readData('users', 'username="' . $username . '"', '', 1);
            $final_posts['allocated_date'] =  hpDate($final_posts['allocated_date'],'Y-m-d');
            $final_posts['file_name'] =  $filename;
            $final_posts['assigned_user_id'] = $user->id;
            $final_posts['created_user_id'] =   $request->user['id'];
            CrudModel::createNewRecord('bajaj_post', $final_posts);
        }
        // add to hostory
        $payload = [
            'user_id' => $request->user['id'],
            'filename' => $filename,
        ];
        CrudModel::createNewRecord('csv_upload_history', $payload);
        return redirect()->back()->with('success', 'Excel file has been uploaded successfully!');
    }
}
