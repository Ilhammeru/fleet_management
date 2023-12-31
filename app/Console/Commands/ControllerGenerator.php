<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ControllerGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "make:crud
                            {--api : Define controller make for API or not}
                            {class : Controller class WITHOUT controller suffix}
                            {model? : Model class WITHOUT model suffix}
                            {service? : Service name WITHOUT service suffix}
                            {repo? : Repo name WITHOUT repository suffix}
                            {interface? : Repository interface WITHOUT interface suffix}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create custom controller for crud';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controller = $this->argument('class');
        $controllerClass = $controller . 'Controller';
        $controllerName = $controllerClass . '.php';
        $isApi = $this->option('api');

        $model = $this->argument('model');
        if (!$model) {
            $model = $controller;
        }
        $modelClass = $model;
        $modelName = $modelClass . '.php';

        $service = $this->argument('service');
        if (!$service) {
            $service = $controller;
        }
        $serviceClass = $service . 'Service';
        $serviceName = $serviceClass . '.php';

        $repo = $this->argument('repo');
        if (!$repo) {
            $repo = $controller;
        }
        $repoClass = $repo . 'Repository';
        $repoName = $repoClass . '.php';

        $interface = $this->argument('interface');
        if (!$interface) {
            $interface = $controller;
        }
        $interfaceClass = $interface . 'Interface';
        $interfaceName = $interfaceClass . '.php';

        // validate files
        $this->validateRelatedFile($model, $service, $repo, $interface);

        $namespace = 'Admin';
        if ($isApi) {
            $namespace = 'Api';
        }
        $path = app_path("Http/Controllers/{$namespace}");

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        // check file
        if (file_exists($path . '/' . $controllerName)) {
            echo 'Controller already exists';
            exit();
        }

        // make request
        Artisan::call("make:request {$controller}/Create");
        Artisan::call("make:request {$controller}/Update");

        $stub = file_get_contents(__DIR__ . '/../../../stubs/controller.crud.stub');

        $skeleton = str_replace(
            ["{{namespace}}", "{{serviceClass}}", "{{createRequest}}", "{{updateRequest}}", "{{className}}"],
            [$namespace, $serviceClass, $controller, $controller, $controllerClass],
            $stub
        );

        file_put_contents($path . '/' . $controllerName, $skeleton);

        echo "CRUD successfully created \n";
    }

    private function validateRelatedFile($modelClass, $serviceClass, $repoClass, $interfaceClass)
    {
        // model validate
        if (!file_exists(app_path('Models/' . $modelClass))) {
            $ask = $this->confirm("Model {$modelClass} not found. Do you want to create it?", "Y");
            if ($ask == 1) {
                $model = $this->ask('What is your model name? Ex: User', $modelClass);
                if (!$model) {
                    echo "Opreation Stop \n";
                    exit();
                }
                $modelClass = $model;

                $askMigration = $this->ask('Do you want to create migration file to?', "Y");
                if ($askMigration) {
                    $artisanModel = "make:model {$modelClass} -m";
                } else {
                    $artisanModel = "make:model {$modelClass}";
                }

                Artisan::call($artisanModel);
            } else {
                exit();
            }
        }

        // interface validate
        if (!file_exists(app_path("Repositories/Interface/{$interfaceClass}"))) {
            Artisan::call("make:repo-interface {$interfaceClass}");
        }

        // repo validate
        if (!file_exists(app_path("Repositories/{$repoClass}"))) {
            Artisan::call("make:repository {$repoClass} {$modelClass}");
        }

        // service validate
        if (!file_exists(app_path("Services/{$serviceClass}"))) {
            Artisan::call("make:service {$serviceClass}");
        }
    }
}
