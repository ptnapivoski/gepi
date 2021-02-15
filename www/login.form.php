<?php

// Inicializa ambiente
require_once('init.php');

// Inclui começo padrão: abre html e head
require_once('inc.top.php');
// Coloca o título do documento
echo '<title>GEPI: Login</title>', $EOL;
// Inclue meio comum: css, jquery, fecha head e abre body
require_once('inc.mid.php');
// Inclue mensagem da sessão
require_once('inc.msg.php');

// Tenta conectar ao DB
require_once('db.link.php');

// Se conectado ao DB
if($db_link){
	echo
		// Começa a seção
		'<section id="login-form">', $EOL,
			// Começa o formulário
			'<form action="login.php" method="post">', $EOL,
				// ID do login
				'<p class="lab"><label for="login-id">Login:</label></p>', $EOL,
				'<p class="login-field"><input type="number" name="id" id="login-id" min="0"/></p>', $EOL,
				// Senha do login
				'<p class="lab"><label for="login-password">Senha:</label></p>', $EOL,
				'<p class="login-field"><input type="password" name="password" id="login-password"/></p>', $EOL,
				// Botão do login
				'<p><input type="submit" value="Entrar"/></p>', $EOL,
			'</form>', $EOL,
		'</section>', $EOL
	;

// Ao não conseguir conectar
} else require_once('db.link.err.echo.section.php');

require_once('inc.bot.php');
