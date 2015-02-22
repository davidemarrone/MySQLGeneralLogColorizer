<?php
namespace MysqlGeneralLogColorizer\Command;

abstract class AbstractCommand
{

    private $rawLine;

    private $idConnection;

    public function __construct($rawLine, $idConnection = 0)
    {
        $this->rawLine = $rawLine;
        $this->idConnection = $idConnection;
    }

    public function getRawLine()
    {
        return $this->rawLine;
    }

    public function getIdConnection()
    {
        return $this->idConnection;
    }
}
