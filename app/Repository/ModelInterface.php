<?php 
namespace App\Repository;

Interface ModelInterface
{
    public function getAll(array $filter, int $itemPerPage, string $sort): object;

    public function getById(int $id): object;

    public function store(array $payload);

    public function edit(array $payload, int $id);

    public function drop(int $id);
}