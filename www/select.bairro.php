<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Cidade da qual selecionar os bairros
		$cidade = (int) $_GET['cidade'];

		// Tenta selecionar os bairros da cidade
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM bairro WHERE cidade = $cidade ORDER BY nome;")){
			// Se selecionou pelo menos um
			if(mysqli_num_rows($db_query)){
				// Primeira opção vazia
				echo '<option value="0">Selecione um bairro</option>', $EOL;

				// Para cada um selecionado
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Exibe os valores
					echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
				}
			// Caso tenha selecionado nenhum
			} else echo '<option value="0">Nenhum encontrado</option>', $EOL;

			// Limpa os dados da consulta no servidor
			mysqli_free_result($db_query);
		// Se ocorreu um problema na consulta
		} else echo '<option value="0">Erro na consulta com a Base de Dados.</option>', $EOL;

		// Fecha a conexão com o servidor da Base de Dados
		mysqli_close($db_link);
	// Se ocorreu problema ao conectar com o servidor da Base de Dados
	} else require_once('db.link.err.echo.option.php');
// Se não logado, faz nada
} else exit();
