<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// O que alterar
	$id = (int) $_POST['id'];

	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_entidade', 56, $id)){
			// Valida dados vindos do formulário
			$tecnologia = (int) $_POST['tecnologia'];

			// Tenta inserir
			if($db_query = mysqli_query($db_link, "INSERT INTO pessoa_fisica_e_tecnologia (pessoa_fisica, tecnologia) VALUES ($id, $tecnologia);")){
				// Se consulta inseriu uma linha
				if(mysqli_affected_rows($db_link) === 1)
					// Informa que houve a inserção
					require_once('ins.suc.php');
				// Caso contrário, informa que não houve a inserção
				else require_once('ins.err.php');
			// Caso não tenha conseguido realizar a consulta
			} else require_once('db.query.err.php');
		// Caso não possua permissão
		} else require_once('perm.err.php');

		// Fecha a conexão com o DB
		mysqli_close($db_link);
	// Informa que há problema na conexão com o DB
	} else require_once('db.link.err.php');

	// Volta para a página da entidade
	header("Location:entidade.php?id=$id");
// Se não logado
} else require_once('login.err.php');
