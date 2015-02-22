<?php
namespace MysqlGeneralLogColorizer;

class LogAnalyzer
{

    private $connectionRegistry;

    private $lastColor = OutputLineWithColor::GREY;

    public function __construct()
    {
        $this->connectionRegistry = new ConnectionsRegistry();
    }

    private function createOutputLineWithColor($command, $color)
    {
        $this->lastColor = $color;
        return new OutputLineWithColor($command->getRawLine(), $color);
    }

    public function analyze(Command\AbstractCommand $command)
    {
        if ($command instanceof Command\Connect) {
            $this->connectionRegistry->addConnection($command->getIdConnection(), $command);
            return $this->createOutputLineWithColor($command, OutputLineWithColor::BLUE);
        }
        
        if ($command instanceof Command\Query) {
            $color = null;
            try {
                $connection = $this->connectionRegistry->getConnection($command->getIdConnection());
                $color = $connection->containsMasterUsername() ? OutputLineWithColor::RED : OutputLineWithColor::GREEN;
            } catch (\InvalidArgumentException $iag) {
                $color = OutputLineWithColor::GREY;
            }
            return $this->createOutputLineWithColor($command, $color);
        }
        
        if ($command instanceof Command\LastCommandNewLine) {
            return $this->createOutputLineWithColor($command, $this->lastColor);
        }
        
        if ($command instanceof Command\Unmanaged) {
            return $this->createOutputLineWithColor($command, OutputLineWithColor::GREY);
        }
        
        throw new \Exception("Unknown command");
    }

    public function getConnectionRegistry()
    {
        return $this->connectionRegistry;
    }
}
