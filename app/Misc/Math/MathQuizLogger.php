<?php

namespace App\Misc\Math;

use DB;

class MathQuizLogger
{
    protected int $quiz_name_hash;
    protected int $payload_hash;

    protected int $hits = 0;

    public function __construct($class, $data)
    {
        $this->quiz_name_hash = self::hash($class);
        $this->payload_hash   = self::hash(serialize($data));
    }

    /**
     * @return int
     */
    public function hits(): int
    {
        $result = DB::select('SELECT hits FROM quiz_logs WHERE quiz_name_hash = ? AND payload_hash = ?', [$this->quiz_name_hash, $this->payload_hash]);

        return data_get($result, '0.hits', 0);
    }

    /**
     * @return mixed
     */
    public function write()
    {
        return DB::insert
        ('
            INSERT INTO quiz_logs (`quiz_name_hash`, `payload_hash`) VALUES (?, ?)
            ON duplicate KEY UPDATE hits = hits + 1

        ', [$this->quiz_name_hash, $this->payload_hash]);
    }

    public function reset()
    {
        return DB::delete('DELETE FROM quiz_logs WHERE quiz_name_hash = ?', [$this->payload_hash]);
    }

    protected static function hash($string)
    {
        return crc32($string);
    }
}
