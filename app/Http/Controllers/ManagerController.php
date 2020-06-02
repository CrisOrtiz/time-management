<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Note;
use App\Models\Task;

class ManagerController extends Controller
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

    public function showHomeManager()
    {
        $user = User::where('id', auth()->user()->id)->first();
        return view('manager.home', [
            'user' => $user,
        ]);
    }


    public function showListManager()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $users = User::where('user_type', 3)->orWhere('user_type', 2)->orderBy('name')->get();
        $notes = Note::all();
        $tasks = Task::all();
        return view('manager.list', [
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

    public function getSortedWorkers(Request $request)
    {
        $sortedWorkers = User::where('user_type', 3)->orWhere('user_type', 2)
            ->orderBy('name', $request->sort)
            ->get();
        return response()->json($sortedWorkers);
    }
}
