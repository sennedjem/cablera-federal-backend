<?php

use Illuminate\Database\Seeder;
use App\Models\Media;

class MediaSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        Media::Create(['name'=>'cpbnoticias','district'=>'quilmes','id'=>'1']);
        Media::Create(['name'=>'launiondelanus','district'=>'lanus','id'=>'2']);
        Media::Create(['name'=>'elnumeral','district'=>'avellaneda','id'=>'3']);
    }
}


