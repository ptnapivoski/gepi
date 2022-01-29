<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Pessoa da qual alterar
	$id = (int) $_POST['id'];

	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_entidade', 91, $id)){
			// Trata entrada
			$tipo_de_residencia = (int) $_POST['tipo-de-residencia'];
			if($tipo_de_residencia < 1) $tipo_de_residencia = 'NULL';

			// Tenta alterar
			if($db_query = mysqli_query($db_link, "UPDATE pessoa_fisica SET tipo_de_residencia = $tipo_de_residencia WHERE id = $id;")){
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

	// Volta para a página da pessoa na aba apropriada
	header("Location:entidade.php?id=$id&tab=5");
// Se não logado
} else require_once('login.err.php');
