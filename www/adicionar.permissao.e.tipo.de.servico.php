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
			if(in_array($acao, array(98), TRUE)){
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
						if($db_query_inc = mysqli_query($db_link, "INSERT INTO permissao_e_tipo_de_servico VALUES ($entidade,$pode,$acao,$obj);")){
							// Se consulta inseriu uma linha
							if(mysqli_affected_rows($db_link) === 1)
								// Informa que houve a inserção
								$_SESSION['msg'] = '<p class="success">Inserção efetuada.</p>';
							// Caso contrário, informa que não houve a inserção
							else $_SESSION['msg'] = '<p class="error">Inserção não efetuada.</p>';
						// Caso não tenha conseguido realizar a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							$_SESSION['msg'] = "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>";
						}
					} else $_SESSION['msg'] = '<p class="error">Ação inválida.</p>';

					// Limpa consulta do DB
					mysqli_free_result($db_query);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// E o inclui na mensagem passada ao usuário
					$_SESSION['msg'] = "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>";
				}
			// Caso não seja ação válida
			} else $_SESSION['msg'] = '<p class="error">Ação inválida.</p>';
		// Caso não possua permissão
		} else $_SESSION['msg'] = '<p class="error">Você não tem permissão para executar esta ação.</p>';

		// Fecha a conexão com o DB
		mysqli_close($db_link);
	// Informa que há problema na conexão com o DB
	} else require_once('db.link.err.php');

	// Volta para a página das permissões
	header('Location:permissoes.php');
// Se não logado
} else require_once('login.err.php');
