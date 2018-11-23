<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Site;
use Log;
use App\Models\RSS;
use App\Models\Twitter;

class getPosts extends Command{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update posts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        \Log::info('handle!');

        foreach (Site::all() as $siteData) {
            $site = null;
            switch ($siteData->type){
                case 'RSS':
                    $site = new RSS();
                    break;

                case 'Twitter':
                    $site = new Twitter();
                    break;
            }

            $site = $site->withType($siteData->type)
                         ->withUrl($siteData->url)
                         ->withUser_id($siteData->user_id)
                         ->withMedia_id($siteData->media_id)
                         ->withId($siteData->id);

            $site->updatePosts();
        }
    }
}
