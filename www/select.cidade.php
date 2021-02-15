<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Unidade federativa da qual selecionar as cidades
		$uf = (int) $_GET['uf'];

		// Tenta selecionar as cidades da unidade federativa
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM cidade WHERE uf = $uf ORDER BY nome;")){
			// Se selecionou pelo menos uma
			if(mysqli_num_rows($db_query)){
				// Primeira opção vazia
				echo '<option value="0">Selecione uma cidade</option>', $EOL;

				// Para cada uma selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Exibe os valores
					echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
				}
			// Caso tenha selecionado nenhuma
			} else echo '<option value="0">Nenhuma encontrada</option>', $EOL;

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
