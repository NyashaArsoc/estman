<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminIntakeController extends Controller
{
    public function form()
    {
        return view('admin.intake.requisition-form');
    }
}
