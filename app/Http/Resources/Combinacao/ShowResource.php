<?php

namespace App\Http\Resources\Combinacao;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {        
        return [
            'id' => $this->id,
            'codigo' => $this->codigo,
            'codigo_moeda_base' => $this->codigo_moeda_base,
            'descricao' => $this->descricao,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
