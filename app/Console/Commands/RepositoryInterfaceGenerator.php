<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RepositoryInterfaceGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repo-interface
                            {name : Class name WITHOUT interface suffix}
                            {repoName? : Repository name to link with. This is optional. Should fill WITHOUT repository suffix}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create new Repository Interface';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $repoName = $this->argument('repoName');

        if ($repoName) {
            $name = $repoName;
        }

        $name .= 'Interface';
        $fileName = $name . '.php';

        $path = app_path('Repositories/Interface');

        // check folder, create if not exist
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        // check files, exit if exist
        if (file_exists($path . '/' . $name)) {
            echo 'File already exists';
            exit();
        }

        // get stub
        $stub = file_get_contents(__DIR__ . '/../../../stubs/repository.interface.stub');

        $skeleton = str_replace(
            ["{{className}}"],
            [$name],
            $stub
        );

        // set file
        file_put_contents($path . '/' . $fileName, $skeleton);

        echo "Repository Interface successfully created \n";
    }
}
