<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

abstract class Service
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    
    abstract public function filter(Request $request): LengthAwarePaginator;

    abstract public function create(Request $request): bool;

    abstract public function findOrFail($id): Model | bool;

    abstract public function update(Request $request): bool;
}