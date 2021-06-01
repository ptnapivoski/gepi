<?php

// Configura o fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Quebra de linha padrão
$EOL = "\n";

// Tipo padrão de tipo do documento e cabeçalho deste tipo de documento
/*
$SITE_CONTENT_TYPE = 'Content-Type: text/xml; charset=utf-8';
$SITE_FILE_HEADER  = '<?xml version="1.0" encoding="utf-8"?>';
*/
$SITE_CONTENT_TYPE = 'Content-Type: text/html; charset=utf-8';
$SITE_FILE_HEADER  = '<!doctype html>';

// Endereço do host MySQL
$SITE_DB_HOST     = '127.0.0.1';
// Porta do host MySQL
$SITE_DB_PORT     = 3306;
// Usuário no MySQL
$SITE_DB_USER     = 'root';
// Senha do MySQL
$SITE_DB_PASSWORD = 'l0c4lh05t';
// DB no MySQL
$SITE_DB_SCHEMA   = 'gepi';
// Configura conjunto de caracteres para o UTF-8 estendido de até 4 bytes
$SITE_DB_CHARSET  = 'utf8mb4';
// Query que configura as mensagens de erro para portugues brasileiro
$SITE_DB_LANG     = 'SET lc_messages=\'pt-BR\';';

// Diretório de arquivos anexos
$FDIR = 'f';
// Tamanho máximo de arquivo
$FMS = 8388608;

// Seta o nome do cookie de sessão
session_name('SID');
// Configura sessão, mais especificamente o tempo da sessão
session_set_cookie_params(86400);
// Inicia sessão
session_start();

// Começa com usuário não logado
if(!isset($_SESSION['user']))
	$_SESSION['user'] = 0;

// Caso não esteja configurado o IP da sessão...
if(!isset($_SESSION['IP']))
	// Configura-o
	$_SESSION['IP'] = $_SERVER['REMOTE_ADDR'];
// Se configurado e diferente do endereço remoto, a sessão é invalida e é
// possível que tenha ocorrido vazamento do SID, sendo assim:
else if($_SESSION['IP'] !== $_SERVER['REMOTE_ADDR']){
	// Manda cabeçalho do tipo de arquivo
	header($SITE_CONTENT_TYPE);
	// Informa que a sessão é inválida
	echo $SITE_FILE_HEADER, $EOL, '<p style="color:red">Sessão inválida</p>', $EOL;
	// E faz nada mais
	exit();
}
