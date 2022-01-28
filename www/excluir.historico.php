<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Trata entrada do que excluir
	$entidade = (int) $_POST['entidade'];
	$sobre = (int) $_POST['sobre'];
	$sec = (int) $_POST['sec'];

	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_entidade', 79, $sobre) && perm($db_link, 'permissao_e_entidade', 80, $entidade)){
			// Escapa data
			$quando = mysqli_real_escape_string($db_link, $_POST['quando']);

			// Tenta selecionar o arquivo anexo
			if($db_query = mysqli_query($db_link, "SELECT arquivo FROM historico WHERE entidade = $entidade AND sobre = $sobre AND quando = '$quando';")){
				// Caso tenha conseguido selecionar o arquivo do histórico
				if(mysqli_num_rows($db_query)){
					// Busca dados pedidos pela consulta
					$db_result = mysqli_fetch_row($db_query);
					// Critério de continuar excluindo histórico
					$ok = TRUE;
					// Se há arquivo a excluir
					if($db_result[0] !== NULL){
						// Se arquivo for de um único histórico
						if(mysqli_num_rows(mysqli_query($db_link, "SELECT NULL FROM historico WHERE arquivo = '$db_result[0]';")) === 1){
							// Lugar e nome do arquivo
							$file = "$FDIR/$db_result[0]";
							// Caso exista arquivo do histórico
							if(file_exists($file)){
								// Tenta excluir arquivo
								if(!unlink($file))
									// Caso ocorra erro, nem tenta excluir o histórico do DB
									$ok = FALSE;
							// Caso não exista o arquivo do histórico
							} else $ok = FALSE;
						}
					}
					// Caso possa continuar excluindo histórico do DB
					if($ok){
						// Tenta excluir o histórico
						if($db_query_rem = mysqli_query($db_link, "DELETE FROM historico WHERE entidade = $entidade AND sobre = $sobre AND quando = '$quando';")){
							// Se consulta excluiu uma linha
							if(mysqli_affected_rows($db_link) === 1)
								// Informa que houve a exclusão
								$_SESSION['msg'] = '<p class="success">Exclusão efetuada.</p>';
							// Caso contrário, informa que não houve a exclusão
							else $_SESSION['msg'] = '<p class="error">Exclusão não efetuada.</p>';
						// Caso não tenha conseguido realizar a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							$_SESSION['msg'] = "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>";
						}
					// Avisa que não conseguiu excluir
					} else $_SESSION['msg'] = '<p class="error">Não foi possível excluir o arquivo do histórico.</p>';
				// Caso contrário, mostra erro
				} else $_SESSION['msg'] = '<p class="error">Histórico não entontrado.</p>';

				// Limpa consulta no DB
				mysqli_free_result($db_query);
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

	// Abra para a qual retornar
	if($sec >= 1 && $sec <= 6) $tab = $sec; else $tab = 8;

	// Volta para a página da entidade na aba dos históricos
	header("Location:entidade.php?id=$sobre&tab=$tab");
// Se não logado
} else require_once('login.err.php');
