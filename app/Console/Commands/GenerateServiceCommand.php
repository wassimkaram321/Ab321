<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {model}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a service class for a given model';

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
    $model = $this->argument('model');
    $className = $model . 'Service';
    $modelClass = 'App\Models\\' . $model;
    $stub = File::get(base_path('stubs/service.stub'));
    $content = Str::replace(
        ['{{Model}}', '{{model}}', '{{modelPlural}}', '{{modelVariable}}'],
        [$model, lcfirst($model), Str::plural(lcfirst($model)), Str::snake($model)],
        $stub
    );
    $filePath = app_path('Services/' . $className . '.php');
    File::put($filePath, $content);
    $this->info("{$className} created successfully.");
}
}
