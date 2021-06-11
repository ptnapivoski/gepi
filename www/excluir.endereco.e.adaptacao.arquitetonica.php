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
				if(perm($db_link, 'permissao_e_entidade', 106, $id) && perm($db_link, 'permissao_e_endereco', 50, $db_result_1[0])){
					// Valida dados vindos do formulário
					$adaptacao_arquitetonica = (int) $_POST['adaptacao_arquitetonica'];

					// Tenta excluir
					if($db_query_2 = mysqli_query($db_link, "DELETE FROM endereco_e_adaptacao_arquitetonica WHERE endereco = $db_result_1[0] AND adaptacao_arquitetonica = $adaptacao_arquitetonica;")){
						// Se consulta excluiu uma linha
						if(mysqli_affected_rows($db_link) === 1)
							// Informa que houve a exclusão
							$_SESSION['msg'] = '<p class="success">Exclusão efetuada.</p>';
						// Caso contrário, informa que não houve a exclusão
						else $_SESSION['msg'] = '<p class="error">Exclusão não efetuada.</p>';
					// Caso não tenha conseguido realizar a consulta
					} else {
						// Seleciona-se e escapa-se o erro
						$error = htmlspecialchars(mysqli_error($db_link));
						// E o inclui na mensagem passada ao usuário
						$_SESSION['msg'] = "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>";
					}
				// Caso não possua permissão
				} else $_SESSION['msg'] = '<p class="error">Você não tem permissão para executar esta ação.</p>';
			// Avisa de incorreta seleção
			} else $_SESSION['msg'] = '<p class="error">Uma linha de endereço não selecionada.</p>';
			
			// Limpa a consulta no servidor
			mysqli_free_result($db_query_1);
		// Caso não tenha conseguido realizar a consulta
		} else {
			// Seleciona-se e escapa-se o erro
			$error = htmlspecialchars(mysqli_error($db_link));
			// E o inclui na mensagem passada ao usuário
			$_SESSION['msg'] = "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>";
		}

		// Fecha a conexão com o DB
		mysqli_close($db_link);
	// Informa que há problema na conexão com o DB
	} else require_once('db.link.err.php');

	// Volta para a página da entidade e na aba adequada
	header("Location:entidade.php?id=$id&tab=5");
// Se não logado
} else require_once('login.err.php');
