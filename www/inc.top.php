<?php

// Envia o cabeçalho HTTP correspondente ao tipo de documento configurado
header($SITE_CONTENT_TYPE);
// Muda o cabeçalho do documento, abre a tag html e a a head
echo
	$SITE_FILE_HEADER, $EOL,
	'<html lang="pt-br">', $EOL,
	'<head>', $EOL
;
