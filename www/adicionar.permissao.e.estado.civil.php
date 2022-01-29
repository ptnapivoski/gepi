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
			// Recebe ação
			$acao = (int) $_POST['acao'];

			// Se ação válida
			if(in_array($acao, array(4,5,6), TRUE)){
				// Tenta selecionar flag da ação
				if($db_query = mysqli_query($db_link, "SELECT tem_objeto FROM acao WHERE id = $acao;")){
					// Ao selecionar uma linha
					if(mysqli_num_rows($db_query) === 1){
						// Recebe dados do DB
						$db_result = mysqli_fetch_row($db_query);
						$tem_objeto = (int) $db_result[0];

						// Valida dados vindos do formulário
						$entidade = (int) $_POST['entidade'];
						if($entidade < 1) $entidade = 'NULL';
						$pode = (int) $_POST['pode'];
						if($pode === 1) $pode = 'TRUE'; else $pode = 'FALSE';
						if($tem_objeto === 1){
							$obj = (int) $_POST['obj'];
							if($obj < 1) $obj = 'NULL';
						} else $obj = 'NULL';

						// Tenta inserir
						if($db_query_inc = mysqli_query($db_link, "INSERT INTO permissao_e_estado_civil VALUES ($entidade,$pode,$acao,$obj);")){
							// Se consulta inseriu uma linha
							if(mysqli_affected_rows($db_link) === 1)
								// Informa que houve a inserção
								require_once('ins.suc.php');
							// Caso contrário, informa que não houve a inserção
							else require_once('ins.err.php');
						// Caso não tenha conseguido realizar a consulta
						} else require_once('db.query.err.php');
					// Caso não seja ação válida
					} else require_once('acao.inv.php');

					// Limpa consulta do DB
					mysqli_free_result($db_query);
				// Caso não tenha conseguido realizar a consulta
				} else require_once('db.query.err.php');
			// Caso não seja ação válida
			} else require_once('acao.inv.php');
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
