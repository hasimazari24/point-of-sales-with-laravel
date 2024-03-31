<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class PembelianDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_pembelian = session('id_pembelian');
        $produk = Produk::orderBy('nama_produk')->get();
        $supplier = Supplier::find(session('id_supplier'));
        $diskon = Pembelian::find($id_pembelian)->diskon ?? 0;

        if (!$supplier) {
            abort(404);
        }

        return view('pembelian_detail.index', compact('id_pembelian', 'produk', 'supplier','diskon'));
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
        $produk = Produk::where('id_produk', $request->id_produk)->first();
        if (!$produk) {
            return response()->json(['message' => 'Gagal disimpan']);
        }

        $detail = new PembelianDetail();
        $detail->id_pembelian = $request->id_pembelian;
        $detail->id_produk = $produk->id_produk;
        $detail->harga_beli = $produk->harga_beli;
        $detail->jumlah = 1;
        $detail->sub_total = $produk->harga_beli;
        $detail->save();

        return response()->json(['message' => 'Berhasil disimpan']);
    }

    public function data($id)
    {
        $detail = PembelianDetail::with('produk')
            ->where('id_pembelian', $id)
            ->get();
        //return $detail;
        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['kode_produk'] = '<span class="badge bg-purple disabled color-palette" style="width:100px">' . $item->produk['kode_produk'] . '</span';
            $row['nama_produk'] = $item->produk['nama_produk'];
            $row['harga_beli']  = 'Rp. ' . format_uang($item->harga_beli);
            $row['jumlah']      = '<input type="number" class="form-control input-sm quantity" data-id="' . $item->id_pembelian_detail . '" value="' . $item->jumlah . '">';
            $row['sub_total']    = 'Rp. ' . format_uang($item->sub_total);
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`' . route('pembelian_detail.destroy', $item->id_pembelian_detail) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                                </div>';
            $data[] = $row;

            $total += $item->harga_beli * $item->jumlah;
            $total_item += $item->jumlah;
        }
        //bikin baris baru buat hitung totoal keseluruhan dan ini dihide melalui css ppush
        $data[] = [
            'kode_produk' => '
                <div class="total hide">' . $total . '</div>
                <div class="total_item hide">' . $total_item . '</div>',
            'nama_produk' => '',
            'harga_beli'  => '',
            'jumlah'      => '',
            'sub_total'    => '',
            'aksi'        => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'kode_produk', 'jumlah'])
            ->make(true);

        // return datatables()
        //     ->of($detail)
        //     ->addIndexColumn()
        //     ->addColumn('nama_produk',  function ($detail) {
        //         return $detail->produk['nama_produk'];
        //     })
        //     ->addColumn('kode_produk', function ($detail) {
        //         return '<span class="badge bg-purple disabled color-palette" style="width:100px">'. $detail->produk['kode_produk'] .'</span>';
        //     })
        //     ->addColumn('harga_beli', function ($detail) {
        //         return 'Rp ' . format_uang($detail->harga_beli);
        //     })
        //     ->addColumn('jumlah', function ($detail) {
        //         return '<input type="number" class="form-control input-sm quantity" data-id="' . $detail->id_pembelian_detail . '" value="' . $detail->jumlah . '">';
        //     })
        //     ->addColumn('sub_total', function ($detail) {
        //         return 'Rp ' . format_uang($detail->sub_total);
        //     })
        //     ->addColumn('aksi', function ($detail) {
        //         return '
                
        //             <button type="button" onclick="deleteData(`' . route('pembelian_detail.destroy', $detail->id_pembelian_detail) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                
        //         ';
        //     })
        //     ->rawColumns(['aksi','kode_produk','jumlah'])
        //     ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PembelianDetail  $pembelianDetail
     * @return \Illuminate\Http\Response
     */
    public function show(PembelianDetail $pembelianDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PembelianDetail  $pembelianDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(PembelianDetail $pembelianDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PembelianDetail  $pembelianDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->jumlah > 0){
            $detail             = PembelianDetail::find($request->id_pembelian_detail);
            $detail->jumlah     = $request->jumlah;
            $detail->sub_total  = $detail->harga_beli * $request->jumlah;
            $detail->update();

            return response()->json(['message' => 'Berhasil disimpan']);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PembelianDetail  $pembelianDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = PembelianDetail::find($id);
        $detail->delete();

        return response()->json(['message' => 'Berhasil dihapus']);
    }

    public function loadForm($diskon, $total)
    {
        $bayar = $total - ($diskon / 100 * $total);
        $data  = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(format_terbilang($bayar) . ' Rupiah')
        ];

        return response()->json($data);
    }
}
