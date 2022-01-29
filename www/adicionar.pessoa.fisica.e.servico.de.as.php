<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Pessoa à qual adicionar uso de serviço de assistência social
	$id = (int) $_POST['id'];

	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_entidade', 72, $id)){
			// Valida dados vindos do formulário
			$servico = (int) $_POST['servico'];

			// Tenta checar se serviço é de assistência social
			if($db_query = mysqli_query($db_link, "SELECT NULL FROM servico WHERE id = $servico AND tipo_de_servico = 1;")){
				// Se selecionou serviço de assistência social
				if(mysqli_num_rows($db_query)){
					// Tenta inserir
					if($db_query = mysqli_query($db_link, "INSERT INTO pessoa_fisica_e_servico (pessoa_fisica, uso) VALUES ($id, $servico);")){
						// Se consulta inseriu uma linha
						if(mysqli_affected_rows($db_link) === 1)
							// Informa que houve a inserção
							require_once('ins.suc.php');
						// Caso contrário, informa que não houve a inserção
						else require_once('ins.err.php');
					// Caso não tenha conseguido realizar a consulta
					} else require_once('db.query.err.php');
				} else $_SESSION['msg'] = '<p class="error">Serviço não é de assistência social.</p>';
			// Caso não tenha conseguido realizar a consulta
			} else require_once('db.query.err.php');
		// Caso não possua permissão
		} else require_once('perm.err.php');

		// Fecha a conexão com o DB
		mysqli_close($db_link);
	// Informa que há problema na conexão com o DB
	} else require_once('db.link.err.php');

	// Volta para a página da entidade e na aba adequada
	header("Location:entidade.php?id=$id&tab=3");
// Se não logado
} else require_once('login.err.php');
