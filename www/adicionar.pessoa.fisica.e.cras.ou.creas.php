<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Pessoa à qual adicionar uso 
	$id = (int) $_POST['id'];

	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Valida dados vindos do formulário
		$cr = (int) $_POST['cr'];

		// Tenta selecionar tipo de entidade do que veio do formulário
		if($db_query = mysqli_query($db_link, "SELECT tipo_de_entidade FROM entidade WHERE id = $cr;")){
			// Se selecionou um registro
			if(mysqli_num_rows($db_query) === 1){
				// Recebe dados
				$db_result = mysqli_fetch_row($db_query);
				// Trata
				$db_result[0] = (int) $db_result[0];

				// Se CRAS ou CREAS
				if(in_array($db_result[0],array(11,12),TRUE)){
					// Insere manipulação de permissões
					require_once('perm.php');

					// Caso possua permissão
					if(perm($db_link, 'permissao_e_entidade', 72, $id)){
						// Tenta inserir
						if($db_query = mysqli_query($db_link, "INSERT INTO pessoa_fisica_e_cras_ou_creas (pessoa_fisica, uso) VALUES ($id, $cr);")){
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
				// Caso contrário
				} else $_SESSION['msg'] = '<p class="error">Erro ao selecionar CRAS ou CREAS.</p>';
			// Ao selecionar de forma incorreta
			} else $_SESSION['msg'] = '<p class="error">Erro ao selecionar CRAS ou CREAS.</p>';
		// Caso não tenha conseguido realizar a consulta
		} else require_once('db.query.err.php');

		// Fecha a conexão com o DB
		mysqli_close($db_link);
	// Informa que há problema na conexão com o DB
	} else require_once('db.link.err.php');

	// Volta para a página da entidade e na aba adequada
	header("Location:entidade.php?id=$id&tab=3");
// Se não logado
} else require_once('login.err.php');
