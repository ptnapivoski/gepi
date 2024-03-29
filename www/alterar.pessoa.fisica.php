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
		if(perm($db_link, 'permissao_e_entidade', 56, $id)){
			// Validação de CPF
			require_once('cpf.php');

			// Testa CPF
			if(strlen($_POST['cpf']) === 0 || cpf($_POST['cpf'])){
				// Valida dado vindo do formulário
				$nascimento = mysqli_real_escape_string($db_link, $_POST['nascimento']);
				if($nascimento === '') $nascimento = 'NULL'; else $nascimento = "'$nascimento'";
				$cpf = mysqli_real_escape_string($db_link, $_POST['cpf']);
				if($cpf === '') $cpf = 'NULL'; else $cpf = "'$cpf'";
				$rg = mysqli_real_escape_string($db_link, $_POST['rg']);
				if($rg === '') $rg = 'NULL'; else $rg = "'$rg'";
				$sus = mysqli_real_escape_string($db_link, $_POST['sus']);
				if($sus === '') $sus = 'NULL'; else $sus = "'$sus'";
				$nis = mysqli_real_escape_string($db_link, $_POST['nis']);
				if($nis === '') $nis = 'NULL'; else $nis = "'$nis'";
				$certidao_de_nascimento = mysqli_real_escape_string($db_link, $_POST['certidao_de_nascimento']);
				if($certidao_de_nascimento === '') $certidao_de_nascimento = 'NULL'; else $certidao_de_nascimento = "'$certidao_de_nascimento'";
				$genero = (int) $_POST['genero'];
				if($genero < 1) $genero = 'NULL';
				$raca = (int) $_POST['raca'];
				if($raca < 1) $raca = 'NULL';
				$estado_civil = (int) $_POST['estado_civil'];
				if($estado_civil < 1) $estado_civil = 'NULL';
				$renda = mysqli_real_escape_string($db_link, $_POST['renda']);
				if($renda === '') $renda = 'NULL'; else $renda = "'$renda'";
				$escolaridade = (int) $_POST['escolaridade'];
				if($escolaridade < 1) $escolaridade = 'NULL';
				$naturalidade = (int) $_POST['naturalidade'];
				if($naturalidade < 1) $naturalidade = 'NULL';

				// Tenta alterar
				if($db_query = mysqli_query($db_link, "UPDATE pessoa_fisica SET nascimento = $nascimento, cpf = $cpf, rg = $rg, sus = $sus, nis = $nis, certidao_de_nascimento = $certidao_de_nascimento, genero = $genero, raca = $raca, estado_civil = $estado_civil, renda = $renda, escolaridade = $escolaridade, naturalidade = $naturalidade WHERE id = $id;")){
					// Se consulta alterou uma linha
					if(mysqli_affected_rows($db_link) === 1)
						// Informa que houve a alteração
						require_once('alter.suc.php');
					// Caso contrário, informa que não houve a alteração
					else require_once('alter.err.php');
				// Caso não tenha conseguido realizar a consulta
				} else require_once('db.query.err.php');
			// Avisa do erro no CPF
			} else $_SESSION['msg'] = '<p class="error">CPF inválido.</p>';
		// Caso não possua permissão
		} else require_once('perm.err.php');

		// Fecha a conexão com o DB
		mysqli_close($db_link);
	// Informa que há problema na conexão com o DB
	} else require_once('db.link.err.php');

	// Volta para a página da entidade
	header("Location:entidade.php?id=$id");
// Se não logado
} else require_once('login.err.php');
