Mysql General Log Colorizer 
===========================
[![Build Status](https://travis-ci.org/davidemarrone/MysqlGeneralLogColorizer.svg?branch=master)](https://travis-ci.org/davidemarrone/MysqlGeneralLogColorizer)

This is a log colorizer for [Mysql General Query Log](http://dev.mysql.com/doc/refman/5.6/en/query-log.html), the main goal of this software is to show easily if a query is done to a *Master* database or to a *Slave* in a Master/Slave environment.

This program keep track of every id logged with the *Connect* statement and when a *Query* statement is analyzed it colorize the line with green if is done on Slave and red if is done on the Master connection.

To understand if the *Connect* is done to master or slave database it simple try to search for "master" keyword in the username logged on the Connect (can be improved).


Usage
-----

To enable the logging of every query see [Mysql General Query Log](http://dev.mysql.com/doc/refman/5.6/en/query-log.html)

###For Mysql >=  5.1.29

my.cnf in the [mysqld] section
```
general_log_file=/var/log/mysql-general-query.log
general_log=1
```

command line
```
SET GLOBAL general_log_file='/var/log/mysql-general-query.log';
SET GLOBAL general_log=1;
```

###For Mysql <=  5.1.12

my.cnf in the [mysqld] section
```
log=/var/log/mysql-general-query.log
```

command line
```
SET GLOBAL log='/var/log/mysql-general-query.log';
```

TODO
----
* Review colors for each Command

* Fix autoloading on bin/mysql-general-log-colorizer
* Add parameter to discard specific Command: Quit, Query SET ...
* Add more tests on log analyzer when the final colors are completely defined
* Complete MysqlGeneralLogColorizerTest when final colors are completely defined
* Add specific colors for transactions
* Improve the detection of master connections
* Format SQL with https://github.com/jdorn/sql-formatter
* Create a new library to handle the output colors
* Create a screenshot example
