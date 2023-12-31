<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\PayerController;
use App\Http\Resources\PayerResource;

class UserController extends Controller
{
    public function index()
    {
        // paired by email

        return auth()->user();
    }
}
