<?php
    function format_uang($nominal){
        $hasil = number_format($nominal, 0, ',', '.');
        return $hasil;
    }

    function format_terbilang($nominal){
        $nominal = abs($nominal); //jadikan absolut nilainya
        //baca nominal
        $baca = array('','satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan','sepuluh','sebelas');
        $terbilang = '';

        //membaca nominal satuan 
        if ($nominal < 12){
            $terbilang = ' '.$baca[$nominal];
        } 
        //membaca nominal belasan artinya di atasnya 12 < 20
        elseif ($nominal < 20) {
            $terbilang = format_terbilang($nominal-10).' belas';
        }
        //membaca nominal puluhan dan hasil bagi 10 jika sisa maka sambungannya
        elseif ($nominal < 100) {
            $terbilang = format_terbilang($nominal / 10).' puluh'.format_terbilang($nominal % 10);
        }
        //membaca ratusan 100 - 199 (seratusan)
        elseif ($nominal < 200) {
            $terbilang = ' seratus'.format_terbilang($nominal - 100);
        }
        //membaca ratusan di atas 200 - 999
        elseif ($nominal < 1000) {
            $terbilang = format_terbilang($nominal / 100) . ' ratus' . format_terbilang($nominal % 100);
        }
        //membaca puluhan 1000 - 1999 (seribuan)
        elseif ($nominal < 2000) {
            $terbilang = ' seribu' . format_terbilang($nominal - 1000);
        }
        //membaca ribuan di atas 2.000 - 99.999
        elseif ($nominal < 1000000) {
            $terbilang = format_terbilang($nominal / 1000) . ' ribu' . format_terbilang($nominal % 1000);
        }
        //membaca ribuan di atas 1.000.000 - 999.999.990
        elseif ($nominal < 1000000000) {
            $terbilang = format_terbilang($nominal / 1000000) . ' juta' . format_terbilang($nominal % 1000000);
        }

        return $terbilang;
    }

    function tanggal_indonesia($tgl,$tampil_hari = true){
        $nama_bulan = array(
            1=> 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'
        ); //index tidk lagi dimulai 0 tapi ==> 1

        $nama_hari = array('Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu');
        $text = '';

        //format tgl 2021-03-29
        if ($tgl != '' OR $tgl != null) {
            $tahun = substr($tgl, 0, 4); //ambil string tgl dari index 0 sebanyak 4 karakter
            $bulan = $nama_bulan[(int) substr($tgl, 5, 2)]; //ambil array nama_bulan index ke[substr dikonvert ke int]
            $tanggal = substr($tgl, 8, 2);

            if ($tampil_hari) {
                $urutanhari = $nama_hari[date('w', mktime(0, 0, 0, substr($tgl, 5, 2), $tanggal, $tahun))];
                $text .= "$urutanhari, $tanggal $bulan $tahun";
            } else {
                $text .= "$tanggal $bulan $tahun";
            }
        }
        
        return $text;
    }

    function tambah_nol_didepan($value, $threshold=null){
        return sprintf("%0". $threshold . "s", $value);
    }
?>