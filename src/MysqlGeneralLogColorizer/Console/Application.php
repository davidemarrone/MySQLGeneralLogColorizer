<?php
namespace MysqlGeneralLogColorizer\Console;

use MysqlGeneralLogColorizer\LogAnalyzer;
use MysqlGeneralLogColorizer\CommandFactory;

class Application
{

    public function colorize($filePointer, $masterPattern = null)
    {
        $logAnalyzer = new LogAnalyzer();
        $commandFactory = new CommandFactory();
        if ($masterPattern) {
            $commandFactory->setMasterPatternForConnect($masterPattern);
        }
        
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

    public function getUsageOutput($programName)
    {
        $usage = '' . PHP_EOL;
        $usage .= 'Usage: ' . $programName . ' [options] ' . PHP_EOL;
        $usage .= '' . PHP_EOL;
        $usage .= 'Options' . PHP_EOL;
        $usage .= '' . PHP_EOL;
        $usage .= "    -m|--master-pattern\t\tSpecify the master pattern to identity the master connection" . PHP_EOL;
        $usage .= "                       \t\tFor example: master or master@127.0.0.1 or @127.0.0.1" . PHP_EOL;
        $usage .= '' . PHP_EOL;
        
        return $usage;
    }

    public function getParsedOptionsFromArgv()
    {
        $shortOpts = '';
        $shortOpts .= 'm:';
        $shortOpts .= 'h';
        
        $longOpts = array(
            'master-pattern:',
            'help'
        );
        
        return getopt($shortOpts, $longOpts);
    }

    public function getOptions(array $parsedOptions)
    {
        $options = array();
        if (isset($parsedOptions['m']) && is_string($parsedOptions['m'])) {
            $options['masterPattern'] = $parsedOptions['m'];
        }
        if (isset($parsedOptions['master-pattern']) && is_string($parsedOptions['master-pattern'])) {
            $options['masterPattern'] = $parsedOptions['master-pattern'];
        }
        
        return $options;
    }

    public function handleArguments()
    {
        $parsedOptions = $this->getParsedOptionsFromArgv();
        
        if (isset($parsedOptions['h']) || isset($parsedOptions['help'])) {
            echo $this->getUsageOutput($_SERVER['argv'][0]);
            exit();
        } else {
            $options = $this->getOptions($parsedOptions);
            return $options;
        }
    }

    public function run()
    {
        $options = $this->handleArguments();
        $masterPattern = isset($options['masterPattern']) ? $options['masterPattern'] : null;
        $stdin = fopen('php://stdin', 'r');
        $this->colorize($stdin, $masterPattern);
    }
}

