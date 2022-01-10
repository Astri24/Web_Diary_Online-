<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web;
use App\Models\Note;
use Storage;
use Alert;
use Str;
use Auth;

class NoteBackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['note'] = Note::paginate(6);
        $data['web'] = Web::all();
        return view('back.note.data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['web'] = Web::all();
        return view('back.note.create', $data);
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
            'judul' => 'required|min:3|max:3000|unique:notes',
            'gambar' => 'required',
            'konten' => 'required',
        ],
        [
            'judul.required' => 'Judul harus di isi.',
            'judul.min' => 'Minimal karakter tidak boleh kurang dari 3 karakter',
            'judul.max' => 'Maksimal karakter tidak boleh lebih dari 3000 karakter',
            'judul.unique' => 'Judul sudah tersedia.',
            'gambar.required' => 'Gambar harus di isi.',
            'konten.required' => 'Kontent harus di isi.',
        ]);

        $gambar = ($request->gambar) ? $request->file('gambar')->store("/public/input/note") : null;
        
        $data = [
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'gambar' => $gambar,
            'gambar' => $gambar,
            'konten' => $request->konten,
            'penulis' => Auth::user()->id,
        ];

        Note::create($data)
        ? Alert::success('Berhasil', 'Note telah berhasil ditambahkan!')
        : Alert::error('Error', 'Note gagal ditambahkan!');

        return redirect()->route('note-back.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
       $data['web'] = Web::all();
       $data['note'] = Note::where('slug',$slug)->first();
       return view('back.note.preview', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['note'] = Note::find($id);
        $data['web'] = Web::all();
        return view('back.note.edit', $data);
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
        $note = Note::findOrFail($id);

        $request->validate([
            'edit_judul' => "required|min:3|max:3000|unique:notes,judul,$note->id",
            'edit_konten' => 'required',
        ],
        [
            'edit_judul.required' => 'Judul harus di isi.',
            'edit_judul.min' => 'Minimal karakter tidak boleh kurang dari 3 karakter',
            'edit_judul.max' => 'Maksimal karakter tidak boleh lebih dari 3000 karakter',
            'edit_judul.unique' => 'Judul sudah tersedia.',
            'edit_konten.required' => 'Kontent harus di isi.',
        ]);

        if($request->hasFile('edit_gambar')) {
            if(Storage::exists($note->gambar) && !empty($note->gambar)) {
                Storage::delete($note->gambar);
            }

            $edit_gambar = $request->file("edit_gambar")->store("/public/input/note");
        }
        $data = [
            'judul' => $request->edit_judul ? $request->edit_judul : $note->judul,
            'gambar' => $request->hasFile('edit_gambar') ? $edit_gambar : $note->gambar,
            'slug' => $request->edit_judul ? Str::slug($request->edit_judul) : $note->slug,
            'konten' => $request->edit_konten ? $request->edit_konten : $note->konten,
            'penulis' => Auth::user()->id ?  Auth::user()->id : $note->penulis,
           
        ];

        $note->update($data)
        ? Alert::success('Berhasil', "Note telah berhasil diubah!")
        : Alert::error('Error', "Note gagal diubah!");

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
        $note = Note::findOrFail($id);
        Storage::delete($note->gambar);
        $note->delete()
            ? Alert::success('Berhasil', "Note telah berhasil dihapus.")
            : Alert::error('Error', "Note gagal dihapus!");

        return redirect()->back();
    }
}
