<?php
namespace MysqlGeneralLogColorizer;

use MysqlGeneralLogColorizer\Command\Connect;
use MysqlGeneralLogColorizer\Command\Query;
use MysqlGeneralLogColorizer\Command\Unmanaged;
use MysqlGeneralLogColorizer\Command\LastCommandNewLine;

class CommandFactory
{

    /**
     * In some lines is present at the beginning at the line the date and time
     * if present is stripped
     */
    private function stripRandomDateAndTime($rawLine)
    {
        $isDateTimePresent = preg_match('#^[0-9]{6}[ ][0-9]{2}:[0-9]{2}:[0-9]{2}\t#', $rawLine);
        if ($isDateTimePresent) {
            $dateTimeLength = strlen('150221 11:16:48');
            $rawLine = substr($rawLine, $dateTimeLength);
        }
        return $rawLine;
    }

    /**
     * Try to understand if the log line is from previuos line or is a new line
     * @TODO: the list of mysql "Command" can be incomplete
     */
    private function isNewLogEntry($rawLine)
    {
        $mysqlLogKeywords = implode('|', array(
            'Connect',
            'Query',
            'Init DB',
            'Quit'
        ));
        
        return $isNewLogEntry = preg_match(sprintf('#[ ][0-9]+[ ](%s)\t#', $mysqlLogKeywords), $rawLine);
    }

    public function createCommandFromLogEntry($rawLine)
    {
        if ($this->isNewLogEntry($rawLine)) {
            
            $rawLineWithoutDate = $this->stripRandomDateAndTime($rawLine);
            
            $isQuery = preg_match('#([0-9]+) Query\t(.*)$#', $rawLineWithoutDate, $matches);
            if ($isQuery) {
                $idConnection = $matches[1];
                $sql = $matches[2];
                return new Query($rawLine, $idConnection, $sql);
            }
            
            $isConnect = preg_match('#([0-9]+) Connect\t([^ ]+)[\s]+on[\s]+([^ ]+)?$#', $rawLineWithoutDate, $matches);
            if ($isConnect) {
                $idConnection = $matches[1];
                $username = $matches[2];
                $database = isset($matches[3]) ? $matches[3] : '';
                return new Connect($rawLine, $idConnection, $username, $database);
            }
            
            return new Unmanaged($rawLine);
        } else {
            
            return new LastCommandNewLine($rawLine);
        }
    }
}
