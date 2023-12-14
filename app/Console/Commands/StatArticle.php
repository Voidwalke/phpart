<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\statMail;
use App\Models\Path;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class StatArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statArticle';

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
        $articleCount = Path::all()->count();
        $commentCount = Comment::whereDate('created_at', Carbon::today())->count();
        Log::alert(Carbon::now());

        Path::whereNotNull('id')->delete();        
        Mail::to('alehandrogolubchikov@yandex.ru')->send(new statMail($articleCount, $commentCount));
        return 0;
    }
}
