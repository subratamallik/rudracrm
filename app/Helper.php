<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

function ddc($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}

function prc($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function pr($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die();
}

function hpRanddomStr($str = 40)
{
    return Str::random($str);
}


function hpSubText($string, $limit, $reverse = NULL)
{
    if ($reverse != NULL) {
        $string = strrev($string);
    }
    if (strlen($string) > $limit) {
        $newString = substr($string, 0, $limit) . '...';
    } else {
        $newString = $string;
    }
    if ($reverse != NULL) {
        $newString = strrev($newString);
    }
    return $newString;
}

function hpSubTextNoDot($string, $limit, $reverse = NULL)
{
    if ($reverse != NULL) {
        $string = strrev($string);
    }
    if (strlen($string) > $limit) {
        $newString = substr($string, 0, $limit);
    } else {
        $newString = $string;
    }
    if ($reverse != NULL) {
        $newString = strrev($newString);
    }
    return $newString;
}

function lastRoute($level = 0)
{
    $routePath = Request::path();
    $lastRouteName = (explode('/', strrev($routePath)));
    if (isset($lastRouteName[$level])) {
        $lastRouteName = strrev($lastRouteName[$level]);
    } else {
        $lastRouteName = '';
    }
    return $lastRouteName;
}

function firstRoute($level = 0)
{
    $routePath = Request::path();
    $lastRouteName = (explode('/', $routePath));
    if (isset($lastRouteName[$level])) {
        $lastRouteName = $lastRouteName[$level];
    } else {
        $lastRouteName = '';
    }
    return $lastRouteName;
}

function encoded($text)
{
    return base64_encode(base64_encode($text));
}

function decoded($text)
{
    return base64_decode(base64_decode($text));
}
function encoded_secure($text)
{
    return encrypt($text);
}

function decoded_secure($text)
{
    return decrypt($text);
}

function helperGetDomain($url)
{
    $pieces = parse_url($url);
    $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
    if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
    }
    return false;
}

function helperPermalink($str)
{
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', trim($str))));
}

function hpRand($digit = 4)
{
    return substr(rand(0, 12345) . strrev(time()), 0, $digit);
}

function hpDate($date, $format = 'Y-m-d')
{
    if (trim($date) == '' || substr($date, 0, 10) == '0000-00-00') {
        return '';
    }
    return date($format, strtotime($date));
}

function hpNewDateAfterAddDays($days, $oldDate = '')
{
    if ($oldDate == '') {
        $oldDate = date('Y-m-d');
    }
    $newDate = strtotime("+" . $days . " days", strtotime($oldDate));
    return date("Y-m-d", $newDate);
}

function hpUrl()
{
    return url()->current();
}
function hpUrlFull()
{
    return url()->full();
}
function hpUrlPrev()
{
    return url()->previous();
}

function hpArticleImage($src)
{
    if ($src == '' || $src == null) {
        return 'resources/images/no-image-available.png';
    } else {
        $img = str_replace('_original.', '.', $src);
        return $img;
    }
}


function hpLastElement($niddle, $str)
{
    $strArray = explode($niddle, $str);
    $lastElement = end($strArray);
    return $lastElement;
}

function hpTime()
{
    return time() * 1000;
}

function hpPriceoComma($price)
{
    $result = str_replace('.', ',', $price);
    return $result;
}
function hpPriceodot($price)
{
    $result = str_replace(',', '.', $price);
    return $result;
}

function hpPrice($price)
{
    $result = 'Rs.' . number_format($price, 0);
    return $result;
}

function hpMultilineToSingle($str)
{
    $result = trim(preg_replace("/[\r\n]/", "<br>", $str), '');
    $result = str_replace('<br><br>', '<br>', $result);

    return $result;
}


function hpFeeCalculate($amount)
{
    $percentage = 3.5;
    return round($amount * ($percentage / 100), 2);
}
function hpGermanPriceFormat($amount)
{
    return str_replace('.', ',', $amount);
}

function priceToComma($price)
{
    $price = str_replace(',', '.', $price);
    $price = number_format((float) $price, 2, '.', '');
    return str_replace('.', ',', $price);
}

function hpObjectToArray($object)
{
    return json_decode(json_encode($object), true);
}

function hpArrayNullToBlankMulti($array)
{
    $arrayNew = [];
    foreach ($array as $key => $value) {
        $arrayNew[] = hpArrayNullToBlank($value);
    }
    return $arrayNew;
}

function hpArrayNullToBlank($array)
{
    $array = array_map(function ($v) {
        return (is_null($v)) ? "" : $v;
    }, $array);

    return $array;
}

function hpBrToNewLine($text)
{
    $breaks = array("<br />", "<br>", "<br/>");
    $text = str_ireplace($breaks, "\r\n", $text);
    return $text;
}

function hpTimeStap($days)
{
    $date = strtotime("+" . $days . " day");
    $returnData = $date * 1000;
    return $returnData;
}

function csvToArray($filename = '', $delimiter = ',')
{
    if (!file_exists($filename) || !is_readable($filename))
        return false;

    $header = null;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== false) {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
            if (!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }

    return $data;
}

function nxtactn_prrt()
{
    $data = [
        'High' => 3,
        'Medium' => 2,
        'Low' => 1
    ];
    return $data;
}

function get_nxtactn_prrt($id)
{
    if ($id > 0) {
        foreach (nxtactn_prrt() as $key => $value) {
            $data[$value] = $key;
        }
        return $data[$id];
    }
    return '';
}

function hpGetController($data)
{
    $data = explode('App\Http\Controllers', $data);
    return str_replace('', '', stripslashes($data[1]));
}

function hpMenuBuild($data, $parentModules)
{
    foreach ($data as $item) {
        if ($item->show_in_menu == "yes") {
            $menu[$item->parent_id][] = $item;
        }
    }
    $parentModulesData = [];
    foreach ($parentModules as $item) {
        if (isset($menu[$item->id])) {
            $item->sub_menu = $menu[$item->id];
            $parentModulesData[] = $item;
        }
    }
    return $parentModulesData;
}

function hpMenuBuildAdmin($data, $parentModules)
{
    foreach ($data as $item) {
        if ($item->show_in_menu == "yes") {
            $menu[$item->parent_id][] = $item;
        }
    }
    $parentModulesData = [];
    foreach ($parentModules as $item) {
        if (isset($menu[$item->id])) {
            $item->sub_menu = $menu[$item->id];
            $parentModulesData[] = $item;
        }
    }
    return $parentModulesData;
}

function hpPermissionDeniedRole($case)
{
    switch ($case) {
        case 'processAllocation':
            $returnData = ['tele_caller'];
            break;

        default:
            # code...
            break;
    }
    return $returnData;
}

function hpCheckRole($task)
{
    if (Session::get('logged_user')['roleName'] == 'admin') {
        return true;
    }
    if (isset(Session::get('user_roles')['inner_role']) && in_array($task, Session::get('user_roles')['inner_role'])) {
        return true;
    }
    return false;
}

function hp_master($id)
{
    $master_title = '';
    $where = 'masters.id="' . $id . '"';
    $result = DB::table('masters')
        ->select(
            'masters.master_title'
        )
        ->whereRaw($where)
        ->first();
    if ($result) {
        $master_title = $result->master_title;
    }
    return $master_title;
}

function workable_status()
{
    $workable_status = [
        'Workable', 'Not Workable'
    ];
    return $workable_status;
}
