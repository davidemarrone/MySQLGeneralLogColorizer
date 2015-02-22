<?php
namespace MysqlGeneralLogColorizer;

class ConnectionRegistryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetInvalidConnection()
    {
        $connectionsRegistry = new ConnectionsRegistry();
        $connectionsRegistry->getConnection(1);
    }
}