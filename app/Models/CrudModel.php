<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CrudModel extends Model
{
    use HasFactory;
    static function readData($table, $where = NULL, $orderBy = NULL, $limit = NULL, $fields = '*')
    {
        //dd($limit);
        $query = DB::table($table)
            ->select($fields);
        if ($orderBy != '') {
            $query->orderByRaw($orderBy);
        }
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

    static function createNewRecord($table, $insertArray)
    {
        try {
            $insertedId = DB::table($table)->insertGetId($insertArray);
            return $insertedId;
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
        
    }

    static function createRecordMultiple($table, $insertArray)
    {
        $resilt = DB::table($table)->insert($insertArray);
        return $resilt;
    }

    static function createOnDuplicateKey($table, $insertArray)
    {
        $resilt = DB::table($table)->insertOnDuplicateKey($insertArray);
        return $resilt;
    }

    static function updateRecord($table, $updateArray, $where)
    {
        try {
            $result = DB::table($table)
                ->whereRaw($where)
                ->update($updateArray);
            return $result;
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
    }

    static function deleteRecord($table, $where)
    {
        $result = DB::table($table)
            ->whereRaw($where)
            ->delete();
        return $result;
    }

    static function count($table, $where)
    {
        $result = DB::table($table)
            ->whereRaw($where)
            ->paginate(1);
        return $result->total();
    }
}
