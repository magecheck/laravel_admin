<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class grabAnalytics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grabAnalytics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting the latest Google Analytics JS';

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
     * @return mixed
     */
    public function handle()
    {
        $location = public_path('js/analytics.js');
        echo "Getting folder where the js is: ".$location.PHP_EOL;
        $analytics = file_get_contents('http://www.google-analytics.com/analytics.js');
        file_put_contents($location, $analytics);
        echo "Done!".PHP_EOL;
    }
}
