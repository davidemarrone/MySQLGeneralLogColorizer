<?php
namespace MysqlGeneralLogColorizer;

class ConnectionsRegistry
{

    private $connections = array();

    public function addConnection($idConnection, Command\Connect $connnect)
    {
        $this->connections[$idConnection] = $connnect;
    }

    public function getConnection($idConnection)
    {
        if (isset($this->connections[$idConnection])) {
            return $this->connections[$idConnection];
        } else {
            throw new \InvalidArgumentException(sprintf("The connection id: %d is not present", $idConnection));
        }
    }

    public function getAllConnections()
    {
        return $this->connections;
    }
}
