<?php

function apiResponse($code, $status, $msg, $data = null)
{
    $response = [
        'code' => $code,
        'status' => $status,
        'msg' => $msg,
        'data' => $data,
    ];

    return response()->json($response);
}


/**
 * code (e200) => كل حاجه تمام
 * code (e300) => لا توجد بيانات
 * code (e400) => validation غلط في ال
 * code (e500) => غلط في الاكواد او الداتابيز
 */
