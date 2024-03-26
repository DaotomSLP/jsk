<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        if(Auth::user()->is_admin != 1){
            return redirect('access_denied');
        }

        $result = User::query();

        $result->select('users.*');

        if ($request->name != '') {
            $result->where('users.name', $request->name);
        }

        if ($request->enabled != '') {
            if ($request->enabled == "1") {
                $result->where('users.enabled', '1');
            } else {
                $result->where('users.enabled', '<>', '1');
            }
        }

        if ($request->email != '') {
            $result->where('email', $request->email);
        }

        $all_users = $result->orderBy('users.id', 'desc')
            ->get();

        if ($request->page != '') {
            $result->offset(($request->page - 1) * 25);
        }

        $users = $result->orderBy('users.id', 'desc')
            ->limit(25)
            ->get();

        $pagination = [
            'offsets' =>  ceil(sizeof($all_users) / 25),
            'offset' => $request->page ? $request->page : 1,
            'all' => sizeof($all_users)
        ];

        return view('users', compact('users', 'pagination'));
    }


    public function insert(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->is_admin = '0';
        $user->enabled = '1';
        $user->phone_no = $request->phone_no;

        try {
            if ($user->save()) {
                return redirect('users')->with(['error' => 'insert_success']);
            } else {
                return redirect('users')->with(['error' => 'not_insert']);
            }
        } catch (\Throwable $th) {
            return redirect('users')->with(['error' => 'not_insert']);
        }
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first();

        return view('editUser', compact('user'));
    }

    public function update(Request $request)
    {
        $user = [
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => Auth::user()->id == $request->id ? '1' : '0',
            'enabled' => '1',
            'phone_no' => $request->phone_no
        ];

        if (User::where('id', $request->id)->update($user)) {
            return redirect('users')->with(['error' => 'insert_success']);
        } else {
            return redirect('users')->with(['error' => 'not_insert']);
        }
    }

    public function delete($id)
    {
        $user_data = User::where('id', $id)->first();

        $user = [
            'enabled' => $user_data->enabled == "1" ? "0" : "1"
        ];

        if (User::where('id', $id)->update($user)) {
            return redirect('users')->with(['error' => 'insert_success']);
        } else {
            return redirect('users')->with(['error' => 'not_insert']);
        }
    }

    public function partner(Request $request)
    {

        if(Auth::user()->is_admin != 1){
            return redirect('access_denied');
        }

        $result = User::query();

        $result->select('users.*')
            ->where('is_super_admin', NULL);

        if ($request->name != '') {
            $result->where('users.name', $request->name);
        }

        if ($request->enabled != '') {
            if ($request->enabled == "1") {
                $result->where('users.enabled', '1');
            } else {
                $result->where('users.enabled', '<>', '1');
            }
        }

        if ($request->email != '') {
            $result->where('email', $request->email);
        }

        $all_users = $result->orderBy('users.id', 'desc')
            ->get();

        if ($request->page != '') {
            $result->offset(($request->page - 1) * 25);
        }

        $users = $result->orderBy('users.id', 'desc')
            ->limit(25)
            ->get();

        $pagination = [
            'offsets' =>  ceil(sizeof($all_users) / 25),
            'offset' => $request->page ? $request->page : 1,
            'all' => sizeof($all_users)
        ];

        return view('partner', compact('users', 'pagination'));
    }


    public function insertPartner(Request $request)
    {
        if ($request->is_thai || $request->is_ch) {
            $user = new User;
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->is_admin = '0';
            $user->enabled = '1';
            $user->phone_no = $request->phone_no;
            $user->is_owner = '0';
            $user->is_thai_partner = $request->is_thai;

            try {
                if ($user->save()) {
                    return redirect('partner')->with(['error' => 'insert_success']);
                } else {
                    return redirect('partner')->with(['error' => 'not_insert']);
                }
            } catch (\Throwable $th) {
                return redirect('partner')->with(['error' => 'not_insert']);
            }
        } else {
            return redirect('partner')->with(['error' => 'not_insert']);
        }
    }

    public function editPartner($id)
    {
        $user = User::where('id', $id)->first();

        return view('editPartner', compact('user'));
    }

    public function updatePartner(Request $request)
    {
        if ($request->is_thai || $request->is_ch) {
            $user = [
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'enabled' => '1',
                'phone_no' => $request->phone_no,
            ];

            if (User::where('id', $request->id)->update($user)) {
                return redirect('partner')->with(['error' => 'insert_success']);
            } else {
                return redirect('partner')->with(['error' => 'not_insert']);
            }
        } else {
            return redirect('partner')->with(['error' => 'not_insert']);
        }
    }


    public function admin(Request $request)
    {

        if(Auth::user()->is_owner != 1){
            return redirect('access_denied');
        }

        $result = User::query();

        $result->select('users.*');

        if ($request->name != '') {
            $result->where('users.name', $request->name);
        }

        if ($request->enabled != '') {
            if ($request->enabled == "1") {
                $result->where('users.enabled', '1');
            } else {
                $result->where('users.enabled', '<>', '1');
            }
        }

        if ($request->email != '') {
            $result->where('email', $request->email);
        }

        $all_users = $result->orderBy('users.id', 'desc')
            ->get();

        if ($request->page != '') {
            $result->offset(($request->page - 1) * 25);
        }

        $users = $result->orderBy('users.id', 'desc')
            ->limit(25)
            ->get();

        $pagination = [
            'offsets' =>  ceil(sizeof($all_users) / 25),
            'offset' => $request->page ? $request->page : 1,
            'all' => sizeof($all_users)
        ];

        return view('admin', compact('users', 'pagination'));
    }

    public function insertAdmin(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->is_admin = '1';
        $user->enabled = '1';
        $user->phone_no = $request->phone_no;
        $user->is_owner = '0';

        try {
            if ($user->save()) {
                return redirect('admin')->with(['error' => 'insert_success']);
            } else {
                return redirect('admin')->with(['error' => 'not_insert']);
            }
        } catch (\Throwable $th) {
            return redirect('admin')->with(['error' => 'not_insert']);
        }
    }

    public function editAdmin($id)
    {
        $user = User::where('id', $id)->first();

        return view('editAdmin', compact('user'));
    }

    public function updateAdmin(Request $request)
    {
        $user = [
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'enabled' => '1',
            'phone_no' => $request->phone_no,
        ];

        if (User::where('id', $request->id)->update($user)) {
            return redirect('admin')->with(['error' => 'insert_success']);
        } else {
            return redirect('admin')->with(['error' => 'not_insert']);
        }
    }

    public function access_denied(){
        return view('accessDenied');
    }
}
