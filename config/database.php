<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the "Database Connection"
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the "default" group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

//$active_group = "mamp";
$active_group = "dreamhost";
$active_record = TRUE;

 /*
 | 127.0.0.1 localhost developement
*/
$db['mamp']['hostname'] = "localhost";
$db['mamp']['username'] = "root";
$db['mamp']['password'] = "root";
$db['mamp']['database'] = "customer_portal";
$db['mamp']['dbdriver'] = "mysql";
$db['mamp']['dbprefix'] = "";
$db['mamp']['pconnect'] = TRUE;
$db['mamp']['db_debug'] = TRUE;
$db['mamp']['cache_on'] = FALSE;
$db['mamp']['cachedir'] = "";
$db['mamp']['char_set'] = "utf8";
$db['mamp']['dbcollat'] = "utf8_general_ci";
$db['mamp']['autoinit'] = TRUE;
$db['mamp']['stricton'] = FALSE;

 /*
 |"dopey:beahan" MySQL Server
*/
$db['dreamhost']['hostname'] = "mysql.arkayportal.com";
$db['dreamhost']['username'] = "mysharona";
$db['dreamhost']['password'] = "wene-rta-quuh";
$db['dreamhost']['database'] = "customer_portal";
$db['dreamhost']['dbdriver'] = "mysql";
$db['dreamhost']['dbprefix'] = "";
$db['dreamhost']['pconnect'] = TRUE;
$db['dreamhost']['db_debug'] = TRUE;
$db['dreamhost']['cache_on'] = FALSE;
$db['dreamhost']['cachedir'] = "";
$db['dreamhost']['char_set'] = "utf8";
$db['dreamhost']['dbcollat'] = "utf8_general_ci";
$db['dreamhost']['swap_pre'] = '';
$db['dreamhost']['autoinit'] = TRUE;
$db['dreamhost']['stricton'] = FALSE;
/* End of file database.php */
/* Location: ./system/application/config/database.php */