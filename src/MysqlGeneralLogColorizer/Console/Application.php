<?php
namespace MysqlGeneralLogColorizer\Console;

use MysqlGeneralLogColorizer\LogAnalyzer;
use MysqlGeneralLogColorizer\CommandFactory;

class Application
{

    public function colorize($filePointer)
    {
        $logAnalyzer = new LogAnalyzer();
        $commandFactory = new CommandFactory();
        
        while (1) {
            $rawLine = fgets($filePointer);
            if ($rawLine === false) {
                break;
            }
            
            $line = $commandFactory->createCommandFromLogEntry($rawLine);
            $textLineWithColor = $logAnalyzer->analyze($line);
            echo $textLineWithColor->toString();
        }
    }

    public function run()
    {
        $stdin = fopen('php://stdin', 'r');
        $this->colorize($stdin);
    }
}

