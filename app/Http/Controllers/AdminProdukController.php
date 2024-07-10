<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use RealRashid\SweetAlert\Facades\Alert;    
use Illuminate\Http\Request;
use App\Models\Produk;


class AdminProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = [
            'title' =>'Manajemen Produk',
            'produk' => Produk::paginate(10),
            'content' => 'admin/produk/index'
        ];
            return view('admin.layouts/wrapper',$data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = [
            'title' =>'Tambah Produk',
            'kategori' => kategori::get(),
            'content'  => 'admin/produk/create'
        ];
        
        return view('admin.layouts/wrapper', $data); 

    }

    /**
     * Store a newly created resource in storage.           
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'name' => 'required',
            'kategori_id' => 'required',
            'harga' => 'required',
            'stock' => 'required'
        ]);
            if ($request->hasFile('gambar')){
                $gambar = $request->file('gambar');
                $file_name = time()."_".$gambar->getClientOriginalName();

                $storage = 'uploads/images/'    ;
                $gambar->move($storage, $file_name);
                $data['gambar'] = $storage . $file_name;
            }else{
              
                $data['gambar'] = null;
            }
               
        Produk::create($data);
        Alert::success('Sukses','Data berhasil di tambahkan');
        return redirect()->back();
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
         //
         $data = [
            'title' =>'Tambah Produk',
            'produk' => Produk::find($id),
            'kategori' => kategori::get(),
            'content' => 'admin/produk/create'
        ];
        return view('admin.layouts/wrapper', $data); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $produk = Produk::find($id);
            $data = $request->validate([
                'name' => 'required',
                'kategori_id' => 'required',
                'harga' => 'required',
                'stock' => 'required'
            ]);

        if ($request->hasFile('gambar')){
            $gambar = $request->file('gambar');
            $file_name = time()."_".$gambar->getClientOriginalName();

            $storage = 'uploads/images/'    ;
            $gambar->move($storage, $file_name);
            $data['gambar'] = $storage . $file_name;
        }else{
          
            $data['gambar'] = $produk->gambar;
        }

        $produk->update($data);
        Alert::success('Sukses','Data berhasil di edit');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $produk = Produk::find($id);
        if ($produk->gambar != null){
            unlink($produk->gambar);
        }
        $produk->delete();
        Alert::success('Sukses','Data berhasil di hapus');
        return redirect()->back();
    }
}