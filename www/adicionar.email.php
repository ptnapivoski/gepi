<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Entidade à qual adicionar o email
	$id = (int) $_POST['id'];

	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_entidade', 56, $id)){
			// Verifica se é realmente email
			if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				// Valida dado vindo do formulário
				$email = mysqli_real_escape_string($db_link, $_POST['email']);
				if($email === '') $email = 'NULL'; else $email = "'$email'";

				// Tenta inserir
				if($db_query = mysqli_query($db_link, "INSERT INTO email (entidade, email) VALUES ($id, $email);")){
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
			// Se o dado passado for inválido, informa
			} else $_SESSION['msg'] = '<p class="error">Email inválido.</p>';

		// Caso não possua permissão
		} else $_SESSION['msg'] = '<p class="error">Você não tem permissão para executar esta ação.</p>';

		// Fecha a conexão com o DB
		mysqli_close($db_link);
	// Informa que há problema na conexão com o DB
	} else require_once('db.link.err.php');

	// Volta para a página da entidade
	header("Location:entidade.php?id=$id");
// Se não logado
} else require_once('login.err.php');
