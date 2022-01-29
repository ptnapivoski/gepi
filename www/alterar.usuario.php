<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// O que alterar
	$id = (int) $_POST['id'];

	// Página padrão para direcionar
	$page = 'senhas.php';

	// Valida formulário
	if(isset($_POST['pswd']) && isset($_POST['pswd2']) && $_POST['pswd'] !== '' && $_POST['pswd2'] !== '' && $_POST['pswd'] === $_POST['pswd2']){
		// Tenta conectar ao DB
		require_once('db.link.php');

		// Se conectado ao DB
		if($db_link){
			// Valida dados vindos do formulário
			$pswd = password_hash($_POST['pswd'], PASSWORD_DEFAULT);

			// Checa se há senha para a entidade
			if($db_query = mysqli_query($db_link, "SELECT NULL FROM usuario WHERE id = $id;")){
				// Insere manipulação de permissões
				require_once('perm.php');

				// Se houver, deve alterar
				if(mysqli_num_rows($db_query) === 1){
					// Se tem permissão
					if(perm($db_link, 'permissao_e_entidade', 59, $id)){
						// Tenta alterar
						if($db_query_2 = mysqli_query($db_link, "UPDATE usuario SET senha = '$pswd' WHERE id = $id;")){
							// Se consulta alterou uma linha
							if(mysqli_affected_rows($db_link) === 1){
								// Informa que houve a alteração
								require_once('alter.suc.php');

								// Caso alterou o usuário logado
								if($id === $_SESSION['user']) {
									// Deslogar
									$_SESSION['user'] = 0;
									// Direcionar para tela de login
									$page = 'login.form.php';
								}
							// Caso contrário, informa que não houve a alteração
							} else require_once('alter.err.php');
						// Caso não tenha conseguido realizar a consulta
						} else require_once('db.query.err.php');
					// Caso não possua permissão
					} else require_once('perm.err.php');
				// Se não houver, deve adicionar
				} else {
					// Se tem permissão
					if(perm($db_link, 'permissao_e_entidade', 58, $id)){
						// Tenta inserir
						if($db_query_2 = mysqli_query($db_link, "INSERT INTO usuario (id, senha) VALUES ($id, '$pswd');")){
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
				}

				// Limpa a consulta no DB
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else require_once('db.query.err.php');

			// Fecha a conexão com o DB
			mysqli_close($db_link);
		// Informa que há problema na conexão com o DB
		} else require_once('db.link.err.php');
	// Preenchimento  incorreto do formulário
	} else $_SESSION['msg'] = '<p class="error">Formulário incorretamente preenchido.</p>';

	// Volta para a página da entidade
	header("Location:$page");
// Se não logado
} else require_once('login.err.php');
