<?php
namespace App\Http\Controllers\Web;

use App\Mail\TestsMail;
use App\Helpers\Venturo;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use App\Exports\User\UsersExport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\User\UserRolesExport;
use Illuminate\Support\Facades\Cache;

class TestsController extends Controller
{
    private $dataForPdf = [
        'foto' => 'https://landa.co.id/assets/img/logonotag.png',
        'invoice' => [
            'kode' => 'INV0001',
            'tanggal' => '07 Februari 2021',
            'total' => '50.000'
        ],
        'customer' => [
            'nama' => 'Wahyu Agung',
            'email' => 'wahyuagung26@gmail.com'
        ],
        'detail' => [
            [
                'produk' => 'Surya 12',
                'harga' => '20.000'
            ],
            [
                'produk' => 'Nasi Goreng',
                'harga' => '25.000'
            ],
            [
                'produk' => 'Es Jeruk',
                'harga' => '5.000'
            ],
        ],
    ];

    private $arrUserForImport = [
        [
            'nama' => 'Wahyu Satu',
            'email' => 'wahyusatu@gmail.com',
            'password' => '12345',
            'm_roles_id' => 1
        ],
        [
            'nama' => 'Wahyu Dua',
            'email' => 'wahyudua@gmail.com',
            'password' => '12345',
            'm_roles_id' => 1
        ],
        [
            'nama' => 'Wahyu Tiga',
            'email' => 'wahyutiga@gmail.com',
            'password' => '12345',
            'm_roles_id' => 1
        ],
        [
            'nama' => 'Wahyu Empat',
            'email' => 'wahyuempat@gmail.com',
            'password' => '12345',
            'm_roles_id' => 1
        ]
    ];

    /**
     * Test Generate PDF
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function generatePdf()
    {
        return Venturo::PdfView('invoice', $this->dataForPdf, "invoice{$this->dataForPdf['invoice']['kode']}.pdf", ['paper' => 'a4', 'orientation' => 'landscape']);
    }

    /**
     * Test Download PDF
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function downloadPdf()
    {
        return Venturo::PdfDownload('invoice', $this->dataForPdf, "invoice{$this->dataForPdf['invoice']['kode']}.pdf");
    }

    /**
     * Test Import Excel
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function importExcel()
    {
        /**
         * Generate file excel untuk diimport
         * Jika alur normal ini sama dengan proses upload file excel yang akan diimport
         *
         */
        Excel::store(new UserRolesExport($this->arrUserForImport), 'usersRoles.xlsx');

        // Proses Import
        try {
            Excel::import(new UserImport, 'usersRoles.xlsx');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.

                echo 'Baris '.$failure->row().' : '.$failure->errors()[0];
            }
        }
    }

    /**
     * Test Export Excel
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function exportExcel()
    {
        return Excel::download(new UsersExport(), 'users.xlsx');
    }

    /**
     * Test Export Excel Dengan Template
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function exportExcelMultipleSheet()
    {
        return Excel::download(new UserRolesExport(), 'usersRoles.xlsx');
    }

    /**
     * Test Print HTML
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function print()
    {
        return Venturo::print('pdf/invoice', $this->dataForPdf);
    }

    /**
     * Test Kirim Email dengan Default Laravel
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function sendMail()
    {
        try {
            /**
             * Mengirim email dengan proses background
             * Server akan memberikan respon terhadap request dari user meskipun proses kirim email masih belum selesai
             */
            Mail::to('agung@landa.co.id')->queue(new TestsMail($this->dataForPdf));

            /**
             * untuk engirim email dengan metode normal, gunakan code :
             *
             * Mail::to('agung@landa.co.id')->send(new TestsMail($this->dataForPdf));
             *
             * Server akan menunggu proses kirim email sampai selesai baru memberikan respon terhadap request user
             */

            return 'Email berhasil dikirim';
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return 'Email gagal dikirim';
        }
    }

    /**
     * Test menyimpan data ke dalam cache file local (disimpan di folder storage/framework/cache/)
     * Untuk implementasi sederhana sistem Caching pada database silahkan cek method "App\Http\Helpers\RoleHelper::getRole"
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function generateCache(Request $request)
    {
        /**
         * Jika ingin menggunakan redis ganti "Cache::put()" dengan "Cache::store('redis')->put()"
         *
         * Parameter untuk method put() adalah :
         * - parameter pertama = key
         * - parameter kedua = value
         * - parameter ketiga = lama penyimpanan cache dalam satuan detik
         */
        date_default_timezone_set("Asia/Jakarta");
        
        echo '<form method="GET">';
        echo '<input type="text" name="nama" placeholder="Masukkan nama kamu"> <br><br>';
        echo '<input type="submit" value="Simpan ke Cache">';
        echo '</form>';

        $data = $request->only(['nama']);

        if (!empty($data['nama'])) {
            if (!Cache::get('dataPribadi')) {
                /**
                 * Jika belum ada cache dengan key "dataPribadi", maka generate baru
                 */
                Cache::put('dataPribadi', json_encode([
                    [
                        'nama' => $data['nama'],
                        'generate' => date('d-m-Y H:i:s')
                    ]
                ]), 600);
            } else {
                /**
                 * Jika sudah ada cache dengan key "dataPribadi", maka tambahkan nama yang baru disubmit ke dalam cache tersebut
                 */
                $cache = json_decode(Cache::get('dataPribadi'), true);
                $cache[] = [
                    'nama' => $data['nama'],
                    'generate' => date('d-m-Y H:i:s')
                ];
                Cache::put('dataPribadi', json_encode($cache), 600);
            }

            return redirect('tests/getCache');
        }
    }

    /**
    * Test mengambil data dari cache local (cache yang disimpan di folder storage/framework/cache/)
    * Untuk implementasi sederhana sistem Caching pada database silahkan cek method "App\Http\Helpers\RoleHelper::getRole"
    *
    * @author Wahyu Agung <wahyuagung26@email.com>
    */
    public function getCache(Request $request)
    {
        $data = $request->only(['hapus']);
        if (!empty($data['hapus']) && Cache::has('dataPribadi')) {
            // Hapus Cache
            Cache::forget('dataPribadi');
        }

        // Jika tidak ada cache tampilkan link ke form Generate Cache
        if (!Cache::get('dataPribadi')) {
            echo 'Data cache belum dibuat, silahkan klik <a href="'.route('generateCache').'">di sini</a> untuk membuat cache baru';
            return;
        }

        // Tampilkan data dari cache
        $cache = json_decode(Cache::get('dataPribadi'), true);
        echo 'Data di bawah ini adalah data yang disimpan pada sistem cache : <br><br>';
        echo '<a href="'.route('generateCache').'">Tambah Cache Baru </a> | <a href="'.route('getCache', ['hapus' => 'ya']).'">Bersihkan Cache</a><br>';
        echo '<table width="500" border="1"><tr><td width="250">Nama</td><td width="250">Waktu Generate</td></tr>';
        foreach ($cache as $val) {
            echo '<tr>';
            echo '<td>'.$val['nama'].'</td>';
            echo '<td>'.$val['generate'].'</td>';
            echo '</tr>';
        }
        echo '</table><br>';
    }
}
