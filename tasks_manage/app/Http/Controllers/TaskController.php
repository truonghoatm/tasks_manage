<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('index', compact('tasks'));
    }

    public function create()
    {

        return view('add');
    }
    public function store(Request $request){
        $task = new Task();
        $task->title = $request->inputTitle;
        $task->content = $request->inputContent;
        $task->started_at = $request->inputStartedAt;
        $task->due_date = $request->inputDueDate;
        $file = $request->inputFile;
        if(!$request->hasFile('inputFile')){
            $task->image = $file;
        }else{
            $fileName = $request->inputFileName;
            $fileExtension = $file->getClientOriginalExtension();
            $newFileName = "$fileName.$fileExtension";
            $task->image = $newFileName;
            $request->file('inputFile')->storeAs('public/images', $newFileName);
        }
        $task->save();
        $message = "Tạo Task $request->inputTitle thành công!";
        Session::flash('create-success', $message);

        return redirect()->route('tasks.index', compact('message'));

    }
}
