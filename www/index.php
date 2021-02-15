<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Inclui começo padrão: abre html e head
	require_once('inc.top.php');
	// Coloca o título do documento
	echo '<title>GEPI: Página Inicial</title>', $EOL;
	// Inclue meio comum: css, jquery, fecha head e abre body
	require_once('inc.mid.php');
	// Inclue menu
	require_once('inc.menu.php');
	// Inclue mensagem da sessão
	require_once('inc.msg.php');
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Tenta selecionar os dados da entidade autenticada
		if($db_query = mysqli_query($db_link, "SELECT nome FROM entidade WHERE id = $_SESSION[user];")){
			// Recebe dados da consulta
			$db_result = mysqli_fetch_row($db_query);
			// Valida os dados vindos
			$db_result[0] = htmlspecialchars($db_result[0]);

			// Exibe o usuário autenticado
			echo '<section><p>Autenticação: ', $db_result[0], '</p></section>', $EOL;

			// Limpa a consulta
			mysqli_free_result($db_query);
		// Caso ocorrera um problema na consulta
		} else echo '<section><p class="error">Erro na consulta com a Base de Dados: ', htmlspecialchars(mysqli_error($db_link)), '</p></section>', $EOL;

		// Finaliza conexão com o servidor da Base de Dados
		mysqli_close($db_link);
	// Caso não pudera conectar ao servidor da Base de Dados
	} else require_once('db.link.err.echo.section.php');

	// Página inicial padrão
	echo
		'<section id="about">', $EOL,
			'<h1>Sobre o GEPI</h1>', $EOL,
			'<p>Texto a ser inserido.</p>', $EOL,
		'</section>', $EOL
	;

	// Fecha body e html
	require_once('inc.bot.php');
// Se não logado
} else require_once('login.err.php');
