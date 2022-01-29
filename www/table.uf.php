<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// País do qual selecionar as unidade federativas
		$pais = (int) $_GET['pais'];

		// Tenta selecionar as unidades federativas do país
		if($db_query = mysqli_query($db_link, "SELECT id, nome, sigla FROM uf WHERE pais = $pais ORDER BY nome;")){
			// Se selecionou pelo menos uma
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table class="but">', $EOL;

				// Para cada uma selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);
					$db_result[2] = htmlspecialchars($db_result[2]);

					// Exibe o formulário para alteração e exclusão
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.uf.php" method="post">', $EOL,
									'<input type="number" name="id" value="', $db_result[0], '" readonly="readonly"/> ',
									'<input type="text" name="nome" id="uf-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<label>Sigla: <input type="text" name="sigla" value="', $db_result[2], '"/></label> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#uf-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar a unidade federativa \\\'', str_replace("'", '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.uf.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir a unidade federativa \\\'', str_replace("'", '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}

				// Termina a tabela
				echo '</table>', $EOL;
			// Caso tenha selecionado nenhuma
			} else echo '<p class="but">Nenhuma encontrada</p>', $EOL;

			// Limpa os dados da consulta no servidor
			mysqli_free_result($db_query);
		// Se ocorreu um problema na consulta
		} else require_once('db.query.err.echo.p.php');

		// Formulário para inserção de nova unidade federativa
		echo
			'<form action="adicionar.uf.php" method="post" class="new">', $EOL,
				'<p>',
					'<input type="hidden" name="pais" value="', $pais, '"/>',
					'<label>Nova: <input type="text" name="nome" id="nova-uf" required="required" value="" /></label> ',
					'<label>Sigla: <input type="text" name="sigla" value="" /></label> ',
					'<input type="submit" value="Inserir" onclick="if($(\'#nova-uf\').val()) return confirm(\'Tem certeza que deseja inserir a unidade federativa \\\'\' + $(\'#nova-uf\').val() + \'\\\'?\');"/>',
				'</p>', $EOL,
			'</form>', $EOL
		;

		// Fecha conexão com o servidor da Base de Dados
		mysqli_close($db_link);
	// Caso ocorrera problema ao conectar
	} else require_once('db.link.err.echo.p.php');
// Se não logado, faz nada
} else exit();
