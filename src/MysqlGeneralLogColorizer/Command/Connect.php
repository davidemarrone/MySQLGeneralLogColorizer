<?php
namespace MysqlGeneralLogColorizer\Command;

class Connect extends AbstractCommand
{

    private $usernameWithHost;

    private $database;

    private $isMasterConnection;

    const DEFAULT_MASTER_PATTERN = 'master';

    public function __construct($rawLine, $idConnection, $usernameWithHost, $database, $masterPattern = null)
    {
        parent::__construct($rawLine, $idConnection);
        $this->usernameWithHost = $usernameWithHost;
        $this->database = $database;

        if (null == $masterPattern){
            $masterPattern = self::DEFAULT_MASTER_PATTERN;
        }

        if (stripos($this->usernameWithHost, $masterPattern) !== false) {
            $this->isMasterConnection = true;
        } else {
            $this->isMasterConnection = false;
        }
    }

    public function getUsernameWithHost()
    {
        return $this->usernameWithHost;
    }

    public function getDatabase()
    {
        return $this->database;
    }

    public function isMasterConnection()
    {
        return $this->isMasterConnection;
    }
}
