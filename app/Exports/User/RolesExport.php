<?php

namespace App\Exports\User;

use App\Helpers\User\RoleHelper;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle; // Class untuk memberi judul pada sheet
use Maatwebsite\Excel\Concerns\WithHeadings; // Class untuk membuat header pada konten Excel

class RolesExport implements FromArray, WithHeadings, WithTitle
{
    protected $roles;

    public function __construct() {
        $this->role = $this->getRoles();
    }

    /**
     * Ambil daftar hak akses
     * 
     * Data yang akan dieksport bisa dimasukkan ke dalam parameter "_construct" agar lebih fleksibel
     *
     * @return void
     */
    private function getRoles() {
        $arrRoles = [];
        $role = RoleHelper::getAll([], 0);

        foreach($role as $key => $val) {
            $arrRoles[$key]['id'] = $val->id;
            $arrRoles[$key]['nama'] = $val->nama;
        }

        return $arrRoles;
    }

    /**
     * Membuat header pada konten excel
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama',
        ];
    }

    /**
     * Taruh array Hak akses pada konten excel
     *
     * @return array
     */
    public function array(): array
    {
        return $this->role;
    }

    /**
     * Beri nama pada sheet
     *
     * @return string
     */
    public function title(): string
    {
        return 'Daftar Hak Akses';
    }
}
