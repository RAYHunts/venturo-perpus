<?php

namespace App\Helpers\Master;

use App\Models\Master\BorrowModel;
use App\Repository\CrudInterface;

class BorrowHelper implements CrudInterface
{
    private $borrowModel;

    public function __construct()
    {
        $this->borrowModel = new BorrowModel();
    }

    public function getAll(array $filter, int $itemPerPage, string $sort): object
    {
        return $this->borrowModel->getAll($filter, $itemPerPage, $sort);
    }

    public function getById(int $id): object
    {
        return $this->borrowModel->getById($id);
    }

    public function create(array $payload): array
    {
        try {
            $borrow = $this->borrowModel->store($payload);
            return [
                'status' => true,
                'data' => $borrow,
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage(),
            ];
        }
    }

    public function update(array $payload, int $id): array
    {
        try {
            $this->borrowModel->edit($payload, $id);

            return [
                'status' => true,
                'data' => $this->getById($id),
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage(),
            ];
        }
    }

    public function delete(int $id): bool
    {
        try {
            $this->borrowModel->drop($id);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}