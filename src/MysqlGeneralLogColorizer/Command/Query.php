<?php
namespace MysqlGeneralLogColorizer\Command;

class Query extends AbstractCommand
{

    private $sql;

    public function __construct($rawLine, $idConnection, $sql)
    {
        parent::__construct($rawLine, $idConnection);
        $this->sql = $sql;
    }

    public function getSql()
    {
        return $this->sql;
    }
}
