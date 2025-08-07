<?php

namespace App\Http\Controllers;
use App\Models\kategori; 

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index(){
        $kategori = kategori::all();//fatch data kategori
        return view('kategori.index',compact('kategori'));
    }
     public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategoris,nama_kategori,' . $request->id,
            'deskripsi' => 'required|max:100|min:10|string',
        ],[
            'nama_kategori.required' => 'Nama kategori harus diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
            'deskripsi.required' => 'Deskripsi harus diisi.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 100 karakter.',
            'deskripsi.min' => 'Deskripsi minimal 10 karakter.',
        ]);
        $kategori = Kategori::updateOrCreate(
            ['id' => $request->id],
            [
                'nama_kategori' => $request->nama_kategori,
                'slug' => Str::slug($request->nama_kategori),
                'deskripsi' => $request->deskripsi,
            ]
        );
        toast()->success('Kategori berhasil disimpan!', 'Success');
        return redirect()->route('master-data.kategori.index');
    }
    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        toast()->success('Kategori berhasil dihapus!', 'Success');
        return redirect()->route('master-data.kategori.index');
    }
}
