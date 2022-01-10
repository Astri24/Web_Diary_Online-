<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web;
use Storage;
use Alert;

class WebProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['web'] = Web::all();
        return view('back.web_profile.data', $data);
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
        
        $photo = ($request->photo) ? $request->file('photo')->store("/public/input/web") : null;

        $data = [
            'primary_color' => $request->primary_color,
            'name' => $request->name,
            'description' => $request->description,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'email' => $request->email,
            'photo' => $photo,
            'updator' => '1',
        ];

        Web::create($data)
        ? Alert::success('Berhasil', 'Profile Web telah berhasil ditambahkan!')
        : Alert::error('Error', 'Profile Web gagal ditambahkan!');

        return redirect()->back();
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
        $web = Web::findOrFail($id);
        
        if($request->hasFile('edit_photo')) {
            if(Storage::exists($web->photo) && !empty($web->photo)) {
                Storage::delete($web->photo);
            }

            $edit_photo = $request->file("edit_photo")->store("/public/input/web");
        }

        $data = [
            'primary_color' => $request->edit_primary_color ? $request->edit_primary_color : $web->primary_color,
            'name' => $request->edit_name ? $request->edit_name : $web->name,
            'description' => $request->edit_description ? $request->edit_description : $web->description,
            'facebook' => $request->edit_facebook ? $request->edit_facebook : $web->facebook,
            'instagram' => $request->edit_instagram ? $request->edit_instagram : $web->instagram,
            'twitter' => $request->edit_twitter ? $request->edit_twitter : $web->twitter,
            'email' => $request->edit_email ? $request->edit_email : $web->email,
            'photo' => $request->hasFile('edit_photo') ? $edit_photo : $web->photo,
            'updator' => '1',
        ];

        $web->update($data)
        ? Alert::success('Berhasil', "Profil Web telah berhasil diubah!")
        : Alert::error('Error', "Profil Web gagal diubah!");

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
        $web = Web::findOrFail($id);
        Storage::delete($web->photo);
        $web->delete()
            ? Alert::success('Berhasil', "Profil Web telah berhasil dihapus.")
            : Alert::error('Error', "Profil Web gagal dihapus!");

        return redirect()->back();
    }
}
