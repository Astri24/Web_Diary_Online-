<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web;
use App\Models\Gallery;
use Storage;
use Alert;
use Str;
use Auth;

class GalleryBackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['gallery'] = Gallery::paginate(6);
        $data['web'] = Web::all();
        return view('back.gallery.data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['web'] = Web::all();
        return view('back.gallery.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|min:3|max:100|unique:gallery',
            'gambar' => 'required',
        ],
        [
            'judul.required' => 'Judul harus di isi.',
            'judul.min' => 'Minimal karakter tidak boleh kurang dari 3 karakter',
            'judul.max' => 'Maksimal karakter tidak boleh lebih dari 100 karakter',
            'judul.unique' => 'Judul sudah tersedia.',
            'gambar.required' => 'Gambar harus di isi.',
        ]);

        $gambar = ($request->gambar) ? $request->file('gambar')->store("/public/input/gallery") : null;
        
        $data = [
            'judul' => $request->judul,
            'gambar' => $gambar
        ];

        Gallery::create($data)
        ? Alert::success('Berhasil', 'Gallery telah berhasil ditambahkan!')
        : Alert::error('Error', 'Gallery gagal ditambahkan!');

        return redirect()->route('gallery-back.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['gallery'] = Gallery::find($id);
        $data['web'] = Web::all();
        return view('back.gallery.edit', $data);
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
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'edit_judul' => "required|min:3|max:100|unique:gallery,judul,$gallery->id",
            'edit_gambar' => 'required',
        ],
        [
            'edit_judul.required' => 'Judul harus di isi.',
            'edit_judul.min' => 'Minimal karakter tidak boleh kurang dari 3 karakter',
            'edit_judul.max' => 'Maksimal karakter tidak boleh lebih dari 100 karakter',
            'edit_judul.unique' => 'Judul sudah tersedia.',
            'edit_gambar.required' => 'Gambar harus di isi.',
        ]);

        if($request->hasFile('edit_gambar')) {
            if(Storage::exists($gallery->gambar) && !empty($gallery->gambar)) {
                Storage::delete($gallery->gambar);
            }

            $edit_gambar = $request->file("edit_gambar")->store("/public/input/gallery");
        }
        $data = [
            'judul' => $request->edit_judul ? $request->edit_judul : $gallery->judul,
            'gambar' => $request->hasFile('edit_gambar') ? $edit_gambar : $gallery->gambar,
           
        ];

        $gallery->update($data)
        ? Alert::success('Berhasil', "Gallery telah berhasil diubah!")
        : Alert::error('Error', "Gallery gagal diubah!");

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
        $gallery = Gallery::findOrFail($id);
        Storage::delete($gallery->gambar);
        $gallery->delete()
            ? Alert::success('Berhasil', "Gallery telah berhasil dihapus.")
            : Alert::error('Error', "Gallery gagal dihapus!");

        return redirect()->back();
    }
}
