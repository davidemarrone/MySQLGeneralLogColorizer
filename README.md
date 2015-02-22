Mysql General Log Colorizer 
===========================

This is a log colorizer for Mysql General Query Log (http://dev.mysql.com/doc/refman/5.6/en/query-log.html), the main goal of this software is to show easily  if a query is done on a connection to a master database or to a slave one in a Master/Slave environment.
This program keep track of every id logged with the Connect statement and when a Query statement is analyzed it colorize the line with green if is done on slave and red if is done on the master connection.
To understand if the Connect is done on master or slave database it simple try to search for "master" keyword in the username used for the connetion (can be improved).


Usage
-----

To enable the logging of every query in Mysql (see http://dev.mysql.com/doc/refman/5.6/en/query-log.html for more info)

###Mysql >=  5.1.29

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

###Mysql <=  5.1.12

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
* Add support for travis
* Fix phar generation with box
* Review colors for each Command

* Add parameter to discard specific Command: Quit, Query SET ...
* Add more tests on log analyzer when the final colors are completely defined
* Complete MysqlGeneralLogColorizerTest when final colors are completely defined
* Add specific colors for transactions
* Improve the detection of master connections
* Format SQL with https://github.com/jdorn/sql-formatter
* Create a new library to handle the output colors
* Create a screenshot example
