<?php
namespace MysqlGeneralLogColorizer;

class CommandFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testParsingConnectLogEntryWithoutDate()
    {
        $mysqlLog = "		  832 Connect	phpSlaveGeneric@localhost on mydb";
        $commandFactory = new CommandFactory();
        $command = $commandFactory->createCommandFromLogEntry($mysqlLog);
        $this->assertInstanceOf('MysqlGeneralLogColorizer\Command\Connect', $command);
        $this->assertEquals(832, $command->getIdConnection());
        $this->assertEquals('phpSlaveGeneric@localhost', $command->getUsernameWithHost());
        $this->assertEquals('mydb', $command->getDatabase());
        $this->assertEquals(false, $command->isMasterConnection());
    }

    public function testParsingConnectLogEntryWithoutDatabase()
    {
        $mysqlLog = "150221 11:13:22	  322 Connect	root@localhost on ";
        $commandFactory = new CommandFactory();
        $command = $commandFactory->createCommandFromLogEntry($mysqlLog);
        $this->assertInstanceOf('MysqlGeneralLogColorizer\Command\Connect', $command);
        $this->assertEquals(322, $command->getIdConnection());
        $this->assertEquals('root@localhost', $command->getUsernameWithHost());
        $this->assertEquals('', $command->getDatabase());
        $this->assertEquals(false, $command->isMasterConnection());
    }

    public function testParsingConnectLogEntryWithDate()
    {
        $mysqlLog = "150206 11:19:00	 832 Connect	phpMasterGeneric@localhost on mydb";
        $commandFactory = new CommandFactory();
        $command = $commandFactory->createCommandFromLogEntry($mysqlLog);
        $this->assertInstanceOf('MysqlGeneralLogColorizer\Command\Connect', $command);
        $this->assertEquals(832, $command->getIdConnection());
        $this->assertEquals('phpMasterGeneric@localhost', $command->getUsernameWithHost());
        $this->assertEquals('mydb', $command->getDatabase());
        $this->assertEquals(true, $command->isMasterConnection());
    }

    public function testParsingQueryLogEntryQithoutDate()
    {
        $mysqlLog = "		  833 Query	SELECT 1";
        $commandFactory = new CommandFactory();
        $command = $commandFactory->createCommandFromLogEntry($mysqlLog);
        $this->assertInstanceOf('MysqlGeneralLogColorizer\Command\Query', $command);
        $this->assertEquals(833, $command->getIdConnection());
        $this->assertEquals('SELECT 1', $command->getSql());
    }

    public function testParsingQueryLogEntryWithoutDate2()
    {
        $mysqlLog = "		  342 Query	SELECT * FROM table WHERE 1";
        $commandFactory = new CommandFactory();
        $command = $commandFactory->createCommandFromLogEntry($mysqlLog);
        $this->assertInstanceOf('MysqlGeneralLogColorizer\Command\Query', $command);
        $this->assertEquals(342, $command->getIdConnection());
        $this->assertEquals("SELECT * FROM table WHERE 1", $command->getSql());
    }

    public function testUnamanagedCommandAccessDenied()
    {
        $mysqlLog = "		  322 Connect	Access denied for user 'root'@'localhost' (using password: YES)";
        $commandFactory = new CommandFactory();
        $command = $commandFactory->createCommandFromLogEntry($mysqlLog);
        $this->assertInstanceOf('MysqlGeneralLogColorizer\Command\Unmanaged', $command);
    }

    public function testUnamanagedCommandInitDb()
    {
        $mysqlLog = "		  363 Init DB	mysql";
        $commandFactory = new CommandFactory();
        $command = $commandFactory->createCommandFromLogEntry($mysqlLog);
        $this->assertInstanceOf('MysqlGeneralLogColorizer\Command\Unmanaged', $command);
    }

    public function testUnamanagedCommandQuit()
    {
        $mysqlLog = "		  365 Quit	";
        $commandFactory = new CommandFactory();
        $command = $commandFactory->createCommandFromLogEntry($mysqlLog);
        $this->assertInstanceOf('MysqlGeneralLogColorizer\Command\Unmanaged', $command);
    }

    public function testLastCommandNewLogEntryWithMysqlStartupLog()
    {
        $mysqlLog = "/usr/local/mysql/bin/mysqld, Version: 5.5.42-log (MySQL Community Server (GPL)). started with:";
        $commandFactory = new CommandFactory();
        $command = $commandFactory->createCommandFromLogEntry($mysqlLog);
        $this->assertInstanceOf('MysqlGeneralLogColorizer\Command\LastCommandNewLine', $command);
    }

    public function testLastCommandNewLogEntryWithTcpPort()
    {
        $mysqlLog = "Tcp port: 3306  Unix socket: /tmp/mysqld.sock";
        $commandFactory = new CommandFactory();
        $command = $commandFactory->createCommandFromLogEntry($mysqlLog);
        $this->assertInstanceOf('MysqlGeneralLogColorizer\Command\LastCommandNewLine', $command);
    }

    public function testLastCommandNewLogEntryWithHeader()
    {
        $mysqlLog = "Time                 Id Command    Argument";
        $commandFactory = new CommandFactory();
        $command = $commandFactory->createCommandFromLogEntry($mysqlLog);
        $this->assertInstanceOf('MysqlGeneralLogColorizer\Command\LastCommandNewLine', $command);
    }
}