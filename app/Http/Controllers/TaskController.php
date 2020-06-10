<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\TaskTransformer;
use App\Transformers\NoteTransformer;
use App\Models\Task;
use App\Models\Note;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $task = Task::all();
        return $task;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteTask(Request $request)
    {
        $task = Task::where('id', $request->task['id'])->first();

        Note::where('task_id', $task->id)->delete();

        $task->delete();
    }

    public function createTask(Request $request)
    {
        $task = new Task();
        $task->user_id = $request->userId;
        $task->date = $request->newTask['date'];
        $task->start = $request->newTask['start'];
        $task->end = $request->newTask['end'];
        $task->worked_hours = $request->newTask['worked_hours'];
        $task->user_id = $request->userId;
        $task->save();

        for ($i = 0; $i < count($request->newNotes); $i++) {
            $note = new Note();
            $note->user_id = $request->userId;
            $note->task_id = $task->id;
            $note->description = $request->newNotes[$i]['description'];
            $note->save();
        }

        return  response()->json($task);
    }

    public function updateTask(Request $request)
    {
        $editTask = Task::where('id',$request->editTask['id'])->where('user_id',$request->userId)->first();
        $editTask->user_id = $request->userId;
        $editTask->date = $request->editTask['date'];
        $editTask->start = $request->editTask['start'];
        $editTask->end = $request->editTask['end'];
        $editTask->worked_hours = $request->editTask['worked_hours'];
        $editTask->save();

        Note::where('task_id', $request->editTask['id'])->delete();
        
        for ($i = 0; $i < count($request->editNotes); $i++) {
            $note = new Note();
            $note->user_id = $request->userId;
            $note->task_id = $request->editTask['id'];
            $note->description = $request->editNotes[$i]['description'];
            $note->save();
        }

        $notes = Note::all();

        return  [$editTask, $notes];
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'task_id', 'id');
    }

    public function getFilteredTasks(Request $request)
    {
        if ($request->from != '' && $request->to != '') {
            $filteredTasks = Task::where('user_id', $request->userId)
                ->where('date', '>=', $request->from)
                ->where('date', '<=', $request->to)
                ->orderBy('date','asc')
                ->get();
            return response()->json($filteredTasks);
        }

        if ($request->from == '' && $request->to != '') {
            $filteredTasks = Task::where('user_id', $request->userId)
            ->where('date', '<=', $request->to)
            ->orderBy('date','asc')
            ->get();
            return response()->json($filteredTasks);
        }

        if ($request->from != '' && $request->to == '') {
            $filteredTasks = Task::where('user_id', $request->userId)
            ->where('date', '>=', $request->from)
            ->orderBy('date','asc')
            ->get();
            return response()->json($filteredTasks);
        }
    }


    public function getSortedTasks(Request $request)
    {
        if ($request->from == '' && $request->to == '') {
            $filteredTasks = Task::where('user_id', $request->userId)
                ->orderBy('date',$request->sort)
                ->get();
            return response()->json($filteredTasks);
        }

        if ($request->from != '' && $request->to != '') {
            $filteredTasks = Task::where('user_id', $request->userId)
                ->where('date', '>=', $request->from)
                ->where('date', '<=', $request->to)
                ->orderBy('date',$request->sort)
                ->get();
            return response()->json($filteredTasks);
        }

        if ($request->from == '' && $request->to != '') {
            $filteredTasks = Task::where('user_id', $request->userId)
            ->where('date', '<=', $request->to)
            ->orderBy('date',$request->sort)
            ->get();
            return response()->json($filteredTasks);
        }

        if ($request->from != '' && $request->to == '') {
            $filteredTasks = Task::where('user_id', $request->userId)
            ->where('date', '>=', $request->from)
            ->orderBy('date',$request->sort)
            ->get();
            return response()->json($filteredTasks);
        }
    }

    public function export(Request $request) 
    {
        return Excel::download(new TasksExport($request), 'tasks.xlsx');
    }
}
