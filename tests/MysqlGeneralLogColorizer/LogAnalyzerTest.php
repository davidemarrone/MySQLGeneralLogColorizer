<?php
namespace MysqlGeneralLogColorizer;

class LogAnalyzerTest extends \PHPUnit_Framework_TestCase
{

    public function testAnalyzerLogsContainsOnlyOneConnection()
    {
        $mysqlLog = "		  1 Connect	phpMaster@localhost on mydb";
        $commandFactory = new CommandFactory();
        $command = $commandFactory->createCommandFromLogEntry($mysqlLog);
        
        $analyzer = new LogAnalyzer();
        $outputLineWithColor = $analyzer->analyze($command);
        
        $this->assertCount(1, $analyzer->getConnectionRegistry()
            ->getAllConnections());
        
        $connect = $analyzer->getConnectionRegistry()->getConnection(1);
        $this->assertInstanceOf('MysqlGeneralLogColorizer\Command\Connect', $connect);
        $this->assertEquals(1, $command->getIdConnection());
        $this->assertEquals('phpMaster@localhost', $command->getUsername());
        $this->assertEquals('mydb', $command->getDatabase());
        $this->assertEquals(true, $command->containsMasterUsername());
        
        $this->assertInstanceOf('MysqlGeneralLogColorizer\OutputLineWithColor', $outputLineWithColor);
    }

    public function testAnalyzerLogsContainsOneConnectionAndOneQuery()
    {
        $mysqlLogs = array();
        $mysqlLogs[] = "		  1 Connect	phpMaster@localhost on mydb";
        $mysqlLogs[] = "		  1 Query	SELECT 1";
        $commandFactory = new CommandFactory();
        $analyzer = new LogAnalyzer();
        
        $outputLineWithColor = null;
        foreach ($mysqlLogs as $mysqlLog) {
            $command = $commandFactory->createCommandFromLogEntry($mysqlLog);
            $outputLineWithColor = $analyzer->analyze($command);
        }
        
        $this->assertInstanceOf('MysqlGeneralLogColorizer\OutputLineWithColor', $outputLineWithColor);
    }
}
