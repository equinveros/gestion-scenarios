<?php

namespace App\Http\Controllers;

use App\User;
use App\Profil;
use Illuminate\Http\Request;

class UserController extends Controller {
    protected $userRepository;

    protected $nbrPerPage = 4;

    public function showBoard(Request $request) {
        $user = User::where('id', $request['user_id'])->firstOrFail();
        $profils = Profil::all();
        $users = User::where([['id',
                               '!=',
                               $request['user_id']],
                              ['admin',
                               0],
                              ['delete',
                               0]])->get();
        foreach ($users as $u) {
            $u['profil'] = Profil::where('id', $u->profil_id)->firstOrFail()->name;
        }
        return view('administration/admin_userBoard', compact('user', 'user', 'users', 'profils'));
    }

    public function getUser($id) {
        $user = User::where('id', $id)->firstOrFail();
        return $user;
    }
    public function editUser($id) {
        $user = User::where('id', $id)->firstOrFail();
        return view('utilisateur/user_edit', compact('user'));
    }

    public function deleteUser($id) {
        $user = User::where('id', $id)->firstOrFail();
        $user->delete = 1;

        $user->save();
        return lists();
    }

    public function lists() {
        $users = User::where([['admin',
                               0],
                              ['delete',
                               0]])->get();
        foreach ($users as $u) {
            $u['profil'] = Profil::where('id', $u->profil_id)->firstOrFail()->name;
        }
        return view('utilisateur/user_liste', compact('users'));
    }

    public function index() {

    }

    public function create() {
        return view('create');
    }

    public function store(UserCreateRequest $request) {
    }

    public function show($id) {
    }

    public function edit($id) {
    }

    public function update(UserUpdateRequest $request, $id) {
    }

    public function destroy($id) {
    }
}
