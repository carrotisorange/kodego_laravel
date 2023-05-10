<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        // display all users from the users table
        return User::all();

        //select * from users;
    }

    public function create()
    {
        //display the form for creating a new user
        ddd('this is user create page');
    }

    public function store(Request $request)
    {
        // validate inputs
        $validated = $request->validate([
            'name' => ['required'],
            'email' => ['required','email', Rule::unique('users', 'email')],
            'mobile_number' => ['required', Rule::unique('users', 'mobile_number')],
            'password' => ['required'],
        ]);

        // insert new row into the users table
        return User::create([
            'name' => $request->name,
            'email' =>  $request->email,
            'password' => Hash::make($request->password),
            'mobile_number' => $request->mobile_number
        ]);

    }

    public function show($email)
    {
        // show a particular user from the users table
        return User::where('email', $email)->get();

        //select * from users where id = $id;
    }

    public function edit($id)
    {
        //display the form for editing an existing user
        ddd('this is user edit page');
    }

    public function update(Request $request, $id)
    {
        // validate inputs
        $validated = $request->validate([
            'name' => ['required'],
            'email' => ['required','email', Rule::unique('users', 'email')->ignore($id)],
            'mobile_number' => ['required', Rule::unique('users', 'mobile_number')->ignore($id)],
            'password' => ['required'],
        ]);

        //update a particular user from the users table
       return User::where('id', $id)
       ->update([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'mobile_number' => $request->mobile_number
       ]);
    }

    public function destroy($id)
    {
        //delete a particular user from the users table
        if(User::find($id)){
            return User::where('id', $id)
              ->delete();
        }
        
        return 'Not found!';
    }
}
