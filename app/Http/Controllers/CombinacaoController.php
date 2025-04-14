<?php

namespace App\Http\Controllers;

use App\Http\Requests\Combinacao\{IndexRequest, StoreRequest};
use App\Http\Resources\Combinacao\IndexCollection;
use App\Models\Combinacao;
use App\Services\CombinacaoService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CombinacaoController extends Controller
{
    private $arrayErrorMessage = [
        'index' => 'Erro ao listar combinações ',
        'store' => 'Erro ao criar combinação ',
        'show' => 'Erro ao exibir combinação ',
        'update' => 'Erro ao atualizar combinação ',
        'destroy' => 'Erro ao deletar combinação ',
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
            Log::critical($message .  $th->getMessage());
            return response()->json(['message' => $message, 'error' => $th->getMessage()], $status);
        }
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $message = $this->arrayErrorMessage['store'];
        $status = JsonResponse::HTTP_BAD_REQUEST;
        
        try {
            $combinacao = $this->service->create($request);

            if (!$combinacao) {
                return response()->json(['message' => $message,], $status);
            } else {
                return response()->json(['message' => 'Combinacao criada com sucesso'], JsonResponse::HTTP_CREATED);
            }
            
        } catch (\Throwable $th) {
            Log::critical($message .  $th->getMessage());
            return response()->json(['message' => $message, 'error' => $th->getMessage()], $status);
        }
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
