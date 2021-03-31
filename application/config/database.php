<?php
defined('BASEPATH') OR exit('No direct script access allowed');




$active_group = 'default';
$query_builder = TRUE;

/*$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'postgres',
	'password' => '1982',
	'database' => 'dejurbevalidacion2020ultimo',
	'dbdriver' => 'postgre',	
	'port'     => '5433',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);*/
$db['default'] = array(
	'dsn'	=> '',
 	
   'hostname' => '192.168.15.90',
	'username' => 'postgres',
	'password' => 'BDpruebas17..',
	'database' => 'validacion2020',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);


$db['db_sicenad'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'postgres',
	'password' => '1982',
	'database' => 'sicenad',
	'dbdriver' => 'postgre',
	'port'     => '5433',	
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

/*$db['default'] = array(
	'dsn'	=> '',
 	
   'hostname' => '192.168.15.90',
	'username' => 'postgres',
	'password' => 'BDpruebas17..',
	'database' => 'DEJURBEOFICIAL27',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE

	'hostname' => 'dohko.senape.gob.bo',// 
	'username' => 'postgres',
	'password' => 'ur4m1hc0r0',
	'database' => 'dejurbevalidacion2019',//
	'dbdriver' => 'postgre',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
$db['db_sicenad'] = array(
	'dsn'	=> '',
	'hostname' => '192.168.15.100',
	'username' => 'postgres',
	'password' => 'js3QmA9vZ7edF2X',
	'database' => 'sicenad14',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['db_dejurbe11'] = array(
	'dsn'	=> '',
	'hostname' => '192.168.15.53',
	'username' => 'postgres',
	'password' => 'ur4m1hc0r0',
	'database' => 'dejurbe11',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
$db['db_dejurbe_gestion2020'] = array(
	'dsn'	=> '',
	'hostname' => '192.168.15.53',
	'username' => 'postgres',
	'password' => 'ur4m1hc0r0',
	'database' => 'dejurbe_gestion2020',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

/*
$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'dohko.senape.gob.bo',
	'username' => 'postgres',
	'password' => 'ur4m1hc0r0',
	'database' => 'dejurbe11',
	'dbdriver' => 'postgre',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

/*
$db['default'] = array(
	'dsn'	=> '',
	'hostname' => '192.168.15.100',
	'username' => 'postgres',
	'password' => '123456',
	'database' => 'dejurbe11',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);*/
