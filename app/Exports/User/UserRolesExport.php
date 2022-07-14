<?php

namespace App\Exports\User;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UserRolesExport implements WithMultipleSheets
{
    use Exportable;

    protected $newUser;

    public function __construct($user = [])
    {
        $this->newUser = $user;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [
            new UsersExport($this->newUser),
            new RolesExport()
        ];

        return $sheets;
    }
}
