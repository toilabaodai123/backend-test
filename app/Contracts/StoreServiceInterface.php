<?php

namespace App\Contracts;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface StoreServiceInterface {
    public function index(Request $request);
    public function show(int $id,Request $request);
    public function store(Request $request);
    public function update(int $id,Request $request);
    public function delete(int $id,Request $request);
}