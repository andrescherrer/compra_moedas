<?php

namespace App\Http\Controllers;

use App\Http\Requests\Combinacao\IndexRequest;
use App\Http\Resources\Combinacao\IndexCollection;
use App\Models\Combinacao;
use App\Services\CombinacaoService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CombinacaoController extends Controller
{
    private $arrayErrorMessage = [
        'index' => 'Erro ao listar combinações',
        'store' => 'Erro ao criar combinação',
        'show' => 'Erro ao exibir combinação',
        'update' => 'Erro ao atualizar combinação',
        'destroy' => 'Erro ao deletar combinação',
    ];

    public function __construct(
        private CombinacaoService $service,
        private Combinacao $model,
    ) {}

    public function index(IndexRequest $request): IndexCollection | JsonResponse
    {
        $message = $this->arrayErrorMessage['index'];
        $status = JsonResponse::HTTP_BAD_REQUEST;
        
        try {
            
            return new IndexCollection($this->service->filter($request));

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $message,
                'error' => $th->getMessage(),
            ], $status);
        }
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Combinacao $combinacao)
    {
        //
    }

    public function update(Request $request, Combinacao $combinacao)
    {
        //
    }

    public function destroy(Combinacao $combinacao)
    {
        //
    }
}
