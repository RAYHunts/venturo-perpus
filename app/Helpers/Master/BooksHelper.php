<?php

namespace App\Helpers\Master;

use App\Models\Master\BooksModel;
use App\Repository\CrudInterface;

class BooksHelper implements CrudInterface
{
    private $booksModel;

    public function __construct()
    {
        $this->booksModel = new BooksModel();
    }

    public function getAll(array $filter, int $itemPerPage, string $sort): object
    {
        return $this->booksModel->getAll($filter, $itemPerPage, $sort);
    }

    public function getById(int $id): object
    {
        return $this->booksModel->getById($id);
    }

    public function create(array $payload): array
    {
        try {
            $book = $this->booksModel->create($payload);
            return [
                'status' => true,
                'data' => $book,
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
            $this->booksModel->edit($payload, $id);
            return [
                'status' => true,
                'data' => $this->getById($id)
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
            $this->booksModel->drop($id);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}