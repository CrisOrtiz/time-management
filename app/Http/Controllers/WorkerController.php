<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Models\Note;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function destroy($id)
    {
        //
    }

    public function showHomeWorker($userId)
    {
        $user = User::where('id', $userId)->first();
        return view('worker.home', [
            'user' => $user,
        ]);
    }


    public function showListWorker($userId)
    {
        $user = User::where('id', $userId)->first();
        $tasks = Task::where('user_id', $user->id)->get();
        $notes = Note::where('user_id', $user->id)->get();
        return view('worker.list', [
            'user' => $user,
            'tasks' => $tasks,
            'notes' => $notes,
        ]);
    }

    public function getWorkerTasks()
    {
        $user_id = auth()->user()->id;

        $task = Task::where('user_id', $user_id)->get();
        return $task;
    }

    public function updatePreferred(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->preferred_working_hours_per_day = $request->preferred_working_hours_per_day;
        $user->save();

        return ('horas actualizadas correctamente.');
    }

    public function updateUserData(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->username = $request->username;
        $user->save();

        return ('user data actualizadas correctamente.');
    }

    public function updateUserPassword(Request $request)
    {
        $user = User::findOrFail($request->id);

        if (auth()->attempt(['username' => $request->username, 'password' => $request->oldPassword]) && ($request->newPassword == $request->newPasswordRepeat) && (strlen($request->newPassword) >= 6)) {
            $user->password = bcrypt($request->newPassword);
            $user->save();
            return ('contraseña cambiada correctamente');
        } else {
            return false;
        }
    }
}
