<?php

namespace App\Models;

use App\Core\Model;

class LogModel extends Model
{
    private $collection;

    public function __construct()
    {
        parent::__construct(true); // Usa MongoDB
        $this->collection = $this->getMongoCollection("Logs");
    }

    public function saveLog($level, $message, $context = [])
    {
        $logEntry = [
            'level' => $level,
            'message' => $message,
            'context' => $context,
            'timestamp' => new \MongoDB\BSON\UTCDateTime()
        ];
        $this->collection->insertOne($logEntry);
    }

    public function getAllLogs()
    {
        return $this->collection->find()->toArray();
    }
}
