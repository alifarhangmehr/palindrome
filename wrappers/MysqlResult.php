<?php

namespace wrappers;

class MysqlResult
{
    /** @var \mysqli_result Original database result object */
    private $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    public function getNumRows(): int
    {
        return $this->result->num_rows;
    }

    /**
     * @return array|bool
     */
    public function fetchAssoc()
    {
        if (is_bool($this->result)) {
            return $this->result;
        }
        return $this->result->fetch_assoc();
    }
}
