<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// O que alterar
	$id = (int) $_POST['id'];

	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_endereco', 50, $id)){
			// Checa se houve correto preenchimento do formulário
			if(isset($_POST['id']) && isset($_POST['bairro']) && isset($_POST['logradouro']) && isset($_POST['numero']) && isset($_POST['complemento']) && isset($_POST['cep']) && isset($_POST['geocodigo']) && isset($_POST['geom'])){
				// Valida dado vindo do formulário
				$bairro = (int) $_POST['bairro'];
				if($bairro < 1) $bairro = 'NULL';
				$logradouro = (int) $_POST['logradouro'];
				if($logradouro < 1) $logradouro = 'NULL';
				$numero = (int) $_POST['numero'];
				if($numero < 1) $numero = 'NULL';
				$complemento = mysqli_real_escape_string($db_link, $_POST['complemento']);
				if($complemento === '') $complemento = 'NULL'; else $complemento = "'$complemento'";
				$cep = mysqli_real_escape_string($db_link, $_POST['cep']);
				if($cep === '') $cep = 'NULL'; else $cep = "'$cep'";
				$geocodigo = (int) $_POST['geocodigo'];
				if($geocodigo < 1) $geocodigo = 'NULL';
				$geom = mysqli_real_escape_string($db_link, $_POST['geom']);
				if($geom === '') $geom = 'NULL'; else $geom = "ST_GeomFromText('$geom')";

				// Tenta alterar
				if($db_query = mysqli_query($db_link, "UPDATE endereco SET bairro = $bairro, logradouro = $logradouro, numero = $numero, complemento = $complemento, cep = $cep, geocodigo = $geocodigo, geom = $geom WHERE id = $id;")){
					// Se consulta alterou uma linha
					if(mysqli_affected_rows($db_link) === 1)
						// Informa que houve a alteração
						$_SESSION['msg'] = '<p class="success">Alteração efetuada.</p>';
					// Caso contrário, informa que não houve a alteração
					else $_SESSION['msg'] = '<p class="error">Alteração não efetuada.</p>';
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// E o inclui na mensagem passada ao usuário
					$_SESSION['msg'] = "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>";
				}
			// Avisa que houve incorreto preenchimento do formulário
			} else $_SESSION['msg'] = '<p class="error">Envio incorreto de formulário.</p>';

		// Caso não possua permissão
		} else $_SESSION['msg'] = '<p class="error">Você não tem permissão para executar esta ação.</p>';

		// Fecha a conexão com o DB
		mysqli_close($db_link);
	// Informa que há problema na conexão com o DB
	} else require_once('db.link.err.php');

	// Volta para a página do endereço
	header("Location:endereco.php?id=$id");
// Se não logado
} else require_once('login.err.php');
