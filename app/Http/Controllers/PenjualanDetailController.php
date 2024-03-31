<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\Setting;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PenjualanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::orderBy('nama_produk')->get();
        $member = Member::orderBy('nama')->get();
        $diskon = Setting::first()->diskon ?? 0;

        // Cek apakah ada transaksi yang sedang berjalan
        if ($id_penjualan = session('id_penjualan')) {
            $penjualan = Penjualan::find($id_penjualan);
            $memberSelected = $penjualan->member ?? new Member();

            return view('penjualan_detail.index', compact('produk', 'member', 'diskon', 'id_penjualan', 'penjualan', 'memberSelected'));
        } else {
            if (auth()->user()->level == 1) {
                return redirect()->route('transaksi.baru');
            } else {
                Alert::warning('Peringatan', 'Transaksi aktif tidak tersedia! silahkan buat baru');
                return redirect()->route('dashboard');
            }
        }
    }

    public function data($id)
    {
        $detail = PenjualanDetail::with('produk')
            ->where('id_penjualan', $id)
            ->get();

        // return $detail;

        $data = array();
        $total = 0;
        $total_item = 0;
        $total_diskon = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['kode_produk'] = '<span class="label label-success">' . $item->produk['kode_produk'] . '</span';
            $row['nama_produk'] = $item->produk['nama_produk'];
            $row['harga_jual']  = 'Rp. ' . format_uang($item->harga_jual);
            $row['jumlah']      = '<input type="number" class="form-control input-sm quantity" data-id="' . $item->id_penjualan_detail . '" value="' . $item->jumlah . '">';
            $row['diskon']      = 'Rp. '. format_uang($item->diskon);
            $row['subtotal']    = 'Rp. ' . format_uang($item->subtotal);
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`' . route('transaksi.destroy', $item->id_penjualan_detail) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                                </div>';
            $data[] = $row;

            $total += ($item->harga_jual * $item->jumlah) - ($item->diskon * $item->jumlah);
            $total_item += $item->jumlah;
            $total_diskon += $item->diskon;
        }
        $data[] = [
            'kode_produk' => '
                <div class="total hide">' . $total . '</div>',
            'nama_produk' => '',
            'harga_jual'  => '',
            'jumlah'      => '<div class="total_item hide">' . $total_item . '</div>',
            'diskon'      => '<div class="total_diskon hide">' . $total_diskon . '</div>',
            'subtotal'    => '',
            'aksi'        => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'kode_produk', 'jumlah','diskon'])
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
        $produk = Produk::where('id_produk', $request->id_produk)->first();
        $penjualandetail = PenjualanDetail::where(
            ['id_produk' => $request->id_produk,'id_penjualan' => $request->id_penjualan],
        )->first();

        if (!$produk) {
            return response()->json(['message' => 'Gagal simpan']);
        }

        if ($penjualandetail){
            $detail = PenjualanDetail::find($penjualandetail->id_penjualan_detail);
            $jml = $detail->jumlah+1;
            $detail->jumlah = $jml;
            $detail->subtotal = ($detail->harga_jual * $jml) - ($detail->diskon * $jml);
            $detail->update();

            return response()->json(['message' => 'produksama', 'id_penjualan_detail' => $detail->id_penjualan_detail]);
        }else{
            $detail = new PenjualanDetail();
            $detail->id_penjualan = $request->id_penjualan;
            $detail->id_produk = $produk->id_produk;
            $detail->harga_jual = $produk->harga_jual;
            $detail->jumlah = 1;
            $disc = ($produk->diskon / 100) * $produk->harga_jual;
            $detail->diskon = $disc;
            $detail->subtotal = $produk->harga_jual - $disc;
            $detail->save();

            return response()->json(['message' => 'Berhasil dipilih']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PenjualanDetail  $penjualanDetail
     * @return \Illuminate\Http\Response
     */
    public function show(PenjualanDetail $penjualanDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PenjualanDetail  $penjualanDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(PenjualanDetail $penjualanDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PenjualanDetail  $penjualanDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->jumlah > 0) {
            $detail = PenjualanDetail::find($request->id_penjualan_detail);
            $detail->jumlah = $request->jumlah;
            $detail->subtotal = ($detail->harga_jual * $request->jumlah) - ($detail->diskon * $request->jumlah);
            $detail->update();

            return response()->json(['message' => 'Berhasil disimpan']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PenjualanDetail  $penjualanDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = PenjualanDetail::find($id);
        $detail->delete();

        return response()->json(['message' => 'Berhasil dihapus']);
    }

    public function loadForm($diskon = 0, $total = 0, $diterima = 0)
    {
        $diskonrp = ($diskon/100) * $total;
        $bayar   = $total - $diskonrp;
        $kembali = ($diterima != 0) ? $diterima - $bayar : 0;
        $data    = [
            'totalrp' => format_uang($total),
            'diskonrp' => format_uang($diskonrp),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(format_terbilang($bayar) . ' Rupiah'),
            'kembalirp' => format_uang($kembali),
            'kembali_terbilang' => ucwords(format_terbilang($kembali) . ' Rupiah'),
        ];

        // return response()->json($data);
        return response()->json(['message' => 'Berhasil ditampilkan', $data]);
    }
}
