<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = User::when(request()->q, function ($users) {
            $users = $users->where('name', 'like', '%' . request()->q . '%');
        })->orderBy('id', 'DESC')->paginate(5);

        return view('page.user.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        return view('page.user.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = [
            'name.required' => Lang::get('web.name-required'),
            'email.required' => Lang::get('web.email-required'),
            'email' => Lang::get('web.email'),
            'password.required' => Lang::get('web.password-required'),
            'password' => Lang::get('web.confirm-password-same'),
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed'
        ], $message);

        if ($validator->fails()) {
            $validator->errors()->add('message',  Lang::get('web.create-failed'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        try {
            $data->save();
        } catch (\Exception $errors) {
            return redirect()->back()
                ->withInput()->withErrors(['message' => Lang::get('web.create-failed')]);
        }

        Session::flash('message', Lang::get('web.create-success'));
        return redirect()->route('user.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('page.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $message = [
            'name.required' => Lang::get('web.name-required'),
            'email' => Lang::get('web.email'),
            'email.required' => Lang::get('web.email-required'),
            'password.required' => Lang::get('web.password-required'),
            'password' => Lang::get('web.confirm-password-same')
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required:unique:users,email,' . $user->id,
            'password' => 'confirmed'
        ], $message);

        if ($validator->fails()) {
            $validator->errors()->add('message',  Lang::get('web.create-failed'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($request->password) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        }

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
        } catch (\Exception $errors) {
            return redirect()->back()
                ->withInput()->withErrors(['message' => Lang::get('web.update-failed')]);
        }
        Session::flash('message', Lang::get('web.create-success'));
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        if ($user) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}