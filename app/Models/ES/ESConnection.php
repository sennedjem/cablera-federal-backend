<?php

namespace App\Models\ES;

use Basemkhirat\Elasticsearch\Connection;
use Elasticsearch\ClientBuilder;

class ESConnection extends Connection {

    /**
     * Create a native connection
     * suitable for any non-laravel or non-lumen apps
     * any composer based frameworks
     * @param $config
     * @return Query
     */
    public static function create($config) {

        $clientBuilder = ClientBuilder::create();

        if (!empty($config['handler'])) {
            $clientBuilder->setHandler($config['handler']);
        };

        $clientBuilder->setHosts($config["servers"]);

        $query = new ESQuery($clientBuilder->build());

        if (array_key_exists("index", $config) and $config["index"] != "") {
            $query->index($config["index"]);
        }

        return $query;
    }

}
