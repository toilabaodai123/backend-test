<?php

namespace App\Contracts;
use Illuminate\Http\Request;

interface BaseServiceInterface {
    public function index(Request $request);
    public function show(int $id,Request $request);
    public function store(Request $request);
    public function update(int $id,Request $request);
    public function delete(int $id,Request $request);
}