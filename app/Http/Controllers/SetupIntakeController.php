<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SetupIntakeController extends Controller
{
 public function addcurrency(){
    return view('setup.intake.add-currency');
 }
}
