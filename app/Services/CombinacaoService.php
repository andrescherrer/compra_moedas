<?php

namespace App\Services;

use App\Models\Combinacao;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class CombinacaoService extends Service
{
    public function __construct()
    {
        parent::__construct(new Combinacao());
    }

    public function filter(Request $request): LengthAwarePaginator
    {
        return $this->model->when(
            $request->anyFilled([
                'codigo',
                'codigo_moeda_base',
                'descricao',
            ]), function ($query) use ($request) {
                $this->functionModelName($request, $query);
            })
            ->orderBy('codigo_moeda_base')
            ->paginate($request->per_page ?? 20);
    }

    public function create(Request $request): bool
    {
        try {
            $this->model->create($request->all());
            return true;
        } catch(\Throwable $th) {
            Log::critical("Erro ao salvar Combinacao: ". $th->getMessage());
            return false;
        }
    }

    public function update(Request $request): bool
    {
        try {
            $model = $this->model->findOrFail($request->id);
            $model->update($request->all());
            return true;
        } catch(\Throwable $th) {
            Log::critical("Erro ao atualizar Combinacao: ". $th->getMessage());
            return false;
        }
    }

    public function delete(Request $request): bool
    {
        try {
            $model = $this->model->findOrFail($request->id);
            $model->delete();
            return true;
        } catch(\Throwable $th) {
            Log::critical("Erro ao remover Combinacao: ". $th->getMessage());
            return false;
        }
    }

    private function functionModelName($request, $query)
    {
        if ($request->filled('codigo')) {
            $query->where('codigo', 'LIKE', "%{$request->input('codigo')}%");
        }
        if ($request->filled('codigo_moeda_base')) {
            $query->where('codigo_moeda_base', 'LIKE', "%{$request->input('codigo_moeda_base')}%");
        }
        if ($request->filled('descricao')) {
            $query->where('descricao', 'LIKE', "%{$request->input('descricao')}%");
        }        
    }
}