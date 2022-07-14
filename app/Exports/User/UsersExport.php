<?php

namespace App\Exports\User;

use App\Helpers\User\UserHelper;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle; // Class untuk memberi judul pada sheet
use Maatwebsite\Excel\Concerns\WithHeadings; // Class untuk membuat header pada konten Excel

class UsersExport implements FromArray, WithHeadings, WithTitle
{
    protected $user;

    public function __construct($newUser = [])
    {
        $this->user = $newUser ?: $this->getAll();
    }

     /**
     * Ambil daftar User
     * 
     * Data yang akan dieksport bisa dimasukkan ke dalam parameter "_construct" agar lebih fleksibel
     *
     * @return void
     */
    private function getAll() {
        $arrUser = [];
        $user = UserHelper::getAll([], 1);
        foreach($user as $key => $val) {
            $arrUser[$key]['nama'] = $val->nama;
            $arrUser[$key]['email'] = $val->email;
            $arrUser[$key]['password'] = '';
            $arrUser[$key]['m_roles_id'] = $val->m_roles_id;
        }

        return $arrUser;
    }

    /**
     * Membuat header pada konten excel
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'Password',
            'ID AKSES'
        ];
    }

    /**
     * Taruh array user pada konten excel
     *
     * @return array
     */
    public function array(): array
    {
        return $this->user;
    }

    /**
     * Beri nama pada sheet
     *
     * @return string
     */
    public function title(): string
    {
        return 'Daftar User';
    }
}
