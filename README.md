Mysql General Log Colorizer 
===========================
[![Build Status](https://travis-ci.org/davidemarrone/MysqlGeneralLogColorizer.svg?branch=master)](https://travis-ci.org/davidemarrone/MysqlGeneralLogColorizer)

This is a log colorizer for [Mysql General Query Log](http://dev.mysql.com/doc/refman/5.6/en/query-log.html), the main goal of this software is to show easily if a query is done to a *Master* database or to a *Slave* one in a Master/Slave environment.

![Colorizer example](/docs/screenshot.png?raw=true "Here a simple example")

This program keeps track of every id logged with the *Connect* statement and when a *Query* statement is analyzed it colorize the line with green if is done on the Slave connection or red if is done on the Master connection.

To understand if the connection was to a master or slave database it simple try to search for "master" keyword in the username logged (can be improved).

Install
-------

```
wget https://github.com/davidemarrone/MysqlGeneralLogColorizer/releases/download/v1.0.0/mysql-general-log-colorizer.phar

chmod +x mysql-general-log-colorizer.phar

sudo mv mysql-general-log-colorizer.phar /usr/local/bin/mysql-general-log-colorizer
```

Usage
-----

First of all enable the Mysql General Log that logs every query see [Mysql General Query Log](http://dev.mysql.com/doc/refman/5.6/en/query-log.html)

####For Mysql >=  5.1.29

my.cnf in the [mysqld] section
```
general_log_file=/var/log/mysql-general-query.log
general_log=1
```

console
```
SET GLOBAL general_log_file='/var/log/mysql-general-query.log';
SET GLOBAL general_log=1;
```

####For Mysql <=  5.1.12

my.cnf in the [mysqld] section
```
log=/var/log/mysql-general-query.log
```

console
```
SET GLOBAL log='/var/log/mysql-general-query.log';
```

####Run it

It simple reads from stdin
```
tail -f /var/log/mysql-general-query.log | mysql-general-log-colorizer
```

TODO
----
* Add parameter to discard specific Command: Quit, Query SET ...
* Add more tests on log analyzer when the final colors are completely defined
* Complete MysqlGeneralLogColorizerTest when final colors are completely defined
* Add specific colors for transactions
* Improve the detection of master connections (Add parameter)
* Format SQL with https://github.com/jdorn/sql-formatter
* Create a new library to handle the output colors
* Create a screenshot example

