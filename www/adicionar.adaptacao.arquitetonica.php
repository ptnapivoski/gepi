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
		if(perm($db_link, 'permissao_e_adaptacao_arquitetonica', 110, NULL)){
			// Valida dado vindo do formulário
			$nome = mysqli_real_escape_string($db_link, $_POST['nome']);
			if($nome === '') $nome = 'NULL'; else $nome = "'$nome'";

			// Tenta inserir
			if($db_query = mysqli_query($db_link, "INSERT INTO adaptacao_arquitetonica (nome) VALUES ($nome);")){
				// Se consulta inseriu uma linha
				if(mysqli_affected_rows($db_link) === 1){
					// Informa que houve a inserção
					$_SESSION['msg'] = '<p class="success">Inserção efetuada.</p>';
					// ID gerado
					$n = mysqli_insert_id($db_link);
					// Insere permissões de alteração e exclusão
					mysqli_query($db_link, "INSERT INTO permissao_e_barreira VALUES ($_SESSION[user], TRUE, 111, $n),($_SESSION[user], TRUE, 112, $n);");
				// Caso contrário, informa que não houve a inserção
				} else $_SESSION['msg'] = '<p class="error">Inserção não efetuada.</p>';
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

	// Volta para a página dos cadastros
	header('Location:cadastros.php');
// Se não logado
} else require_once('login.err.php');