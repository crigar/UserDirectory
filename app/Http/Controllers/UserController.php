<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $users;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        log::info($request->all());
        $user = new User;
        $user->job_title = $request->input('job_title');
        $user->email = $request->email;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->document = $request->document;
        $user->phone_number = $request->phone_number;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->username = $request->username;
        $user->pass = Hash::make($request->pass);
        $user->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function showUserById( $document)
    {
        $response = array(
            "success" => false,
            "user" => null,
        );
        $user = User::where('document', $document)->first();
        if ($user != null) {
            $response['success'] = true;
            $response['user'] = $user;
        }
        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $username = $request->input('username');
        $first_name = $request->input('first_name');
        $user = User::find(6);
        $user->first_name = $first_name;
        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
    }

     /**
     * Remove tall
     *
     * @return \Illuminate\Http\Response
     */
    public function removeAll()
    {
        User::truncate();
    }

    /**
     * login.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        log::info($request->all());
        $response = array(
            "success" => false,
        );
        $username = $request->input('username');
        $pass = $request->input('pass');
        $user = User::where('username', $username)->first();
        
        if ($user != null) {
            if (Hash::check($pass, $user->pass)) {
                $userId = $user->id;
                $token = Str::random(60);
                $user = User::find($user->id);
                $user->token = $token;
                $user->save();
                $response['success'] = true;
                $response['token'] = $token;
            }
        }
        return response()->json($response);
    }

    /**
     * logout.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $response = array(
            "success" => false,
        );
        $token = $request->input('token');
        $user = User::where('token', $token)->first();
        if ($user) {
            $user->token = '';
            $user->save();
            $response['success'] = true;
        }
        return response()->json($response);
    }

    /**
     * search.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $param = $request->input('param');
        $users = User::where('email', $param)
                ->orwhere('first_name', 'like', '%'. $param . '%')
                ->orwhere('last_name', 'like', '%'. $param . '%')
                ->get();
        $response['users'] = $users;
        return response()->json($response);
    }

   
}
