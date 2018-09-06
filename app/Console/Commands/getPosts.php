<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Post;
use App\Models\Site;
Use Log;

class getPosts extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
    public function __construct(){
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        foreach (Site::where('type','Twitter')->cursor() as $site) {
            $this->updateTwitterSitePosts(($site->url));
        }
    }

    public function updateTwitterSitePosts($account){
        $client = new Client();
        $response = $client -> get('http://twitrss.me/twitter_user_to_rss/?user='.$account);
        $xml = $response->xml();
        $items = $xml->channel->item;
        Log::info(count($items));
        for ($i=0; $i<count($items); $i++) {
            if(!Post::postsExist($items[$i]->link)){               
                $this->addTwitterPost($items[$i],$account);
            }
        }
    }

    public function addTwitterPost($item,$account){
        $post = new Post([
                'site' => $account,
                'creation_date' => $item->pubDate,
                'content' => $item->title,
                'url' => $item->link
            ]);
        $post -> save();
    }
}
