<?php 
namespace App\Repository;

Interface CrudInterface
{
    public function getAll(array $filter, int $itemPerPage, string $sort): object;

    public function getById(int $id): object;

    public function create(array $payload): array;

    public function update(array $payload, int $id): array;

    public function delete(int $id): Bool;
}