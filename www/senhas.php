<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Inclui começo padrão: abre html e head
	require_once('inc.top.php');
	// Coloca o título do documento
	echo '<title>GEPI: Senhas</title>', $EOL;
	// Inclue meio comum: css, jquery, fecha head e abre body
	require_once('inc.mid.php');
	// Coloca JavaScript da página
	echo '<script src="senhas.js"></script>', $EOL;
	// Inclue menu
	require_once('inc.menu.php');
	// Inclue mensagem da sessão
	require_once('inc.msg.php');
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Inicia formulário para alteração de senha
		echo
			'<section class="cad">', $EOL,
				'<h1>Alterar senha</h1>', $EOL,
				'<form action="alterar.usuario.php" method="post">', $EOL,
					'<p class="lab">',
						'<input type="number" name="id" id="alterar" value="" min="0"/> ',
						'<input type="text" id="alterar-nome" value="" class="name"/>',
					'</p>', $EOL,
					'<p class="lab">',
						'<label>Senha: <input type="password" name="pswd" value=""/></label>',
					'</p>', $EOL,
					'<p class="lab">',
						'<label>Repita senha: <input type="password" name="pswd2" value=""/></label>',
					'</p>', $EOL,
					'<p class="but">',
						'<input type="submit" value="Alterar"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>',
			// Seleciona a entidade logada
			'<script>',
				'$(function(){',
					'$(\'#alterar\').val(', $_SESSION['user'], ');',
					'$(\'#alterar\').change();',
				'});',
			'</script>', $EOL,
			'<section class="cad">', $EOL,
				'<h1>Excluir senha</h1>', $EOL,
				'<form action="excluir.usuario.php" method="post">', $EOL,
					'<p class="lab">',
						'<input type="number" name="id" id="excluir" value="" min="0"/> ',
						'<input type="text" id="excluir-nome" value="" class="name"/>',
					'</p>', $EOL,
					'<p class="but">',
						'<input type="submit" value="Excluir"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>',
			// Seleciona a entidade logada
			'<script>',
				'$(function(){',
					'$(\'#excluir\').val(', $_SESSION['user'], ');',
					'$(\'#excluir\').change();',
				'});',
			'</script>', $EOL
		;

		// Fecha a conexão com o servidor da Base de Dados
		mysqli_close($db_link);
	// Caso não tenha conseguido conectar ao servidor de Base de Dados
	} else require_once('db.link.err.echo.section.php');

	// Fecha body e html
	require_once('inc.bot.php');
// Se não logado
} else require_once('login.err.php');
