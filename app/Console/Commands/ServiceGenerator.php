<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ServiceGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service
                            {--only-service : Model, Repository and Interfance will not generate}
                            {name : Service class WITHOUT service suffix}
                            {repo? : Repo class WITHOUT repository suffix}
                            {model? : Model class WITHOUT model suffix}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to make service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $repo = $this->argument('repo');
        $model = $this->argument('model');
        $onlyService = $this->option('only-service');

        if (!$repo) {
            $repo = $name;
        }
        $repoClass = $repo . 'Repository';
        $repoName = $repoClass . '.php';

        if (!$model) {
            $model = $name;
        }
        $modelName = $model . '.php';

        $serviceClass = $name . 'Service';
        $serviceName = $serviceClass . '.php';

        $path = app_path('Services');

        // check service file
        if (file_exists($path . '/' . $serviceName)) {
            echo 'Service already exists';
            exit();
        }

        // check model class
        if (!$onlyService) {
            if (!file_exists(app_path('Models/' . $modelName))) {
                $ask = $this->confirm("Model {$model} not found. Do you want to create model instead?", 'Y');
                if ($ask == 1) {
                    $modelAsk = $this->ask('What is your model name? Ex: User', $model);
                    if (!$modelAsk) {
                        echo "Operation stop \n";
                        exit();
                    }

                    $modelName = $modelAsk . '.php';
                    $model = $modelAsk;

                    $askMigration = $this->ask('Do you want to create migration file to?', "Y");
                    if ($askMigration) {
                        $artisanModel = "make:model {$model} -m";
                    } else {
                        $artisanModel = "make:model {$model}";
                    }

                    Artisan::call($artisanModel);
                }
            }

            // check repo file, create if not exists
            if (!file_exists(app_path('Repositories/' . $repoName))) {
                Artisan::call("make:repository {$repo} {$model}");
            }
        }

        // check folder
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $stub = file_get_contents(__DIR__ . '/../../../stubs/service-new.stub');

        $skeleton = str_replace(
            ["{{className}}", "{{repoClass}}"],
            [$serviceClass, $repoClass],
            $stub
        );

        file_put_contents($path . '/' . $serviceName, $skeleton);

        echo "Service successfully created \n";
    }
}
