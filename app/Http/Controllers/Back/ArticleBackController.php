<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ArticleBackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['article'] = Article::paginate(6);
        $data['web'] = Web::all();
        return view('back.article.data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['web'] = Web::all();
        return view('back.article.create', $data);
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
            'judul' => 'required|min:3|max:3000|unique:articles',
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

        $gambar = ($request->gambar) ? $request->file('gambar')->store("/public/input/article") : null;
        
        $data = [
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'gambar' => $gambar,
            'gambar' => $gambar,
            'konten' => $request->konten,
            'penulis' => Auth::user()->id,
        ];

        Article::create($data)
        ? Alert::success('Berhasil', 'Article telah berhasil ditambahkan!')
        : Alert::error('Error', 'Article gagal ditambahkan!');

        return redirect()->route('articles.index');
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
        $data['article'] = Article::find($id);
        $data['web'] = Web::all();
        return view('back.article.edit', $data);
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
        $article = Article::findOrFail($id);

        $request->validate([
            'edit_judul' => "required|min:3|max:3000|unique:articles,judul,$article->id",
            'edit_gambar' => 'required',
            'edit_konten' => 'required',
        ],
        [
            'edit_judul.required' => 'Judul harus di isi.',
            'edit_judul.min' => 'Minimal karakter tidak boleh kurang dari 3 karakter',
            'edit_judul.max' => 'Maksimal karakter tidak boleh lebih dari 3000 karakter',
            'edit_judul.unique' => 'Judul sudah tersedia.',
            'edit_gambar.required' => 'Gambar harus di isi.',
            'edit_konten.required' => 'Kontent harus di isi.',
        ]);

        if($request->hasFile('edit_gambar')) {
            if(Storage::exists($atasan->gambar) && !empty($atasan->gambar)) {
                Storage::delete($atasan->gambar);
            }

            $edit_gambar = $request->file("edit_gambar")->store("/public/input/article");
        }
        $data = [
            'judul' => $request->edit_judul ? $request->edit_judul : $article->judul,
            'gambar' => $request->hasFile('edit_gambar') ? $edit_gambar : $article->gambar,
            'slug' => $request->edit_judul ? Str::slug($request->edit_judul) : $article->slug,
            'konten' => $request->edit_konten ? $request->edit_konten : $article->konten,
            'penulis' => Auth::user()->id ?  Auth::user()->id : $article->penulis,
           
        ];

        $article->update($data)
        ? Alert::success('Berhasil', "Article telah berhasil diubah!")
        : Alert::error('Error', "Article gagal diubah!");

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
        $article = Article::findOrFail($id);
        Storage::delete($article->gambar);
        $atasan->delete()
            ? Alert::success('Berhasil', "Article telah berhasil dihapus.")
            : Alert::error('Error', "Article gagal dihapus!");

        return redirect()->back();
    }
}
