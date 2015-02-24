<?php
namespace MysqlGeneralLogColorizer\Command;

/**
 * List of Commands from Mysql sources:
 *
 * include/mysql_com.h
 *
 * enum enum_server_command
 * {
 * COM_SLEEP, COM_QUIT, COM_INIT_DB, COM_QUERY, COM_FIELD_LIST,
 * COM_CREATE_DB, COM_DROP_DB, COM_REFRESH, COM_SHUTDOWN, COM_STATISTICS,
 * COM_PROCESS_INFO, COM_CONNECT, COM_PROCESS_KILL, COM_DEBUG, COM_PING,
 * COM_TIME, COM_DELAYED_INSERT, COM_CHANGE_USER, COM_BINLOG_DUMP,
 * COM_TABLE_DUMP, COM_CONNECT_OUT, COM_REGISTER_SLAVE,
 * COM_STMT_PREPARE, COM_STMT_EXECUTE, COM_STMT_SEND_LONG_DATA, COM_STMT_CLOSE,
 * COM_STMT_RESET, COM_SET_OPTION, COM_STMT_FETCH, COM_DAEMON,
 * COM_BINLOG_DUMP_GTID, COM_RESET_CONNECTION,
 * / * don't forget to update const char *command_name[] in sql_parse.cc * /
 * / * Must be last * /
 * COM_END};
 *
 *
 * sql/sql_parse.cc
 *
 * const LEX_STRING command_name[]={
 * { C_STRING_WITH_LEN("Sleep") },
 * { C_STRING_WITH_LEN("Quit") },
 * { C_STRING_WITH_LEN("Init DB") },
 * { C_STRING_WITH_LEN("Query") },
 * { C_STRING_WITH_LEN("Field List") },
 * { C_STRING_WITH_LEN("Create DB") },
 * { C_STRING_WITH_LEN("Drop DB") },
 * { C_STRING_WITH_LEN("Refresh") },
 * { C_STRING_WITH_LEN("Shutdown") },
 * { C_STRING_WITH_LEN("Statistics") },
 * { C_STRING_WITH_LEN("Processlist") },
 * { C_STRING_WITH_LEN("Connect") },
 * { C_STRING_WITH_LEN("Kill") },
 * { C_STRING_WITH_LEN("Debug") },
 * { C_STRING_WITH_LEN("Ping") },
 * { C_STRING_WITH_LEN("Time") },
 * { C_STRING_WITH_LEN("Delayed insert") },
 * { C_STRING_WITH_LEN("Change user") },
 * { C_STRING_WITH_LEN("Binlog Dump") },
 * { C_STRING_WITH_LEN("Table Dump") },
 * { C_STRING_WITH_LEN("Connect Out") },
 * { C_STRING_WITH_LEN("Register Slave") },
 * { C_STRING_WITH_LEN("Prepare") },
 * { C_STRING_WITH_LEN("Execute") },
 * { C_STRING_WITH_LEN("Long Data") },
 * { C_STRING_WITH_LEN("Close stmt") },
 * { C_STRING_WITH_LEN("Reset stmt") },
 * { C_STRING_WITH_LEN("Set option") },
 * { C_STRING_WITH_LEN("Fetch") },
 * { C_STRING_WITH_LEN("Daemon") },
 * { C_STRING_WITH_LEN("Binlog Dump GTID") },
 * { C_STRING_WITH_LEN("Reset Connection") },
 * { C_STRING_WITH_LEN("Error") } // Last command number
 * };
 */
abstract class AbstractCommand
{

    private $rawLine;

    private $idConnection;

    public function __construct($rawLine, $idConnection = 0)
    {
        $this->rawLine = $rawLine;
        $this->idConnection = $idConnection;
    }

    public function getRawLine()
    {
        return $this->rawLine;
    }

    public function getIdConnection()
    {
        return $this->idConnection;
    }
}
