<?php

/**
 * Path settings
 */
//Relative path to folder with the files with employees names
define('__PATH_FILE__', 'arquivos/');
//Extension pf the files folder above
define('__EXT_FILE__', '.pdf');
//path until aplication
define('__ABS_DIR__', $_SERVER['DOCUMENT_ROOT'] . '/');




/**
 * Database connection 
 */
//NOTE: database table = 'funcionarios'; Columns = 'Id', 'Contrato', 'Nome', 'Email'
//mysql
$hostname = '';
$user_name = '';
$password = '';
$port = '';
$database = '';
$conn = mysqli_connect($hostname, $user_name, $password, $database, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8');

//NOTE: ODBC Connection: replace all 'mysqli_query' for 'mysqli_query' / replace all 'mysqli_fetch_object' for 'odbc_fetch_object'
//define('__ODBCName__', '');
//$conn = odbc_connect(__ODBCName__, '', '');




/**
 * Email settings
 */
//Setting to email signature
define('__NOME_ASSINATURA__', '');
define('__TELEFONE_ASSINATURA__', '');
define('__EMAIL_ASSINATURA__', '');
define('__REL_LOGO_PATH__', '/assets/exempleLogo.png');
//Email settings sender
define('__EMAIL_REMETENTE__', '');
define('__EMAIL_SENHA__', '');
define('__SMTP_SECURE__', '');
define('__HOST__', '');
define('__PORT__', 0);
