<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Página à qual direcionar caso não consiga inserir
	$page = 'nova.entidade.php';

	// Tipo de entidade a inserir
	$id = (int) $_POST['tipo_de_entidade'];

	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_tipo_de_entidade', 55, $id)){
			// Valida dados vindos do formulário
			$nome = mysqli_real_escape_string($db_link, $_POST['nome']);
			if($nome === '') $nome = 'NULL'; else $nome = "'$nome'";
			$endereco = (int) $_POST['endereco'];
			if($endereco < 1) $endereco = 'NULL';
			$tipo_de_entidade = (int) $_POST['tipo_de_entidade'];
			if($tipo_de_entidade < 1) $tipo_de_entidade = 'NULL';

			// Tenta inserir
			if($db_query = mysqli_query($db_link, "INSERT INTO entidade (tipo_de_entidade, inserido_por, endereco, nome) VALUES ($tipo_de_entidade, $_SESSION[user], $endereco, $nome);")){
				// Se consulta inseriu uma linha
				if(mysqli_affected_rows($db_link) === 1){
					// Seleciona o ID da linha inserida
					$id = mysqli_insert_id($db_link);

					// Se o tipo de entidade for pessoa física
					if($tipo_de_entidade === 1){
						// Tenta inserir linha na tabela de pessoas físicas
						if($db_query = mysqli_query($db_link, "INSERT INTO pessoa_fisica (id) VALUES ($id);")){
							// Se consulta inseriu uma linha
							if(mysqli_affected_rows($db_link) === 1)
								// Informa que houve inserção
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
					// Caso contrário, só informa que inseriu a entidade
					} else $_SESSION['msg'] = '<p class="success">Inserção efetuada.</p>';

					// Insere permissões de alteração e exclusão
					mysqli_query($db_link, "INSERT INTO permissao_e_entidade VALUES ($_SESSION[user], TRUE, 56, $id),($_SESSION[user], TRUE, 57, $id);");

					$page = "entidade.php?id=$id";
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

	// Direciona para a página configurada
	header("Location:$page");
// Se não logado
} else require_once('login.err.php');
