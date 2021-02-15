<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Bairro do qual selecionar os endereços
		$bairro = (int) $_GET['bairro'];

		// Tenta selecionar os endereços daquele bairro
		if($db_query = mysqli_query($db_link, "SELECT end.id, tdl.nome tdl, log.nome log, end.numero num, end.complemento comp FROM endereco end LEFT JOIN logradouro log ON end.logradouro = log.id LEFT JOIN tipo_de_logradouro tdl ON log.tipo_de_logradouro = tdl.id WHERE end.bairro = $bairro ORDER BY tdl, log;")){
			// Se selecionou pelo menos um
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table class="but">', $EOL;

				// Para cada um selecionado
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$id                 = (int) $db_result[0];
					$tipo_de_logradouro = htmlspecialchars($db_result[1]);
					$logradouro         = htmlspecialchars($db_result[2]);
					$numero             = (int) $db_result[3];
					$complemento        = htmlspecialchars($db_result[4]);
					// Os concatena
					$nome               = "$tipo_de_logradouro $logradouro";
					if($numero)      $nome = "$nome, $numero"; else $nome = "$nome, S/N";
					if($complemento) $nome = "$nome, $complemento";

					// Monta os formulários para visualização e exclusão
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="endereco.php" method="get" target="_blank">', $EOL,
									'<input type="number" name="id" readonly="readonly" value="', $id, '"/> ',
									'<input type="text" class="address" readonly="readonly" value="', $nome, '"/> ',
									'<input type="submit" value="Visualizar"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.endereco.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $id, '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o endereço \\\'', str_replace("'", '\\\'', $nome), '\\\'?\');"/>', $EOL,
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
		} else echo '<p class="error but">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Fecha conexão com o servidor da Base de Dados
		mysqli_close($db_link);
	// Caso ocorrera problema ao conectar
	} else require_once('db.link.err.echo.p.php');
// Se não logado, faz nada
} else exit();
