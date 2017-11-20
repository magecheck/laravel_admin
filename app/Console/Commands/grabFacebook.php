<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class grabFacebook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grabFacebook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting the latest Facebook Events JS';

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
        $location = public_path('js/all.js');
        echo "Getting folder where the js is: ".$location.PHP_EOL;
        $analytics = file_get_contents('https://connect.facebook.net/en_US/all.js');
        file_put_contents($location, $analytics);
        echo "Done!".PHP_EOL;
    }
}
