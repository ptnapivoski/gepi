<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// O que alterar
		$id = (int) $_POST['id'];

		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_serie_escolar', 17, $id)){
			// Valida dado vindo do formulário
			$nome = mysqli_real_escape_string($db_link, $_POST['nome']);
			if($nome === '') $nome = 'NULL'; else $nome = "'$nome'";

			// Tenta alterar
			if($db_query = mysqli_query($db_link, "UPDATE serie_escolar SET nome = $nome WHERE id = $id;")){
				// Se consulta alterou uma linha
				if(mysqli_affected_rows($db_link) === 1)
					// Informa que houve a alteração
					require_once('alter.suc.php');
				// Caso contrário, informa que não houve a alteração
				else require_once('alter.err.php');
			// Caso não tenha conseguido realizar a consulta
			} else require_once('db.query.err.php');
		// Caso não possua permissão
		} else require_once('perm.err.php');

		// Fecha a conexão com o DB
		mysqli_close($db_link);
	// Informa que há problema na conexão com o DB
	} else require_once('db.link.err.php');

	// Volta para a página dos cadastros
	header('Location:cadastros.php');
// Se não logado
} else require_once('login.err.php');
