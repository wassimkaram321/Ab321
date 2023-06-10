<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $file;
    protected $path;

    public function __construct($file,$path)
    {
        //
        $this->file = $file;
        $this->path = $path;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file_extension = $this->file->getClientOriginalExtension();
        $file_name = rand(1,100).time() . '.' . $file_extension;
        $this->file->move($this->path, $file_name);

    }
}
