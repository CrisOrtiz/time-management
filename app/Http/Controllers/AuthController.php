<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $remember = $request->input('remember', false);

        $user = User::where('username', $username)
            ->where(function ($query) {
                $query->where('user_type', User::ADMIN)
                    ->orWhere('user_type', User::MANAGER)
                    ->orWhere('user_type', User::WORKER);
            })
            ->first();

        if (!$user) {
            return redirect()->back()->withErrors([
                'email' => 'Usuario incorrecto.'
            ]);
        }

        if (!auth()->attempt(['username' => $username, 'password' => $password], $remember)) {
            return redirect()->back()->withErrors([
                'password' => 'Contraseña incorrecta.'
            ]);
        }

        switch ($user->user_type) {
            case 1:
                return redirect()->route('admin.list', ['user_id' => $user->id]);
                break;

            case 2:
                return redirect()->route('manager.list', ['user_id' => $user->id]);
                break;

            case 3:
                return redirect()->route('worker.list', ['user_id' => $user->id]);
                break;
            default:
                return;
                break;
        }
    }

    public function showLogin()
    {
        return view('login');
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login');
    }


    protected function create(Request $request)
    {
        $name = $request->input('name');
        $surname = $request->input('surname');
        $username = $request->input('username');
        $password = $request->input('password');
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:user'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            User::create([
                'name' => strtolower($name),
                'surname' => strtolower($surname),
                'username' => $username,
                'password' => Hash::make($password),
                'user_type' => 3,
            ]);
            return redirect('login')->with('info', 'Usuario creado correctamente :)');
        }
    }

    public function managerCreate(Request $request)
    {
        $name = $request->newUser['name'];
        $surname = $request->newUser['surname'];
        $username = $request->newUser['username'];
        $password = $request->newUser['password'];
        $user_type = $request->newUser['user_type'];

        $newUser = User::create([
            'name' => strtolower($name),
            'surname' => strtolower($surname),
            'username' => $username,
            'password' => Hash::make($password),
            'user_type' => $user_type,
        ]);

        return json_encode($newUser);
    }

    public function managerDelete(Request $request)
    {
        $deleteUser = User::where('id', $request->user['id'])->first();

        if ($deleteUser->user_type = 3) {
            Task::where('user_id', $deleteUser->id)->delete();
            Note::where('user_id', $deleteUser->id)->delete();
        }

        $deleteUser->delete();

        return 'Usuario borrado correctamente';
    }

    public function managerUpdate(Request $request)
    {
        $editUser = User::where('id', $request->editUser['id'])->first();

        $editUser->name = $request->editUser['name'];
        $editUser->surname = $request->editUser['surname'];
        $editUser->username = $request->editUser['username'];
        if ($request->editUser['password'] != '') {
            $editUser->password = Hash::make($request->editUser['password']);
        }
        if ($request->editUser['user_type'] == 3) {
            $editUser->preferred_working_hours_per_day =(int)$request->editUser['preferred_working_hours_per_day'];
        }
        $editUser->user_type = $request->editUser['user_type'];
        $editUser->save();
        
        return  $editUser;
    }

    public function adminCreate(Request $request)
    {
        $name = $request->newUser['name'];
        $surname = $request->newUser['surname'];
        $username = $request->newUser['username'];
        $password = $request->newUser['password'];
        $user_type = $request->newUser['user_type'];

        $newUser = User::create([
            'name' => strtolower($name),
            'surname' => strtolower($surname),
            'username' => $username,
            'password' => Hash::make($password),
            'user_type' => $user_type,
        ]);

        return json_encode($newUser);
    }

    public function adminDelete(Request $request)
    {
        $deleteUser = User::where('id', $request->user['id'])->first();

        if ($deleteUser->user_type = 3) {
            Task::where('user_id', $deleteUser->id)->delete();
            Note::where('user_id', $deleteUser->id)->delete();
        }

        $deleteUser->delete();

        return 'Usuario borrado correctamente';
    }

    public function adminUpdate(Request $request)
    {
        $editUser = User::where('id', $request->editUser['id'])->first();

        $editUser->name = $request->editUser['name'];
        $editUser->surname = $request->editUser['surname'];
        $editUser->username = $request->editUser['username'];
        if ($request->editUser['password'] != '') {
            $editUser->password = Hash::make($request->editUser['password']);
        }
        if ($request->editUser['user_type'] == 3) {
            $editUser->preferred_working_hours_per_day =(int)$request->editUser['preferred_working_hours_per_day'];
        }
        $editUser->user_type = $request->editUser['user_type'];
        $editUser->save();
        
        return  $editUser;
    }


    public function showRegister()
    {
        return view('register');
    }
}
