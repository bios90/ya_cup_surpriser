<?php
/**
 * Created by PhpStorm.
 * User: bios90
 * Date: 2021-02-23
 * Time: 04:00
 */

namespace App\Http\Helpers;


class HelperResponses
{
    static function getFillFiledText($field)
    {
        return "Заполните поле '$field'";
    }

    static function getSuccessResponse($object)
    {
        return response()->json([
            'status' => 'success',
            'data' => $object
        ]);
    }

    static function getFailedResponse($errors)
    {

        return response()->json([
            'status' => 'failed',
            'errors' => $errors
        ]);
    }

    static function replaceSpaces($arr)
    {
        $arr_right = array();
        foreach ($arr as $item)
        {
            $str = str_replace(' ', '_', $item);
            $arr_right[] = $str;
        }

        return $arr_right;
    }
}