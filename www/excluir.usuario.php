<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Página à qual direcionar
	$page = 'senhas.php';

	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// O que excluir
		$id = (int) $_POST['id'];

		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_entidade', 60, $id)){
			// Tenta excluir
			if($db_query = mysqli_query($db_link, "DELETE FROM usuario WHERE id = $id;")){
				// Se consulta excluiu uma linha
				if(mysqli_affected_rows($db_link) === 1){
					// Informa que houve a exclusão
					require_once('exc.suc.php');

					// Caso excluiu o usuário logado
					if($id === $_SESSION['user']) {
						// Deslogar
						$_SESSION['user'] = 0;
						// Direcionar para tela de login
						$page = 'login.form.php';
					}
				// Caso contrário, informa que não houve a exclusão
				} else require_once('exc.err.php');
			// Caso não tenha conseguido realizar a consulta
			} else require_once('db.query.err.php');
		// Caso não possua permissão
		} else require_once('perm.err.php');

		// Fecha a conexão com o DB
		mysqli_close($db_link);
	// Informa que há problema na conexão com o DB
	} else require_once('db.link.err.php');

	// Volta para a página das entidades
	header("Location:$page");
// Se não logado
} else require_once('login.err.php');
