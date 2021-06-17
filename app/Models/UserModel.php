<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserModel extends Model
{
    use HasFactory;
    static function getUserList($where = null, $limit = NULl)
    {

        $query = DB::table('users')
            ->LeftJoin('masters', 'users.role', '=', 'masters.id')
            ->select(
                'users.*',
                'masters.master_title as role_key',
                'masters.master_details as role_title'
            );
        if ($where != '') {
            $query->whereRaw($where);
        }
        $query->orderByRaw('users.name ASC');
        if ($limit == 1) {
            $result = $query->first();
        } elseif ($limit > 1) {
            $result = $query->paginate($limit);
        } else {
            $result = $query->get();
        }
        return $result;
    }

    static function getUserDetailsById($userId)
    {
        $where = 'users.id="' . $userId . '"';
        $result = DB::table('users')
            ->LeftJoin('masters', 'users.role', '=', 'masters.id')
            ->select(
                'users.*',
                'masters.priority as priority',
                'masters.master_title as roleName',
                'masters.master_details as roleDetails'
            )
            ->whereRaw($where)
            ->first();
        return $result;
    }

    static function getAssignedProcess($userId)
    {

        $query = DB::table('users_process')
            ->LeftJoin('users', 'users_process.user_id', '=', 'users.id')
            ->LeftJoin('masters', 'users_process.process_id', '=', 'masters.id')
            ->select(
                'masters.*',
                'users_process.id as users_process_id',
                'users_process.priority as priority'
            );
        $query->orderByRaw('users_process.priority DESC');
        $result = $query->get();
        return $result;
    }

    static function getAssignedCity($userId)
    {

        $query = DB::table('users_city')
            ->LeftJoin('users', 'users_city.user_id', '=', 'users.id')
            ->LeftJoin('masters', 'users_city.city_id', '=', 'masters.id')
            ->select(
                'masters.*',
                'users_city.id as users_city_id'
            );
        $result = $query->get();
        return $result;
    }


    static function countUsers()
    {
        $result = DB::table('users')
            ->LeftJoin('masters', 'users.role', '=', 'masters.id')
            ->select(
                'masters.master_title',
                'masters.master_details',
                DB::raw('count(*) as total')
            )
            ->groupBy('users.role')
            ->get();

        foreach ($result as $item) {
            $data[$item->master_details] = $item->total;
        }
        return $data;
    }

    static function getUserRoles()
    {

        $result = DB::table('role_manager')
            ->LeftJoin('modules', 'role_manager.role', '=', 'modules.id')
            ->select(
                'masters.master_title',
                'masters.master_details',
                DB::raw('count(*) as total')
            )
            ->groupBy('users.role')
            ->get();

        foreach ($result as $item) {
            $data[$item->master_details] = $item->total;
        }
        return $data;
    }
}
