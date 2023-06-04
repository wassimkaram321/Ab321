<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class GenerateModelFiles extends Command
{
    protected $signature = 'make:pmodel {model}';

    protected $description = 'Generate model';

    public function handle()
    {
        $model = $this->argument('model');
        $this->call('make:request', ['name' => $model.'Request']);
        $this->call('make:resource', ['name' => 'Web/'.$model.'Resource']);
        $this->call('make:controller', ['name' => 'Api/'.$model.'Controller']);
        $this->call('make:service', ['model' => $model]);
        $this->info('Model files generated successfully.');
    }
}
