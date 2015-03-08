MySQL General Log Colorizer 
===========================
[![Build Status](https://travis-ci.org/davidemarrone/MysqlGeneralLogColorizer.svg?branch=master)](https://travis-ci.org/davidemarrone/MysqlGeneralLogColorizer)

Who is this tool for?
---------------------

This tool is for you if you are in this situation:

* You are developing an application that use MySQL with a Master/Slave configuration
* You want to test your code on your local machine with only **one** MySQL instance 
* You use two different connections for Master and Slave and you simulate the Master/Slave setup with different username or different IP address/hosts on the same instance
* You usually develop watching the MySQL general log to understand what SQL queries your ORM (or DBAL, Framework, ...) is generating and on which connection they are executed

This tool is a log colorizer for [MySQL General Query Log](http://dev.mysql.com/doc/refman/5.6/en/query-log.html), the main goal of this software is to show easily, in a testing environment, if a query is done to a **Master** connection or to a **Slave** one. It keeps track of every *id* logged with the **Connect** statement and when a **Query** statement is analyzed it colorize the line with *green* if is done on the Slave connection or *red* if is done on the Master connection. Here a simple example:

![Colorizer example](/docs/screenshot.png?raw=true "Example of the tool output")

To understand if a connection will be done to the master the tool by default search for "master" keyword in the username logged with *Connect*, you can specify another username or IP/host using the *-m* switch.

Install
-------

```
wget https://github.com/davidemarrone/MysqlGeneralLogColorizer/releases/download/v1.0.0/mysql-general-log-colorizer.phar

chmod +x mysql-general-log-colorizer.phar

sudo mv mysql-general-log-colorizer.phar /usr/local/bin/mysql-general-log-colorizer
```

Usage
-----

First of all enable the MySQL General Log that logs every query see [MySQL General Query Log](http://dev.mysql.com/doc/refman/5.6/en/query-log.html)

####For MySQL >=  5.1.29

Configuration for my.cnf in the [mysqld] section
```
general_log_file=/var/log/mysql-general-query.log
general_log=1
```

Or directly from the console with root permissions
```
SET GLOBAL general_log_file='/var/log/mysql-general-query.log';
SET GLOBAL general_log=1;
```

####For MySQL <=  5.1.12

Configuration for my.cnf in the [mysqld] section
```
log=/var/log/mysql-general-query.log
```

Or directly from the console with root permissions
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
* Add more tests on log analyzer when the final colors are completely defined
* Add specific colors for transactions
* Add parameter to discard specific Commands: Quit, Query SET ... ?
* Format SQL with https://github.com/jdorn/sql-formatter
* Create a new library to handle the output colors
