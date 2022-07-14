<?php 
namespace App\Repository;

Interface ModelDetInterface
{
    public function getAll(int $id): object;

    public function getById(int $id): object;

    public function store(array $payload);

    public function edit(array $payload, int $id);

    public function drop(int $id);

    public function deleteUnUsed(array $unUsedId, int $parentId);
}