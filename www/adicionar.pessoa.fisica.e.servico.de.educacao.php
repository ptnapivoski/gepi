<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Pessoa à qual adicionar uso de serviço de educação
	$id = (int) $_POST['id'];

	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_entidade', 76, $id)){
			// Valida dados vindos do formulário
			$servico = (int) $_POST['servico'];

			// Tenta inserir
			if($db_query = mysqli_query($db_link, "INSERT INTO pessoa_fisica_e_servico_de_educacao (pessoa_fisica, uso) VALUES ($id, $servico);")){
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
		// Caso não possua permissão
		} else $_SESSION['msg'] = '<p class="error">Você não tem permissão para executar esta ação.</p>';

		// Fecha a conexão com o DB
		mysqli_close($db_link);
	// Informa que há problema na conexão com o DB
	} else require_once('db.link.err.php');

	// Volta para a página da entidade e na aba adequada
	header("Location:entidade.php?id=$id&tab=2");
// Se não logado
} else require_once('login.err.php');
