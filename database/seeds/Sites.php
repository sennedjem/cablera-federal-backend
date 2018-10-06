<?php

use Illuminate\Database\Seeder;
use App\Models\Site;

class Sites extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
    	$rss = \Config::get('sites.types')['RSS'];
        Site::Create(['type'=>$rss,'url'=>'http://www.cpbnoticias.com/feed/']);
        Site::Create(['type'=>$rss,'url'=>'http://elnumeral.com/feed/']);
        Site::Create(['type'=>$rss,'url'=>'http://launiondelanus.com.ar/feed/']);
    }
}


