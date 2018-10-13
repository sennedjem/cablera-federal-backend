<?php

namespace App\Models\ES;

use Basemkhirat\Elasticsearch\Query;

class ESQuery extends Query {

    /**
     * Update a document
     * @param      $data
     * @param null $_id
     * @return object
     */
    public function update($data, $_id = NULL, $retry = 3) {
        \Log::info("-- ESModel update");

        if ($_id) {
            $this->_id = $_id;
        }

        $parameters = [
            "id" => $this->_id,
            "body" => ['doc' => $data],
            'client' => ['ignore' => $this->ignores]
        ];

        if ($index = $this->getIndex()) {
            $parameters["index"] = $index;
        }

        if ($type = $this->getType()) {
            $parameters["type"] = $type;
        }

        if ($retry) {
            $parameters["retry_on_conflict"] = $retry;
        }

        return (object)$this->connection->update($parameters);
    }

}