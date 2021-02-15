<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Entidade a qual selecionar
		$id = (int) $_GET['id'];

		// Tenta selecionar a entidade
		if($db_query = mysqli_query($db_link, "SELECT nome FROM entidade WHERE id = $id;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Recebe os dados
				$db_result = mysqli_fetch_row($db_query);
				// E os exibe
				echo $db_result[0];
			// Ao não encontrar a entidade
			} else echo 'Entidade inválida';

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);
		// Caso ocorrera uma falha na consulta à Base de Dados
		} else echo 'Erro na consulta com a Base de Dados.';

		// Finaliza a conexão com o servidor da Base de Dados
		mysqli_close($db_link);
	// Caso ocorrera uma falha na conexão com a Base de Dados
	} else require_once('db.link.err.echo.input.php');
// Para usuários não autenticados, não faz nada
} else exit();
