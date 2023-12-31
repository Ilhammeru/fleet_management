<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RepositoryGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository
                            {name : Repository name WITHOUT repository suffix}
                            {model? : Related model class. Its optional. Normally its will follow repository name}
                            {interface? : Interface name WITHOUR interface suffix. Its optional. If blank, system will automatically create interface based on repository name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create new Repository';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $model = $this->argument('model');
        $interface = $this->argument('interface');

        if (!$model) {
            $modelName = $name . '.php';
            $model = $name;
        } else {
            $modelName = $model . '.php';
        }

        if (!$interface) {
            $interfaceClass = $name . 'Interface';
            $interfaceName = $name . 'Interface.php';
            $interface = $name;
        } else {
            $interfaceClass = $interface . 'Interface';
            $interfaceName = $interface . 'Interface.php';
        }

        $name .= 'Repository';
        $fileName = $name . '.php';

        $path = app_path('Repositories');

        // check model
        if (!file_exists(app_path('models/' . $modelName))) {
            $ask = $this->confirm("Model {$model} not found. Do you want to create model instead?", "Y");
            if ($ask == 1) {
                $modelAsk = $this->ask('What is your model name? Ex: User', $model);
                if (!$modelAsk) {
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
            } else {
                exit();
            }
        }

        // check interface, create if not exist
        if (!file_exists(app_path('Repositories/Interface/' . $interfaceName))) {
            Artisan::call("make:repo-interface {$interface}");
        }

        // check folder, create if not exist
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        // check files, exit if exist
        if (file_exists($path . '/' . $fileName)) {
            echo 'File already exists';
            exit();
        }

        // get stub
        $stub = file_get_contents(__DIR__ . '/../../../stubs/repository.stub');

        $skeleton = $this->buildSkeleton($name, $interfaceClass, $model, $stub);

        // set file
        $this->makeFile($path . '/' . $fileName, $skeleton);
    }

    private function buildSkeleton($className, $interfaceClass, $model, $stub)
    {
        return str_replace(
            ["{{className}}", "{{interfaceClass}}", "{{model}}"],
            [$className, $interfaceClass, $model],
            $stub
        );
    }

    private function makeFile($path, $skeleton)
    {
        file_put_contents($path, $skeleton);

        echo "Repository successfully created \n";
    }
}
