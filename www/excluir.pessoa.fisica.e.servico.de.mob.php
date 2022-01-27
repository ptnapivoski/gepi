<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Pessoa da qual excluir
	$id = (int) $_POST['id'];

	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_entidade', 104, $id)){
			// Trata entrada
			$servico = (int) $_POST['servico'];

			// Tenta checar se serviço é de mobilidade
			if($db_query = mysqli_query($db_link, "SELECT NULL FROM servico WHERE id = $servico AND tipo_de_servico = 5;")){
				// Se selecionou serviço de mobilidade
				if(mysqli_num_rows($db_query)){
					// Tenta excluir
					if($db_query = mysqli_query($db_link, "DELETE FROM pessoa_fisica_e_servico WHERE pessoa_fisica = $id AND uso = $servico;")){
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
				} else $_SESSION['msg'] = '<p class="error">Serviço não é de mobilidade.</p>';
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// E o inclui na mensagem passada ao usuário
				$_SESSION['msg'] = "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>";
			}
		// Caso não possua permissão
		} else $_SESSION['msg'] = '<p class="error">Você não tem permissão para executar esta ação.</p>';

		// Fecha a conexão com o DB
		mysqli_close($db_link);
	// Informa que há problema na conexão com o DB
	} else require_once('db.link.err.php');

	// Volta para a página da pessoa na aba apropriada
	header("Location:entidade.php?id=$id&tab=6");
// Se não logado
} else require_once('login.err.php');
