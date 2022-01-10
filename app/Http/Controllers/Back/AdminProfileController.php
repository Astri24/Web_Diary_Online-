<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web;
use App\Models\User;
use Alert;
use Hash;

class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['web'] = Web::all();
        return view('back.admin_profile.data', $data);
    }

    public function checkProfileUsername(Request $request) 
    {
        if($request->Input('username')){
            $username = User::where('username',$request->Input('username'))->first();
            if($username){
                return 'false';
            }else{
                return  'true';
            }
        }
    }

    public function checkProfileEmail(Request $request) 
    {
        if($request->Input('email')){
            $email = User::where('email',$request->Input('email'))->first();
            if($email){
                return 'false';
            }else{
                return  'true';
            }
        }
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
        $user = User::findOrFail($id);
        
        $data = [
            'name' => $request->name ? $request->name : $user->name,
            'username' => $request->username ? $request->username : $user->username,
            'email' => $request->email ? $request->email : $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ];

        $user->update($data)
        ? Alert::success('Berhasil', "User telah berhasil diubah!")
        : Alert::error('Error', "User gagal diubah!");

        return redirect()->back();
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
}
