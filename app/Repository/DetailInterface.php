<?php 
namespace App\Repository;

Interface DetailInterface
{
    public function prepare(array $payload): array;

    public function getAll(): object;

    public function groupById(): array;

    public function isChanged(array $oldDetail, array $newDetail): bool;

    public function create(array $payload): bool;

    public function update(array $payload): bool;

    public function deleteUnUsed(array $usedDetailId): void;
}