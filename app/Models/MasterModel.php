<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MasterModel extends Model
{
    use HasFactory;
    static function getMasters($master_type = '', $limit = NULL, $orderBy = NULL)
    {
        if ($master_type != '') {
            $where = 'masters.master_type="' . $master_type . '"';
        }
        $query = DB::table('masters')
            ->select(
                'masters.*'
            );
        if ($where != '') {
            $query->whereRaw($where);
        }
        if ($orderBy != '') {
            $query->orderByRaw($orderBy);
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

    static function getMastersDetails($id)
    {
        $where = 'masters.id="' . $id . '"';
        $result = DB::table('masters')
            ->select(
                'masters.*'
            )
            ->whereRaw($where)
            ->first();
        return $result;
    }

    static function getMastersTitle($id)
    {
        $where = 'masters.id="' . $id . '"';
        $result = DB::table('masters')
            ->select(
                'masters.master_title'
            )
            ->whereRaw($where)
            ->first();
        return $result;
    }

    static function getDisposition($where, $limit = NULl)
    {
        $query = DB::table('masters')
            ->LeftJoin('masters as process', 'masters.process_id', '=', 'process.id')
            ->select(
                'masters.*',
                'process.master_title as process_title',
                'process.master_details as process_details',
                'process.id as process_id'
            );
        if ($where != '') {
            $query->whereRaw($where);
        }
        $query->orderByRaw('masters.master_title ASC');
        if ($limit == 1) {
            $result = $query->first();
        } elseif ($limit > 1) {
            $result = $query->paginate($limit);
        } else {
            $result = $query->get();
        }
        return $result;
    }

    static function getMastersRoles($where, $limit = NULl)
    {
        $query = DB::table('masters')
            ->select(
                'masters.*'
            );
        if ($where != '') {
            $query->whereRaw($where);
        }
        $query->orderByRaw('masters.priority ASC');
        if ($limit == 1) {
            $result = $query->first();
        } elseif ($limit > 1) {
            $result = $query->paginate($limit);
        } else {
            $result = $query->get();
        }
        return $result;
    }

    static function getMastersList($where, $limit = NULl, $orderBy = '')
    {
        $query = DB::table('masters')
            ->select(
                'masters.*'
            );
        if ($where != '') {
            $query->whereRaw($where);
        }
        if ($orderBy != '') {
            $query->orderByRaw($orderBy);
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
   
    static function countMaters()
    {
        $result = DB::table('masters')
            ->select(
                'masters.master_type',
                DB::raw('count(*) as total')
            )
            ->groupBy('masters.master_type')
            ->get();
            foreach ($result as $item) {
                $data[$item->master_type]=$item->total;
            }
        return $data;
    }

}
