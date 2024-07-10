<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;


class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $data = [
            'title' => 'Manajemen User',
            'user' => User::get(),
            'content' => 'admin.user.index'
        ];
        return view('admin.layouts.wrapper' , $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        //
        $data = [
            'content' => 'admin.user.create'
        ];
        return view('admin.layouts.wrapper' , $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required |email|unique:users',
            'password' => 'required',
            're_password' => 'required|same:password',


        ]);

        User::create($data);
        Alert::success('Sukses', 'Data telah di tambahkan');
        return redirect('/admin/user')->with('success', 'Data telah di tambahkan');;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = [
            'user'    => User::find($id),
            'content' => 'admin.user.create'
        ];
        return view('admin.layouts.wrapper' , $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = User::find($id);
        $data = $request->validate([
            'name' => 'required',   
            'email' => 'required |email|unique:users,email,' . $user->id,
            // 'password' => 'required',
            're_password' => 'required|same:password',
        ]);

        if ($request->password !='') {
            $data['password'] = Hash::make($request->password);
        } else {
            $data['password'] = $user->password;
        }

        $user->update($data);
        Alert::success('Sukses', 'Data telah di edit');
        return redirect('/admin/user')->with('success', 'Data telah di edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::find($id);
        $user->delete();
        Alert::success('Sukses', 'Data telah di hapus');
        return redirect('/admin/user')->with('success', 'Data telah di hapus!!');;
    }
}
