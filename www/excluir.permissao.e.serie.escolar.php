<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_entidade', 81, NULL)){
			// Valida dados vindos do formulário
			$entidade = (int) $_POST['entidade'];
			if($entidade < 1) $entidade = "IS NULL"; else $entidade = "= $entidade";
			$acao = (int) $_POST['acao'];
			if($acao < 1) $acao = "IS NULL"; else $acao = "= $acao";
			$obj = (int) $_POST['obj'];
			if($obj < 1) $obj = "IS NULL"; else $obj = "= $obj";

			// Tenta excluir
			if($db_query = mysqli_query($db_link, "DELETE FROM permissao_e_serie_escolar WHERE entidade $entidade AND acao $acao AND com $obj;")){
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

	// Volta para a página das permissões
	header('Location:permissoes.php');
// Se não logado
} else require_once('login.err.php');
