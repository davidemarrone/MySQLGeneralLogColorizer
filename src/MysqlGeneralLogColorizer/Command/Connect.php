<?php
namespace MysqlGeneralLogColorizer\Command;

class Connect extends AbstractCommand
{

    private $username;

    private $database;

    private $containsMasterUsername;

    const MASTER_USERNAME_PATTERN = 'master';

    public function __construct($rawLine, $idConnection, $username, $database)
    {
        parent::__construct($rawLine, $idConnection);
        $this->username = $username;
        $this->database = $database;
        if (stripos($this->username, self::MASTER_USERNAME_PATTERN) !== false) {
            $this->containsMasterUsername = true;
        } else {
            $this->containsMasterUsername = false;
        }
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getDatabase()
    {
        return $this->database;
    }

    public function containsMasterUsername()
    {
        return $this->containsMasterUsername;
    }
}
