<?php

namespace App\Models\ES;

use Basemkhirat\Elasticsearch\Model;
use App\Traits\StringToLower;

class ESModel extends Model {

    use StringToLower;

    /**
     * Create a new model query
     * @return mixed
     */
    protected function newQuery() {
        \Log::info("-- ESModel newQuery");
        $query = $this->connection;

        if ($index = $this->getIndex()) {
            $query->index($index);
        }

        if ($type = $this->getType()) {
            $query->type($type);
        }

        return $query;
    }

    public function createConnection($connec){
        $this->connection = ESConnection::create([
            'servers' => [$connec]
        ]);
    }

    public function baseQuery($params, $withModel=false){
        if(is_string($this->connection)){
            $this->createConnection([
                "host"   => "127.0.0.1",
                "port"   => 9200,
                'user'   => '',
                'pass'   => '',
                'scheme' => 'http',
            ]);

            $query = $this->connection->index($params->es_index)->type($this->getType())->where('id',$params->id);
            $query = $withModel ? $query->setModel($this) : $query;
        } else {
            $query = $this->connection;
        }

        return $query;
    }

    public function create($params){
        $this->createConnection([
            "host"   => $params->es_host,
            "port"   => $params->es_port,
            'user'   => $params->es_user,
            'pass'   => $params->es_pass,
            'scheme' => $params->es_schema,
        ]);

        $this->setIndex($params->es_index);
    }

}
