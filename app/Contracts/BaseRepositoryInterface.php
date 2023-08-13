<?php

namespace App\Contracts;

interface BaseRepositoryInterface {
    public function getAll();
    public function find(int $id);
    public function create(array $data);
    public function update(int $store_id,array $data);
    public function delete(int $store_id);
}