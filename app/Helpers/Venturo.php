<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;

class Venturo {

    /**
     * Load view untuk digenerate ke PDF
     * 
     * @author Wahyu Agung <wahyuagung26@email.com>
     *
     * @param  string $filePath path ke file blade di folder resource/views/generate/pdf
     * @param  string $data data yang akan dirender pada view
     * @param  string $title judul / nama file ketika di download
     * @param  array  $paperSize ukuran kertas dan orientasinya
     * @return object
     */
    private static function loadPdf($filePath, $data, $title = 'no-title.pdf', $paperSize = ['paper' => 'a4', 'orientation' => 'potrait']) {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('generate/pdf/'. $filePath, compact('data'));
        $pdf->setPaper($paperSize['paper'], $paperSize['orientation']);
        return $pdf;
    }

    /**
     * Stream PDF (view PDF di browser tanpa download file)
     * 
     * @author Wahyu Agung <wahyuagung26@email.com>
     *
     * @param  string $filePath path ke file blade di folder resource/views/generate/pdf
     * @param  string $data data yang akan dirender pada view
     * @param  string $title judul / nama file ketika di download
     * @param  array  $paperSize ukuran kertas dan orientasinya
     * @return void
     */
    public static function PdfView($filePath, $data, $title = 'no-title.pdf', $paperSize = ['paper' => 'a4', 'orientation' => 'potrait']) {
        return self::loadPdf($filePath, $data, $title, $paperSize)->stream($title);
    }

    /**
     * Download PDF ke device Pengguna
     * 
     * @author Wahyu Agung <wahyuagung26@email.com>
     *
     * @param  string $filePath path ke file blade di folder resource/views/generate/pdf
     * @param  string $data data yang akan dirender pada view
     * @param  string $title judul / nama file ketika di download
     * @param  array  $paperSize ukuran kertas dan orientasinya
     * @return void
     */
    public static function PdfDownload($filePath, $data, $title = 'no-title.pdf', $paperSize = ['paper' => 'a4', 'orientation' => 'potrait']) {
        return self::loadPdf($filePath, $data, $title, $paperSize)->download($title);
    }

    /**
     * Print Halaman dari folder resources/views/generate
     * 
     * @author Wahyu Agung <wahyuagung26@email.com>
     *
     * @param  string $filePath path ke file blade di folder resource/views/generate/
     * @param  string $data data yang akan dirender pada view
     * @return void
     */
    public static function print($filePath, $data)
    {
        $view = (string) view('generate/'. $filePath, compact('data'));
        $view .= '<script>window.print();</script>';
        return $view;
    }
}