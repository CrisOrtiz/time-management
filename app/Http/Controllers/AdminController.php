<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\Note;

class AdminController extends Controller
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

    public function showHomeAdmin()
    {
        $user = User::where('id', auth()->user()->id)->first();
        return view('admin.home', [
            'user' => $user,
        ]);
    }

    public function showListAdmin()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $users = User::all();
        $notes = Note::all();
        $tasks = Task::all();
        return view('admin.list', [
            'user' => $user,
            'users' => $users,
            'notes' => $notes,
            'tasks' => $tasks
        ]);
    }

    public function updateUserData(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->username = $request->username;
        $user->preferred_working_hours_per_day = $request->preferred_working_hours_per_day;
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

    public function getSortedNameWorkers(Request $request)
    {
        $sortedWorkers = User::orderBy('name', $request->sort)
            ->get();
        return response()->json($sortedWorkers);
    }


    public function getSortedUserTypeWorkers(Request $request)
    {
        $sortedWorkers = User::orderBy('user_type', $request->sort)
            ->get();
        return response()->json($sortedWorkers);
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
        return view('layouts.worker-page', [
            'user' => $user,
            'tasks' => $tasks,
            'notes' => $notes,
        ]);
    }
}
