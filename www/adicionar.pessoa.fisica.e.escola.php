<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Pessoa à qual adicionar histórico escolar
	$id = (int) $_POST['id'];

	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_entidade', 70, $id)){
			// Valida dados vindos do formulário
			$escola     = (int) $_POST['escola'];
			$ano        = (int) $_POST['ano'];
			$serie      = (int) $_POST['serie'];
			$turno      = (int) $_POST['turno'];
			$repetencia = (int) $_POST['repetencia'];

			// Verifica se é escola
			if($db_query = mysqli_query($db_link, "SELECT NULL FROM entidade WHERE id = $escola AND tipo_de_entidade IN (5,6,7,8,9);")){
				// Se é escola
				if(mysqli_num_rows($db_query)){
					// Tenta inserir
					if($db_query_2 = mysqli_query($db_link, "INSERT INTO pessoa_fisica_e_escola (pessoa_fisica, ano, escola, serie_escolar, turno_escolar, repetencia) VALUES ($id, $ano, $escola, $serie, $turno, $repetencia);")){
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
				// Caso não seja escola avisa com erro
				} else $_SESSION['msg'] = '<p class="error">Entidade não é escola.</p>';

				// Limpa consulta no servidor
				mysqli_free_result($db_query);
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

	// Volta para a página da entidade e na aba adequada
	header("Location:entidade.php?id=$id&tab=2");
// Se não logado
} else require_once('login.err.php');
