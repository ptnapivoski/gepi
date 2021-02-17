<?php

// Tenta conectar
if($db_link = @mysqli_connect($SITE_DB_HOST, $SITE_DB_USER, $SITE_DB_PASSWORD, $SITE_DB_SCHEMA, $SITE_DB_PORT)){
	// Seta o conjunto de caracteres
	mysqli_set_charset($db_link, $SITE_DB_CHARSET);
	// E a língua dos erros do MySQL
	mysqli_query($db_link, $SITE_DB_LANG);
}
