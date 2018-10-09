<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Post;
use App\Models\Site;
Use Log;

class getPosts extends Command{

    /**
     *  Prop: Hash que relaciona nombre de sitios RSS con su direccion url para obtener el feed.
     */
    protected $rssHash = array(
        '#ElNumeral' => "http://elnumeral.com/feed/"
    );

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
        foreach (Site::where('type','Twitter')->cursor() as $site) {
            $this->updateTwitterSitePosts($site->url);
        }

        foreach (Site::where('type','RSS')->cursor() as $site) {
            $this->updateRSSsitePosts($site->url);
        }
    }

    public function updateTwitterSitePosts($account){
        $response = $this->getTwitterPosts($account);
        $xml = $response->xml();
        $image = $xml->channel->image->url;
        $items = $xml->channel->item;
        for ($i=count($items); $i>0; $i--) {
            if(!Post::postsExist($items[$i-1]->link)){
                $this->addTwitterPost($items[$i-1],$account,$image);
            }
        }
    }

    public function updateRSSsitePosts($account){
        $response = $this->getRSSPosts($account);
        $xml = $response->xml();
        $items = $xml->channel->item;
        $site = $xml->channel->title;

        for ($i=count($items); $i>0; $i--) {
            if(!Post::postsExist($items[$i-1]->link)){
                $this->addRSSPost($items[$i-1],$site);
            }
        }
    }

    public function getTwitterPosts($account){
        try {
            $client = new Client();
            return $client->get('http://twitrss.me/twitter_user_to_rss/?user=' . $account);

        }catch (\Exception $re){
            \Log::info('No existe una pagina asociada a Twitter con el nombre de '.$account);
        }
    }

    public function getRSSPosts($account){
        $client = new Client();
        return $client -> get($account);
    }

    public function addTwitterPost($item,$account,$image){

        $post = new Post([
                'site' => $account,
                'creation_date' => $item->pubDate,
                'content' => $this->_getTwitterContent($item),
                'url' => $item->link,
                'image' => $image
        ]);
        $post -> save();
    }

    public function addRSSPost($item,$site){

        $post = new Post([
                'site' => $site,
                'creation_date' => $item->pubDate,
                'title' => $item->title,
                'content' => $this->_getRssContent($item),
                'url' => $item->link,
                'image' => $this->_getRssImage($item)
        ]);
        $post -> save();
    }

    public function _getTwitterContent($item){
        $title = substr(
            $item->title,
            0,
            strpos($item->title,'http')-2
        );

        return $title;
    }

    public function _getRssImage($item){
        $content = $item->description->__toString();
        $imageInitPos = strpos($content,'src="');

        $image = substr(
            $content,
            $imageInitPos+5,
            strpos($content,'g"')-$imageInitPos-4
        );

        return $image;
    }

    public function _getRssContent($item){
        $text = $item->description->__toString();
        $contentInitPos = strpos($text,'<p>');

        $content = substr(
            $text,
            $contentInitPos+3,
            strpos($text,'&#')-$contentInitPos-5
        );

        return $content;
    }
}
