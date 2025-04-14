<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeServiceImplementation extends Command
{    
    protected $signature = 'make:service {name : O nome do serviço (ex: UserService)} {model : O nome do modelo (ex: User)}';

    protected $description = 'Cria uma implementação concreta da classe abstrata Service';

    public function handle()
    {
        $serviceName = $this->argument('name');
        $modelName = $this->argument('model');

        $servicesPath = app_path('Services');
        if (!File::exists($servicesPath)) {
            File::makeDirectory($servicesPath, 0755, true);
        }

        $content = $this->generateServiceClass($serviceName, $modelName);

        $filePath = $servicesPath . '/' . $serviceName . '.php';

        if (File::exists($filePath)) {
            if (!$this->confirm("O arquivo {$serviceName}.php já existe. Deseja sobrescrevê-lo?")) {
                $this->info('Operação cancelada.');
                return 1;
            }
        }

        File::put($filePath, $content);

        $this->info("Serviço {$serviceName} criado com sucesso!");
        return 0;
    }

    protected function generateServiceClass(string $serviceName, string $modelName): string
    {
        $modelNamespace = "App\\Models\\{$modelName}";
        $modelVariable = Str::camel($modelName);

        return <<<PHP
<?php

namespace App\Services;

use App\Models\\{$modelName};
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class {$serviceName} extends Service
{
    public function __construct()
    {
        parent::__construct(new {$modelName}());
    }

    public function filter(Request \$request): LengthAwarePaginator
    {
        return \$this->model->when(
            \$request->anyFilled([
                'field1',
                'field2',
                'field3',
                'field4',
            ]), function (\$query) use (\$request) {
                \$this->functionModelName(\$request, \$query);
            })
            ->orderBy('field1')
            ->paginate(\$request->per_page ?? 20);
    }

    public function create(Request \$request): bool
    {
        try {
            \$this->model->create(\$request->all());
            return true;
        } catch(\Throwable \$th) {
            Log::critical("Erro ao salvar {$modelName}: ". \$th->getMessage());
            return false;
        }
    }

    public function findOrFail(\$id): Model | bool
    {
        try {
            return \$this->model->findOrFail(\$id);
        } catch(ModelNotFoundException \$e) {
            throw new ModelNotFoundException("{$modelName} com ID {\$id} não encontrada");
            Log::critical("Erro ao buscar {$modelName}: ". \$e->getMessage());
            return false;
        }
    }

    public function update(Request \$request): bool
    {
        try {
            \$model = \$this->model->findOrFail(\$request->id);
            \$model->update(\$request->all());
            return true;
        } catch(\Throwable \$th) {
            Log::critical("Erro ao atualizar {$modelName}: ". \$th->getMessage());
            return false;
        }
    }

    private function functionModelName(\$request, \$query)
    {
        if (\$request->filled('field1')) {
            \$query->where('field1', 'LIKE', "%{\$request->input('field1')}%");
        }
        if (\$request->filled('field2')) {
            \$query->where('field2', 'LIKE', "%{\$request->input('field2')}%");
        }
        if (\$request->filled('field3')) {
            \$query->where('field3', 'LIKE', "%{\$request->input('field3')}%");
        }
        if (\$request->filled('field4')) {
            \$query->where('field4', 'LIKE', "%{\$request->input('field4')}%");
        }
    }
}
PHP;
    }
}
