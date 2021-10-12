<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\Task;
use App\Models\TaskRoom;
use App\Models\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Object_;

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

    public function updateTask(Request $request){
        $task = Task::where('id',$request['id'])->first();
        $task->status_id = $request['statusId'];
        $task->save();
        return response()->json([
            'message' => 'Обновлено'
        ]);
    }

    public function getRoomsForId(Request $request){
        $rooms = [];
        $user = User::with('rooms')->where('id',$request->id)->first();
        foreach ($user->rooms as $room){
           array_push($rooms,['id' => $room->id-1,'name' => $room->room_name]);
        }
        return response()->json(['rooms' => $rooms]);
    }

}
