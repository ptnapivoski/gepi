<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Cidade da qual selecionar os logradouros
		$cidade = (int) $_GET['cidade'];
		// Tipo de logradouro a selecionar
		$tipo_de_logradouro = (int) $_GET['tipo_de_logradouro'];

		// Tenta selecionar os logradouros
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM logradouro WHERE cidade = $cidade AND tipo_de_logradouro = $tipo_de_logradouro ORDER BY nome;")){
			// Se selecionou pelo menos um
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table class="but">', $EOL;

				// Para cada um selecionado
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Monta os formulários para alteração e exclusão
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.logradouro.php" method="post">', $EOL,
									'<input type="number" name="id" value="', $db_result[0], '" readonly="readonly"/> ',
									'<input type="text" name="nome" id="logradouro-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#logradouro-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar o logradouro \\\'', str_replace("'", '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.logradouro.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o logradouro \\\'', str_replace("'", '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}

				// Termina a tabela
				echo '</table>', $EOL;
			// Caso tenha selecionado nenhum
			} else echo '<p class="but">Nenhum encontrado</p>', $EOL;

			// Limpa os dados da consulta no servidor
			mysqli_free_result($db_query);
		// Se ocorreu um problema na consulta
		} else require_once('db.query.err.echo.p.php');

		// Formulário para inserção de novo logradouro
		echo
			'<form action="adicionar.logradouro.php" method="post" class="new">', $EOL,
				'<p>',
					'<input type="hidden" name="cidade" value="', $cidade, '"/>',
					'<input type="hidden" name="tipo_de_logradouro" value="', $tipo_de_logradouro, '"/>',
					'<label>Novo: <input type="text" name="nome" id="novo-logradouro" required="required" value="" /></label> ',
					'<input type="submit" value="Inserir" onclick="if($(\'#novo-logradouro\').val()) return confirm(\'Tem certeza que deseja inserir o logradouro \\\'\' + $(\'#novo-logradouro\').val() + \'\\\'?\');"/>',
				'</p>', $EOL,
			'</form>', $EOL
		;

		// Fecha conexão com o servidor da Base de Dados
		mysqli_close($db_link);
	// Caso ocorrera problema ao conectar
	} else require_once('db.link.err.echo.p.php');
// Se não logado, faz nada
} else exit();
