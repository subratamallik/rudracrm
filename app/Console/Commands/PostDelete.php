<?php

namespace App\Console\Commands;

use App\Http\Controllers\PostController;
use Illuminate\Console\Command;

class PostDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:delete {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $post = new PostController();
        $fileName = $this->argument('file');
        if ($fileName && $fileName != "") {
            $post->deletePost($fileName);
        }
    }
}
