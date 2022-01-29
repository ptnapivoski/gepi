<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Pessoa cujo endereço será modificado
	$id = (int) $_POST['id'];

	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Tenta selecionar endereço da pessoa especificada
		if($db_query_1 = mysqli_query($db_link, "SELECT endereco FROM entidade WHERE id = $id;")){
			// Se selecionou uma linha
			if(mysqli_num_rows($db_query_1) === 1){
				// Recebe dados da consulta
				$db_result_1 = mysqli_fetch_row($db_query_1);
				// Trata dado
				$db_result_1[0] = (int) $db_result_1[0];

				// Insere manipulação de permissões
				require_once('perm.php');

				// Caso possua permissão
				if(perm($db_link, 'permissao_e_entidade', 91, $id) && perm($db_link, 'permissao_e_endereco', 50, $db_result_1[0])){
					// Valida dados vindos do formulário
					$adaptacao_arquitetonica = (int) $_POST['adaptacao_arquitetonica'];

					// Tenta inserir
					if($db_query_2 = mysqli_query($db_link, "INSERT INTO endereco_e_adaptacao_arquitetonica (endereco, adaptacao_arquitetonica) VALUES ($db_result_1[0], $adaptacao_arquitetonica);")){
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
			// Avisa de incorreta seleção
			} else $_SESSION['msg'] = '<p class="error">Não foi possível selecionar o endereço.</p>';
			
			// Limpa a consulta no servidor
			mysqli_free_result($db_query_1);
		// Caso não tenha conseguido realizar a consulta
		} else require_once('db.query.err.php');

		// Fecha a conexão com o DB
		mysqli_close($db_link);
	// Informa que há problema na conexão com o DB
	} else require_once('db.link.err.php');

	// Volta para a página da entidade e na aba adequada
	header("Location:entidade.php?id=$id&tab=5");
// Se não logado
} else require_once('login.err.php');
