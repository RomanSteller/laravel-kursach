<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Chat;
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

    public function getMessages($roomId){
        $messages = Chat::with('users')->where('room_id',$roomId)->get();
        return response()->json($messages);
    }

    public function getTaskForRoom($id){
        $taskArray = [];
        $tasks = Task::with('room')->where('room_id',$id)->get();
        foreach ($tasks as $task){
            array_push($taskArray,$task);
        }
       return response([$taskArray]);
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
            array_push($rooms,['id' => $room->id,'name' => $room->room_name]);
        }
        return response()->json(['rooms' => $rooms]);
    }

    public function newTaskRoom(Request $request){
        $taskRoom = new TaskRoom();
        $taskRoom->room_name = $request['name'];
        $taskRoom->subject = $request['subject'];
        $taskRoom->owner_id = $request['id'];
        $taskRoom->save();

        $taskRoom->users()->attach($request['id']);
        return response()->json([
            'message' => 'Новая комната успешно создана',
            'room' => $taskRoom
        ]);
    }

    public function getUsers(Request $request){
        $users = User::where('name','LIKE','%'.$request->keyword.'%')->get();
        return response()->json($users);
    }

    public function createNewTask(Request $request){
        $task = new Task();
        $task->title = $request['title'];
        $task->description = $request['description'];
        $task->author_id = $request['author_id'];
        $task->executor_id = $request['executor_id'];
        $task->date_start = $request['date_start'];
        $task->date_end = $request['date_end'];
        $task->room_id = $request['room_id'];
        $task->priority_id = 1;
        $task->status_id = 1;
        $task->save();

        return response()->json(['Задача создана' => $task])->setStatusCode(201);
    }

    public function getUserForId(Request $request){
        $user = User::where('id',$request['id'])->get();
        return response()->json($user);
    }
}
