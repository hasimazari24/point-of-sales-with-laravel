<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Barcode Produk</title>

    <style>
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <table width="100%">
        <tr>
            @foreach ($dataproduk as $produk)
                <td class="text-center" style="border: 1px solid #74747433;">
                    <div style="padding-top: 6px;padding-bottom: 10px">{{ $produk->nama_produk }} - Rp. {{ format_uang($produk->harga_jual) }}</div>
                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($produk->kode_produk, 'C39') }}" 
                        alt="{{ $produk->kode_produk }}"
                        width="180"
                        height="60">
                    <div style="padding-top: 6px">
                    {{ $produk->kode_produk }}</div>
                </td>
                @if ($no++ % 3 == 0)
        </tr><tr>                    
                @endif
            @endforeach
        </tr>
    </table>
</body>
</html>