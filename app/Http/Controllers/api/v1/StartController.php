<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\Task;
use Illuminate\Http\Request;

class StartController extends Controller
{
    public function fetchTasks(){
        $tasks = Task::all();
        return response()->json([
           $tasks
        ])->setStatusCode(201);
    }

    public function fetchStatus(){
        $status = Status::all();
        return response()->json([
           $status
        ])->setStatusCode(201);
    }

}
