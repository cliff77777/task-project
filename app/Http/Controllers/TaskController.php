<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function __construct()
    {

    }

    public function menu_index(){
        return view('task.menu_index');
    }

    public function task_index(){
        return view('task.task_index');
    }

    public function task_create(){
        return view('task.task_create');
    }

}
