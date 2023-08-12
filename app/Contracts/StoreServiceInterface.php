<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface StoreServiceInterface {
    public function index(Request $request);
    public function show(int $store_id,Request $request);
    public function store(Request $request);
    public function update(int $store_id,Request $request);
    public function delete(int $store_id,Request $request);
}