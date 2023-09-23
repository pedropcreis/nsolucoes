<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;

class UserController extends Controller
{
    public function index() {
        return view('users.index');
    }

    public function list() {
        $users = User::whereIn('user_type', ['A', 'F'])->orderBy('name', 'ASC');
        return DataTables::of($users)->make(true);
    }

    public function create() {
        return view('users.create');
    }

    public function store() {
        try {

            DB::beginTransaction();

            $user = new User;

            $user->name = request('name');
            $user->password = Hash::make(request('password'));
            $user->email = request('email');
            $user->user_type = request('user_type');

            $user->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Usuário cadastrado.'
            ]);

        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Houve um erro inesperado. Tente novamente.',
                'verbose' => $e,
            ]);
        }
    }
}
