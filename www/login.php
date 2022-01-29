<?php

// Inicializa ambiente
require_once('init.php');
// Tenta conectar ao DB
require_once('db.link.php');

// Se conectado ao DB
if($db_link){
	// Login a tentar
	$id = (int) $_POST['id'];

	// Tenta consultar a senha daquele ID
	if($db_query = mysqli_query($db_link, "SELECT senha FROM usuario WHERE id = $id;")){
		// Se conseguiu selecionar a senha do ID consultado
		if(mysqli_num_rows($db_query) === 1){
			// Recebe os dados do servidor
			$db_result = mysqli_fetch_row($db_query);

			// Compara com o postado pelo formulário
			if(password_verify($_POST['password'], $db_result[0])){
				// Se válido, altera o usuário da sessão
				$_SESSION['user'] = $id;
				// Direciona para a  página inicial
				header('Location:.');
			// Quando ocorre erro na senha
			} else {
				// Informa que houve erro na autenticação
				$_SESSION['msg'] = '<p class="error">Erro de autenticação.</p>';
				// Direciona ao formulário de login
				header('Location:login.form.php');
			}
		// Caso selecionou nenhuma
		} else {
			// Informa que aquele usuário não existe
			$_SESSION['msg'] = '<p class="error">Este usuário não existe.</p>';
			// Direciona ao formulário de login
			header('Location:login.form.php');
		}

		// Limpa a consulta do servidor
		mysqli_free_result($db_query);
	// Caso ocorrera problema na consulta
	} else {
		// Configura a mensagem
		require_once('db.query.err.php');
		// Direciona ao formulário de login
		header('Location:login.form.php');
	}

	// Desconecta do servidor da Base de Dados
	mysqli_close($db_link);
// Ao não conseguir conectar
} else {
	// Configura a mensagem
	require_once('db.link.err.php');
	// Direciona ao formulário de login
	header('Location:login.form.php');
}
