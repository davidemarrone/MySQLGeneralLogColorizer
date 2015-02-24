<?php
namespace MysqlGeneralLogColorizer;

use MysqlGeneralLogColorizer\Console\Application;
use MysqlGeneralLogColorizer\OutputLineWithColor;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{

    public function testEnd2EndParsingAndOutputColor()
    {
        $mysqlLogs = '';
        $mysqlLogs .= "		  1 Connect	phpMaster@localhost on mydb\n";
        $mysqlLogs .= "		  1 Query	SELECT 1\n";
        $filePointer = fopen('data:text/plain,' . urlencode($mysqlLogs), 'rb');
        
        $outputString = '';
        $outputString .= OutputLineWithColor::BLUE . "		  1 Connect	phpMaster@localhost on mydb\n" . OutputLineWithColor::RESET_COLOR;
        $outputString .= OutputLineWithColor::RED . "		  1 Query	SELECT 1\n" . OutputLineWithColor::RESET_COLOR;
        $this->expectOutputString($outputString);
        
        $app = new Console\Application();
        $app->colorize($filePointer);
    }

    public function testEnd2EndWithSimpleExampleFile()
    {
        $filePointer = fopen(__DIR__ . '/../../fixtures/oneMasterOneSlave.txt', 'r');
        
        $outputString = file_get_contents(__DIR__ . '/../../fixtures/oneMasterOneSlave.txt.expected');
        $this->expectOutputString($outputString);
        
        $app = new Console\Application();
        $app->colorize($filePointer);
    }
}