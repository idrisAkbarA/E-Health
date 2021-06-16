<?php

namespace App\Http\Controllers;


trait ApiResponse
{
    protected $reply = [
        'status' => false,
        'message' => '',
        'data' => [],
    ];
}
