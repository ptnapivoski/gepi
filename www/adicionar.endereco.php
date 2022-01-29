<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Página à qual direcionar caso não consiga inserir
	$page = 'novo.endereco.php';

	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_endereco', 49, NULL)){
			// Se formulário foi corretamente postado
			if(isset($_POST['bairro']) && isset($_POST['logradouro']) && isset($_POST['numero']) && isset($_POST['complemento']) && isset($_POST['cep']) && isset($_POST['geocodigo']) && isset($_POST['geom'])){
				// Valida dados vindos do formulário
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

				// Tenta inserir
				if($db_query = mysqli_query($db_link, "INSERT INTO endereco (bairro, logradouro, numero, complemento, cep, geocodigo, geom) VALUES ($bairro, $logradouro, $numero, $complemento, $cep, $geocodigo, $geom);")){
					// Se consulta inseriu uma linha
					if(mysqli_affected_rows($db_link) === 1){
						// Seleciona o ID da linha inserida
						$id = mysqli_insert_id($db_link);
						// Junta com a página de endereço
						$page = "endereco.php?id=$id";
						// Informa que houve inserção
						require_once('ins.suc.php');
						// ID gerado
						$n = mysqli_insert_id($db_link);
						// Insere permissões de alteração e exclusão
						mysqli_query($db_link, "INSERT INTO permissao_e_endereco VALUES ($_SESSION[user], TRUE, 50, $n),($_SESSION[user], TRUE, 51, $n);");
					// Caso contrário, informa que não houve a inserção
					} else require_once('ins.err.php');

				// Caso não tenha conseguido realizar a consulta
				} else require_once('db.query.err.php');
			// Informa que houve erro na postagem do formulário
			} else $_SESSION['msg'] = '<p class="error">Envio incorreto de formulário.</p>';

		// Caso não possua permissão
		} else require_once('perm.err.php');

		// Fecha a conexão com o DB
		mysqli_close($db_link);
	// Informa que há problema na conexão com o DB
	} else require_once('db.link.err.php');

	// Direciona para a página configurada
	header("Location:$page");
// Se não logado
} else require_once('login.err.php');
