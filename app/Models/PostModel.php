<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostModel extends Model
{
    use HasFactory;
    static function getPost($where = NULL, $limit = NULL)
    {
        $query = DB::table('post')
            ->LeftJoin('masters', 'post.process_id', '=', 'masters.id')
            ->LeftJoin('users', 'post.assigned_user_id', '=', 'users.id')
            ->select(
                'post.*',
                'masters.master_title as process',
                'users.name as user_name',
                'users.username as user_username',
                'users.email as user_email',
                'users.mobile as user_mobile',
            );
        if ($where != '') {
            $query->whereRaw($where);
        }
        if ($limit == 1) {
            $result = $query->first();
        } elseif ($limit > 1) {
            $result = $query->paginate($limit);
        } else {
            $result = $query->get();
        }
        return $result;
    }

    static function getProdtDetails($where = NULL, $limit = NULL)
    {
        $query = DB::table('post')
            ->LeftJoin('masters', 'post.process_id', '=', 'masters.id')
            //->LeftJoin('masters as city_table', 'post.city_id', '=', 'city_table.id')
            ->select(
                'post.*',
                'masters.master_title as process',
                //  'city_table.master_title as city'
            );
        if ($where != '') {
            $query->whereRaw($where);
        }
        if ($limit == 1) {
            $result = $query->first();
        } elseif ($limit > 1) {
            $result = $query->paginate($limit);
        } else {
            $result = $query->get();
        }
        return $result;
    }

    static function getCallHistory($where)
    {
        $query = DB::table('post_calling')
            ->LeftJoin('masters', 'post_calling.disposition_id', '=', 'masters.id')
            ->LeftJoin('users', 'post_calling.user_id', '=', 'users.id')
            ->select(
                'post_calling.*',
                'masters.master_title as disposition',
                'users.name as user_name',
                'users.mobile as user_mobile',
                'users.email as user_email'
            );
        if ($where != '') {
            $query->whereRaw($where);
        }
        $query->orderByRaw('post_calling.id DESC');
        $result = $query->get();
        return $result;
    }

    static function getContacts($postId)
    {
        $query = DB::table('post_contact')
            ->select(
                'post_contact.*'
            );
        $query->whereRaw('post_id=' . $postId);
        $query->orderByRaw('post_contact.id DESC');
        $result = $query->get();
        return $result;
    }

    static function getPostByPriority($where = NULL, $limit = NULL)
    {
        $query = DB::table('post')
            ->LeftJoin('masters', 'post.process_id', '=', 'masters.id')
            // ->LeftJoin('masters as city_table', 'post.city_id', '=', 'city_table.id')
            ->select(
                'post.*',
                'masters.master_title as process',
                //   'city_table.master_title as city'
            );
        if ($where != '') {
            $query->whereRaw($where);
        }
        $query->orderBy('post.next_action_date', 'ASC');
        $query->orderBy('post.next_action_priority', 'DESC');
        $query->orderBy('post.next_action_time', 'ASC');
        if ($limit == 1) {
            $result = $query->first();
        } elseif ($limit > 1) {
            $result = $query->paginate($limit);
        } else {
            $result = $query->get();
        }
        return $result;
    }

    static function getCsvUploadedHistory($where = NULL, $limit = NULL)
    {
        $query = DB::table('csv_upload_history')
            ->LeftJoin('users', 'csv_upload_history.user_id', '=', 'users.id')
            ->select(
                'csv_upload_history.*',
                'users.name',
                'users.username',
            );
        if ($where != '') {
            $query->whereRaw($where);
        }
        $query->orderByRaw('csv_upload_history.id DESC');
        if ($limit == 1) {
            $result = $query->first();
        } elseif ($limit > 1) {
            $result = $query->paginate($limit);
        } else {
            $result = $query->get();
        }
        return $result;
    }

    static function getPostBajaj($where = NULL, $limit = NULL)
    {
        $query = DB::table('bajaj_post')
            ->LeftJoin('users', 'bajaj_post.assigned_user_id', '=', 'users.id')
            ->select(
                'bajaj_post.*',
                'users.name as user_name',
                'users.username as user_username',
                'users.email as user_email',
                'users.mobile as user_mobile',
            );
        if ($where != '') {
            $query->whereRaw($where);
        }
        if ($limit == 1) {
            $result = $query->first();
        } elseif ($limit > 1) {
            $result = $query->paginate($limit);
        } else {
            $result = $query->get();
        }
        return $result;
    }

}
