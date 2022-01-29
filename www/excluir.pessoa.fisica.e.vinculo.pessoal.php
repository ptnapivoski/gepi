<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Pessoa da qual excluir
	$id = (int) $_POST['id'];
	// Pessoa objetivada no vínculo
	$de = (int) $_POST['de'];

	// Tratamento para voltar para página de pessoa objetivada
	$page = "entidade.php?id=$id&tab=7";
	if(isset($_POST['go-de'])){
		$_POST['go-de'] = (int) $_POST['go-de'];
		if($_POST['go-de'] === 1) $page = "entidade.php?id=$de&tab=7";
	}

	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_entidade', 76, $id) && perm($db_link, 'permissao_e_entidade', 76, $de)){
			// Trata entrada
			$eh = (int) $_POST['eh'];

			// Tenta excluir
			if($db_query = mysqli_query($db_link, "DELETE FROM pessoa_fisica_e_vinculo_pessoal WHERE pessoa_fisica = $id AND eh = $eh AND de = $de;")){
				// Se consulta excluiu uma linha
				if(mysqli_affected_rows($db_link) === 1)
					// Informa que houve a exclusão
					require_once('exc.suc.php');
				// Caso contrário, informa que não houve a exclusão
				else require_once('exc.err.php');
			// Caso não tenha conseguido realizar a consulta
			} else require_once('db.query.err.php');
		// Caso não possua permissão
		} else require_once('perm.err.php');

		// Fecha a conexão com o DB
		mysqli_close($db_link);
	// Informa que há problema na conexão com o DB
	} else require_once('db.link.err.php');

	// Volta para a página da pessoa na aba apropriada
	header("Location:$page");
// Se não logado
} else require_once('login.err.php');
