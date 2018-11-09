<?php

use Illuminate\Database\Seeder;
use App\Models\Site;

class SitesSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
    	$rss = \Config::get('sites.types')['RSS'];
        Site::Create(['type'=>$rss,'url'=>'http://www.cpbnoticias.com/feed/','media_id'=>'1','id'=>'1','user_id'=>'1']);
        Site::Create(['type'=>$rss,'url'=>'http://launiondelanus.com.ar/feed/','media_id'=>'2','id'=>'2','user_id'=>'1']);
        Site::Create(['type'=>$rss,'url'=>'http://elnumeral.com/feed/','media_id'=>'3','id'=>'3','user_id'=>'1']);
    }
}


