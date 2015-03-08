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

    public function testEnd2EndOneMasterOneSlaveWithDifferentUsername()
    {
        $filePointer = fopen(__DIR__ . '/../../fixtures/oneMasterOneSlaveDifferentUsername.txt', 'r');
        
        $outputString = file_get_contents(__DIR__ . '/../../fixtures/oneMasterOneSlaveDifferentUsername.txt.expected');
        $this->expectOutputString($outputString);
        
        $app = new Console\Application();
        $app->colorize($filePointer);
    }

    public function testEnd2EndOneMasterOneSlaveWithDifferentIpSameUsername()
    {
        $masterPattern = '@127.0.0.1';
        $filePointer = fopen(__DIR__ . '/../../fixtures/oneMasterOneSlaveDifferentIp.txt', 'r');
        
        $outputString = file_get_contents(__DIR__ . '/../../fixtures/oneMasterOneSlaveDifferentIp.txt.expected');
        $this->expectOutputString($outputString);
        
        $app = new Console\Application();
        $app->colorize($filePointer, $masterPattern);
    }

    public static function masterOptions()
    {
        return array(
            array(
                'm'
            ),
            array(
                'master-pattern'
            )
        );
    }

    /**
     * @dataProvider masterOptions
     */
    public function testGetOptionMasterOptions($option)
    {
        $parsedOption = array();
        $parsedOption[$option[0]] = 'master';
        
        $app = new Console\Application();
        $options = $app->getOptions($parsedOption);
        
        $this->assertEquals('master', $options['masterPattern']);
    }
}