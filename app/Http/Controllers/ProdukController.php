<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use PDF;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::all()->pluck('nama_kategori','id_kategori');
        return view('produk.index', compact('kategori'));
    }

    public function data()
    {
        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
        ->select('produk.*', 'nama_kategori')
        ->orderBy('id_produk', 'desc')->get();

        return datatables()
            ->of($produk)
            ->addColumn('select_all', function ($produk) {
                return '
                    <input type="checkbox" class="idcheck" name="id_produk[]" value="' . $produk->id_produk . '">
                ';
            })
            ->addIndexColumn()
            ->addColumn('kode_produk', function ($produk) {
                return '<span class="badge bg-purple disabled color-palette" style="width:100px">' . $produk->kode_produk . '</span>';
            })
            ->addColumn('harga_beli', function ($produk) {
                return 'Rp ' . format_uang($produk->harga_beli);
            })
            ->addColumn('harga_jual', function ($produk) {
                return 'Rp ' . format_uang($produk->harga_jual);
            })
            ->addColumn('diskon', function ($produk) {
                return $produk->diskon.' %';
            })
            ->addColumn('aksi', function ($produk) {
                return '
                
                    <button type="button" onclick="editForm(`' . route('produk.update', $produk->id_produk) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="deleteData(`' . route('produk.destroy', $produk->id_produk) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                
                ';
            })
            ->rawColumns(['aksi', 'select_all', 'kode_produk','diskon'])
            ->make(true);
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
        $produk = Produk::latest()->first();

        if ($produk === null) {
            $request['kode_produk'] = 'P' . tambah_nol_didepan(1, 6);
            $produk = Produk::create($request->all());

            return response()->json(['message' => 'Berhasil disimpan']);
        } else {
            $request['kode_produk'] = 'P' . tambah_nol_didepan((int)$produk->id_produk+1, 6);
            $produk = Produk::create($request->all());

            return response()->json(['message' => 'Berhasil disimpan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::find($id);

        return response()->json($produk);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        $produk = Produk::find($id);
        $produk->update($request->all());

        return response()->json(['message' => 'Berhasil disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();

        return response()->json(['message' => 'Berhasil dihapus']);
    }

    public function deleteSelected(Request $request)
    {
        
        foreach($request->id_produk as $id) {
            //return $id;
            $produk = Produk::find($id);
            $produk->delete();
        }
        
        return response()->json(['message' => 'Berhasil dihapus']);
    }

    public function cetakBarcode(Request $request)
    {
        $dataproduk = array();
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $dataproduk[] = $produk;
        }

        $no  = 1;
        $pdf = PDF::loadView('produk.barcode', compact('dataproduk', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('produk.pdf');
    }

}
