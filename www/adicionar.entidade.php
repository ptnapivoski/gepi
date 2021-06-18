<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Página à qual direcionar caso não consiga inserir
	$page = 'nova.entidade.php';

	// Tipo de entidade a inserir
	$tipo_de_entidade = (int) $_POST['tipo_de_entidade'];

	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_tipo_de_entidade', 55, $tipo_de_entidade)){
			// Valida dados vindos do formulário
			$nome = mysqli_real_escape_string($db_link, $_POST['nome']);
			if($nome === '') $nome = 'NULL'; else $nome = "'$nome'";
			$endereco = (int) $_POST['endereco'];
			if($endereco < 1) $endereco = 'NULL';
			if($tipo_de_entidade < 1) $tipo_de_entidade = 'NULL';

			// Tenta inserir
			if($db_query = mysqli_query($db_link, "INSERT INTO entidade (tipo_de_entidade, inserido_por, endereco, nome) VALUES ($tipo_de_entidade, $_SESSION[user], $endereco, $nome);")){
				// Se consulta inseriu uma linha
				if(mysqli_affected_rows($db_link) === 1){
					// Seleciona o ID da linha inserida
					$id = mysqli_insert_id($db_link);
					// Flag de exclusão caso ocorra algum problema
					$problem = TRUE;

					// Se o tipo de entidade for pessoa física
					if($tipo_de_entidade === 1){
						// Tenta inserir linha na tabela de pessoas físicas
						if($db_query = mysqli_query($db_link, "INSERT INTO pessoa_fisica (id) VALUES ($id);")){
							// Se consulta inseriu uma linha
							if(mysqli_affected_rows($db_link) === 1){
								// Ações a adicionar e depois excluir
								$acoes = array(56,57,73,74,75,76,77,78,79,80,81,82,83,84,85,103,104,105,106);
								// Prepara linhas a inserir
								$acoes_q = array();
								foreach($acoes as $val) $acoes_q[] = "($_SESSION[user], TRUE, $val, $id)";
								$acoes_q = implode(',',$acoes_q);

								// Tenta inserir permissões mais específicas
								if($db_query = mysqli_query($db_link, "INSERT INTO permissao_e_entidade VALUES $acoes_q;")){
									// Se consulta inseriu linhas de permissões
									if(mysqli_affected_rows($db_link) === count($acoes)){
										// Prepara linhas a excluir
										$acoes_q = array();
										foreach($acoes as $val) $acoes_q[] = "entidade = $_SESSION[user] AND pode = TRUE AND acao = $val AND com = $id";
										$acoes_q = implode(' OR ',$acoes_q);

										// Tenta inserir evento de exclusão das permissões depois de um dia
										if($db_query = mysqli_query($db_link, "CREATE EVENT del_perms_$id ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 1 DAY ON COMPLETION NOT PRESERVE DO DELETE FROM permissao_e_entidade WHERE $acoes_q;")){
											// Ocorreu tudo bem
											$problem = FALSE;
										// Caso não tenha conseguido realizar a consulta
										} else {
											// Seleciona-se e escapa-se o erro
											$error = htmlspecialchars(mysqli_error($db_link));
											// E o inclui na mensagem passada ao usuário
											$_SESSION['msg'] = "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>";
										}
									// Caso contrário, informa que não houve a inserção
									} else $_SESSION['msg'] = '<p class="error">Inserção não efetuada. Linhas de permissões não inseridas.</p>';
								// Caso não tenha conseguido realizar a consulta
								} else {
									// Seleciona-se e escapa-se o erro
									$error = htmlspecialchars(mysqli_error($db_link));
									// E o inclui na mensagem passada ao usuário
									$_SESSION['msg'] = "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>";
								}
							// Caso contrário, informa que não houve a inserção
							} else $_SESSION['msg'] = '<p class="error">Inserção não efetuada. Linha em pessoa física não inserida.</p>';
						// Caso não tenha conseguido realizar a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							$_SESSION['msg'] = "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>";
						}
					// Pessoa jurídica
					} else if($tipo_de_entidade === 2) $problem = FALSE;
					// Outro
					else {
						// Ações a adicionar
						$acoes = array(56,57,58,59,60,86);
						// Prepara linhas a inserir
						$acoes_q = array();
						foreach($acoes as $val) $acoes_q[] = "($_SESSION[user], TRUE, $val, $id)";
						$acoes_q = implode(',',$acoes_q);

						// Tenta inserir permissões mais específicas
						if($db_query = mysqli_query($db_link, "INSERT INTO permissao_e_entidade VALUES $acoes_q;")){
							// Se consulta inseriu linhas de permissões
							if(mysqli_affected_rows($db_link) === count($acoes)){
								// TODO
								$problem = FALSE;
							// Caso contrário, informa que não houve a inserção
							} else $_SESSION['msg'] = '<p class="error">Inserção não efetuada. Linhas de permissões não inseridas.</p>';
						// Caso não tenha conseguido realizar a consulta
						} else {
							// Seleciona-se e escapa-se o erro
							$error = htmlspecialchars(mysqli_error($db_link));
							// E o inclui na mensagem passada ao usuário
							$_SESSION['msg'] = "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>";
						}
					}

					// Caso tenha ocorrido um problema ao longo da inserção
					if($problem){
						// Executa exclusão do que vinha sendo incluído
						mysqli_query($db_link, "DELETE FROM entidade WHERE id = $id;");
					// Ao conseguir inserir com tudo
					} else {
						// Página para a qual direcionar do recém incluído
						$page = "entidade.php?id=$id";
						// Informa que houve inserção
						$_SESSION['msg'] = '<p class="success">Inserção efetuada.</p>';
					}
				// Caso contrário, informa que não houve a inserção
				} else $_SESSION['msg'] = '<p class="error">Inserção não efetuada. Linha de entidade não inserida.</p>';
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
