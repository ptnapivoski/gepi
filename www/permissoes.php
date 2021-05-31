<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Inclui começo padrão: abre html e head
	require_once('inc.top.php');
	// Coloca o título do documento
	echo '<title>GEPI: Permissões</title>', $EOL;
	// Inclue meio comum: css, jquery, fecha head e abre body
	require_once('inc.mid.php');
	// Coloca JavaScript da página
	echo '<script src="permissoes.js"></script>', $EOL;
	// Inclue menu
	require_once('inc.menu.php');
	// Inclue mensagem da sessão
	require_once('inc.msg.php');
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Insere manipulação de permissões
		require_once('perm.php');

		// Caso possua permissão
		if(perm($db_link, 'permissao_e_entidade', 87, NULL)){
			// Exibe permissões sobre entidades
			echo
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre entidades</h1>', $EOL
			;

			// Tenta selecionar as permissões de entidades
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_entidade rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN entidade obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.entidade.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (56,57,58,59,60,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87) ORDER BY id;")){
				// Se retornou ações
				if(mysqli_num_rows($db_query)){
					// Inicia formulário
					echo
						'<form action="adicionar.permissao.e.entidade.php" method="post" class="new">', $EOL,
							'<input type="number" id="entidade-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
							'<input type="text" id="entidade-entidade-nome" value="Qualquer um"/>', $EOL,
							'<select name="pode">', $EOL,
								'<option value="1">Pode</option>', $EOL,
								'<option value="0">Não pode</option>', $EOL,
							'</select>', $EOL,
							'<select name="acao">', $EOL
					;

					// Para cada ação selecionada
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = htmlspecialchars($db_result[1]);
						// Imprime
						echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
					}

					// Campo do objeto
					echo
							'</select>', $EOL,
							'<input type="number" id="entidade-obj-id" value="0" name="obj" min="0"/>', $EOL,
							'<input type="text" id="entidade-obj-nome" value="Qualquer"/>', $EOL,
							'<input type="submit" value="Adicionar"/>', $EOL,
						'</form>', $EOL
					;
				// Caso contrário
				} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre gêneros
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre gêneros</h1>', $EOL
			;

			// Tenta selecionar as permissões de gêneros
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_genero rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN genero obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.genero.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (1,2,3) ORDER BY id;")){
				// Tenta selecionar gêneros
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM genero ORDER BY id;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.genero.php" method="post" class="new">', $EOL,
								'<input type="number" id="genero-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="genero-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Gêneros
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada gênero selecionado
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre estados civis
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre estados civis</h1>', $EOL
			;

			// Tenta selecionar as permissões de estados civis
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_estado_civil rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN estado_civil obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.estado.civil.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (4,5,6) ORDER BY id;")){
				// Tenta selecionar estados civis
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM estado_civil ORDER BY id;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.estado.civil.php" method="post" class="new">', $EOL,
								'<input type="number" id="estado-civil-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="estado-civil-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Estados civis
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada estado civil selecionado
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre diagnósticos
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre diagnósticos</h1>', $EOL
			;

			// Tenta selecionar as permissões de diagnósticos
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto, obj.cid FROM permissao_e_diagnostico rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN diagnostico obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
							else {
								$db_result[8] = htmlspecialchars($db_result[8]);
								if($db_result[8] !== '') $db_result[6] = "($db_result[8]) $db_result[6]";
							}
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.diagnostico.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (7,8,9) ORDER BY id;")){
				// Tenta selecionar diagnósticos
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome, cid FROM diagnostico ORDER BY cid IS NULL, cid, nome;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.diagnostico.php" method="post" class="new">', $EOL,
								'<input type="number" id="diagnostico-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="diagnostico-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Diagnósticos
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada diagnóstico selecionado
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							$db_result[2] = htmlspecialchars($db_result[2]);
							if($db_result[2] !== '') $db_result[1] = "($db_result[2]) $db_result[1]";
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre status de diagnósticos
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre status de diagnóstico</h1>', $EOL
			;

			// Tenta selecionar as permissões de status de diagnóstico
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_status_de_diagnostico rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN status_de_diagnostico obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.status.de.diagnostico.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (10,11,12) ORDER BY id;")){
				// Tenta selecionar status de diagnóstico
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM status_de_diagnostico ORDER BY id;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.status.de.diagnostico.php" method="post" class="new">', $EOL,
								'<input type="number" id="status-de-diagnostico-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="status-de-diagnostico-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Status de diagnóstico
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada status de diagnóstico selecionado
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre escolaridades
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre escolaridades</h1>', $EOL
			;

			// Tenta selecionar as permissões de escolaridades
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_escolaridade rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN escolaridade obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.escolaridade.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (13,14,15) ORDER BY id;")){
				// Tenta selecionar escolaridades
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM escolaridade ORDER BY id;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.escolaridade.php" method="post" class="new">', $EOL,
								'<input type="number" id="escolaridade-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="escolaridade-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Escolaridades
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada escolaridade selecionada
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre séries escolares
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre séries escolares</h1>', $EOL
			;

			// Tenta selecionar as permissões de séries escolares
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_serie_escolar rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN serie_escolar obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.serie.escolar.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (16,17,18) ORDER BY id;")){
				// Tenta selecionar séries escolares
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM serie_escolar ORDER BY id;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.serie.escolar.php" method="post" class="new">', $EOL,
								'<input type="number" id="serie-escolar-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="serie-escolar-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Séries escolares
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada série escolar selecionada
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre turnos escolares
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre turnos escolares</h1>', $EOL
			;

			// Tenta selecionar as permissões de turnos escolares
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_turno_escolar rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN turno_escolar obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.turno.escolar.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (19,20,21) ORDER BY id;")){
				// Tenta selecionar turnos escolares
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM turno_escolar ORDER BY id;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.turno.escolar.php" method="post" class="new">', $EOL,
								'<input type="number" id="turno-escolar-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="turno-escolar-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Turnos escolares
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada turno escolar selecionado
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre raças
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre raças</h1>', $EOL
			;

			// Tenta selecionar as permissões de raças
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_raca rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN raca obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.raca.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (22,23,24) ORDER BY id;")){
				// Tenta selecionar raças
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM raca ORDER BY id;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.raca.php" method="post" class="new">', $EOL,
								'<input type="number" id="raca-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="raca-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Raças
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada raça selecionada
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre benefícios
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre benefícios</h1>', $EOL
			;

			// Tenta selecionar as permissões de benefícios
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_beneficio rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN beneficio obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.beneficio.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (25,26,27) ORDER BY id;")){
				// Tenta selecionar benefícios
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM beneficio ORDER BY id;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.beneficio.php" method="post" class="new">', $EOL,
								'<input type="number" id="beneficio-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="beneficio-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Benefícios
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada benefício selecionado
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre tecnologias
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre tecnologias</h1>', $EOL
			;

			// Tenta selecionar as permissões de tecnologias
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_tecnologia rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN tecnologia obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.tecnologia.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (88,89,90) ORDER BY id;")){
				// Tenta selecionar tecnologias
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM tecnologia ORDER BY id;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.tecnologia.php" method="post" class="new">', $EOL,
								'<input type="number" id="tecnologia-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="tecnologia-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Tecnologias
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada tecnologia selecionada
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre barreiras
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre barreiras</h1>', $EOL
			;

			// Tenta selecionar as permissões de barreiras
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_barreira rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN barreira obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.barreira.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (28,29,30) ORDER BY id;")){
				// Tenta selecionar barreiras
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM barreira ORDER BY id;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.barreira.php" method="post" class="new">', $EOL,
								'<input type="number" id="barreira-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="barreira-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Barreiras
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada barreira selecionada
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre tipos de entidades
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre tipos de entidades</h1>', $EOL
			;

			// Tenta selecionar as permissões de tipos de entidades
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_tipo_de_entidade rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN tipo_de_entidade obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.tipo.de.entidade.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (52,53,54,55) ORDER BY id;")){
				// Tenta selecionar tipos de entidades
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM tipo_de_entidade ORDER BY id;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.tipo.de.entidade.php" method="post" class="new">', $EOL,
								'<input type="number" id="tipo-de-entidade-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="tipo-de-entidade-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Tipo de entidades
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada tipo de entidade selecionado
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre vínculos pessoais
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre vínculos pessoais</h1>', $EOL
			;

			// Tenta selecionar as permissões de vínculos pessoais
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_vinculo_pessoal rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN vinculo_pessoal obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.vinculo.pessoal.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (61,62,63) ORDER BY id;")){
				// Tenta selecionar vínculos pessoais
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM vinculo_pessoal ORDER BY id;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.vinculo.pessoal.php" method="post" class="new">', $EOL,
								'<input type="number" id="vinculo-pessoal-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="vinculo-pessoal-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Vínculos pessoais
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada vínculo pessoal selecionado
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre profissões
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre profissões</h1>', $EOL
			;

			// Tenta selecionar as permissões de profissões
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_profissao rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN profissao obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.profissao.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (64,65,66) ORDER BY id;")){
				// Tenta selecionar profissões
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM profissao ORDER BY id;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.profissao.php" method="post" class="new">', $EOL,
								'<input type="number" id="profissao-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="profissao-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Profissões
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada profissão selecionada
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre medicações
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre medicações</h1>', $EOL
			;

			// Tenta selecionar as permissões de medicações
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_medicacao rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN medicacao obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.medicacao.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (91,92,93) ORDER BY id;")){
				// Tenta selecionar medicações
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM medicacao ORDER BY id;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.medicacao.php" method="post" class="new">', $EOL,
								'<input type="number" id="medicacao-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="medicacao-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Medicações
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada medicação selecionada
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre serviços de assistência social
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre serviços de assistência social</h1>', $EOL
			;

			// Tenta selecionar as permissões de serviços de assistência social
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_servico_de_as rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN servico_de_as obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.servico.de.as.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (67,68,69) ORDER BY id;")){
				// Tenta selecionar serviços de assistência social
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM servico_de_as ORDER BY id;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.servico.de.as.php" method="post" class="new">', $EOL,
								'<input type="number" id="servico-de-as-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="servico-de-as-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Serviços de assistência social
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada serviços de assistência social selecionado
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre serviços de defesa dos direitos das pessoas com deficiência
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre serviços de defesa dos direitos das pessoas com deficiência</h1>', $EOL
			;

			// Tenta selecionar as permissões de serviços de defesa dos direitos das pessoas com deficiência
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_servico_de_ddpd rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN servico_de_ddpd obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.servico.de.ddpd.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (70,71,72) ORDER BY id;")){
				// Tenta selecionar serviços de defesa dos direitos das pessoas com deficiência
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM servico_de_ddpd ORDER BY id;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.servico.de.ddpd.php" method="post" class="new">', $EOL,
								'<input type="number" id="servico-de-ddpd-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="servico-de-ddpd-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Serviços de defesa dos direitos das pessoas com deficiência
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada serviço de defesa dos direitos das pessoas com deficiência
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre tipos de logradouro
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre tipos de logradouro</h1>', $EOL
			;

			// Tenta selecionar as permissões de tipos de logradouro
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_tipo_de_logradouro rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN tipo_de_logradouro obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.tipo.de.logradouro.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (40,41,42) ORDER BY id;")){
				// Tenta selecionar tipos de logradouro
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM tipo_de_logradouro ORDER BY id;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.tipo.de.logradouro.php" method="post" class="new">', $EOL,
								'<input type="number" id="tipo-de-logradouro-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="tipo-de-logradouro-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Tipos de logradouro
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada tipo de logradouro
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre países
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre países</h1>', $EOL
			;

			// Tenta selecionar as permissões de países
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_pais rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN pais obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.pais.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (31,32,33,34) ORDER BY id;")){
				// Tenta selecionar países
				if($db_query_2 = mysqli_query($db_link, "SELECT id, nome FROM pais ORDER BY id;")){
					// Se retornou linhas para as duas consultas
					if(mysqli_num_rows($db_query_1) && mysqli_num_rows($db_query_2)){
						// Inicia formulário
						echo
							'<form action="adicionar.permissao.e.pais.php" method="post" class="new">', $EOL,
								'<input type="number" id="pais-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
								'<input type="text" id="pais-entidade-nome" value="Qualquer um"/>', $EOL,
								'<select name="pode">', $EOL,
									'<option value="1">Pode</option>', $EOL,
									'<option value="0">Não pode</option>', $EOL,
								'</select>', $EOL,
								'<select name="acao">', $EOL
						;

						// Para cada ação selecionada
						while($db_result = mysqli_fetch_row($db_query_1)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Países
						echo
								'</select>', $EOL,
								'<select name="obj">', $EOL,
									'<option value="0">Qualquer</option>', $EOL
						;

						// Para cada país
						while($db_result = mysqli_fetch_row($db_query_2)){
							// Valida dados vindos do DB
							$db_result[0] = (int) $db_result[0];
							$db_result[1] = htmlspecialchars($db_result[1]);
							// Imprime
							echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
						}

						// Fim do formulário
						echo
								'</select>', $EOL,
								'<input type="submit" value="Adicionar"/>', $EOL,
							'</form>', $EOL
						;
					// Caso contrário
					} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

					// Limpa dados no servidor
					mysqli_free_result($db_query_2);
				// Caso não tenha conseguido realizar a consulta
				} else {
					// Seleciona-se e escapa-se o erro
					$error = htmlspecialchars(mysqli_error($db_link));
					// Exibe a mensagem de erro
					echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
				}

				// Limpa dados no servidor
				mysqli_free_result($db_query_1);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre unidades federativas
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre unidades federativas</h1>', $EOL
			;

			// Tenta selecionar as permissões de unidades federativas
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_uf rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN uf obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.uf.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (35,36,37) ORDER BY id;")){
				// Se retornou ações
				if(mysqli_num_rows($db_query)){
					// Inicia formulário
					echo
						'<form action="adicionar.permissao.e.uf.php" method="post" class="new">', $EOL,
							'<input type="number" id="uf-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
							'<input type="text" id="uf-entidade-nome" value="Qualquer um"/>', $EOL,
							'<select name="pode">', $EOL,
								'<option value="1">Pode</option>', $EOL,
								'<option value="0">Não pode</option>', $EOL,
							'</select>', $EOL,
							'<select name="acao">', $EOL
					;

					// Para cada ação selecionada
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = htmlspecialchars($db_result[1]);
						// Imprime
						echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
					}

					// Campo do objeto
					echo
							'</select>', $EOL,
							'<input type="number" id="uf-obj-id" value="0" name="obj" min="0"/>', $EOL,
							'<input type="text" id="uf-obj-nome" value="Qualquer"/>', $EOL,
							'<input type="submit" value="Adicionar"/>', $EOL,
						'</form>', $EOL
					;
				// Caso contrário
				} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre cidades
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre cidades</h1>', $EOL
			;

			// Tenta selecionar as permissões de cidades
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_cidade rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN cidade obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.cidade.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (38,39,43,46) ORDER BY id;")){
				// Se retornou ações
				if(mysqli_num_rows($db_query)){
					// Inicia formulário
					echo
						'<form action="adicionar.permissao.e.cidade.php" method="post" class="new">', $EOL,
							'<input type="number" id="cidade-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
							'<input type="text" id="cidade-entidade-nome" value="Qualquer um"/>', $EOL,
							'<select name="pode">', $EOL,
								'<option value="1">Pode</option>', $EOL,
								'<option value="0">Não pode</option>', $EOL,
							'</select>', $EOL,
							'<select name="acao">', $EOL
					;

					// Para cada ação selecionada
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = htmlspecialchars($db_result[1]);
						// Imprime
						echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
					}

					// Campo do objeto
					echo
							'</select>', $EOL,
							'<input type="number" id="cidade-obj-id" value="0" name="obj" min="0"/>', $EOL,
							'<input type="text" id="cidade-obj-nome" value="Qualquer"/>', $EOL,
							'<input type="submit" value="Adicionar"/>', $EOL,
						'</form>', $EOL
					;
				// Caso contrário
				} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre logradouros
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre logradouros</h1>', $EOL
			;

			// Tenta selecionar as permissões de logradouros
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_logradouro rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN logradouro obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.logradouro.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (44,45) ORDER BY id;")){
				// Se retornou ações
				if(mysqli_num_rows($db_query)){
					// Inicia formulário
					echo
						'<form action="adicionar.permissao.e.logradouro.php" method="post" class="new">', $EOL,
							'<input type="number" id="logradouro-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
							'<input type="text" id="logradouro-entidade-nome" value="Qualquer um"/>', $EOL,
							'<select name="pode">', $EOL,
								'<option value="1">Pode</option>', $EOL,
								'<option value="0">Não pode</option>', $EOL,
							'</select>', $EOL,
							'<select name="acao">', $EOL
					;

					// Para cada ação selecionada
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = htmlspecialchars($db_result[1]);
						// Imprime
						echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
					}

					// Campo do objeto
					echo
							'</select>', $EOL,
							'<input type="number" id="logradouro-obj-id" value="0" name="obj" min="0"/>', $EOL,
							'<input type="text" id="logradouro-obj-nome" value="Qualquer"/>', $EOL,
							'<input type="submit" value="Adicionar"/>', $EOL,
						'</form>', $EOL
					;
				// Caso contrário
				} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre bairros
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre bairros</h1>', $EOL
			;

			// Tenta selecionar as permissões de bairros
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, obj.nome, acao.tem_objeto FROM permissao_e_bairro rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN bairro obj ON obj.id = rel.com ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						// Nome do objeto
						$db_result[7] = (int) $db_result[7];
						if($db_result[7] === 1){
							$db_result[6] = htmlspecialchars($db_result[6]);
							if($db_result[6] === '') $db_result[6] = 'Qualquer';
						} else $db_result[6] = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.bairro.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[6], '" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (47,48) ORDER BY id;")){
				// Se retornou ações
				if(mysqli_num_rows($db_query)){
					// Inicia formulário
					echo
						'<form action="adicionar.permissao.e.bairro.php" method="post" class="new">', $EOL,
							'<input type="number" id="bairro-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
							'<input type="text" id="bairro-entidade-nome" value="Qualquer um"/>', $EOL,
							'<select name="pode">', $EOL,
								'<option value="1">Pode</option>', $EOL,
								'<option value="0">Não pode</option>', $EOL,
							'</select>', $EOL,
							'<select name="acao">', $EOL
					;

					// Para cada ação selecionada
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = htmlspecialchars($db_result[1]);
						// Imprime
						echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
					}

					// Campo do objeto
					echo
							'</select>', $EOL,
							'<input type="number" id="bairro-obj-id" value="0" name="obj" min="0"/>', $EOL,
							'<input type="text" id="bairro-obj-nome" value="Qualquer"/>', $EOL,
							'<input type="submit" value="Adicionar"/>', $EOL,
						'</form>', $EOL
					;
				// Caso contrário
				} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção e exibe permissões sobre endereços
			echo
				'</section>', $EOL,
				'<section class="cad">', $EOL,
					'<h1>Permissões sobre endereços</h1>', $EOL
			;

			// Tenta selecionar as permissões de endereços
			if($db_query = mysqli_query($db_link, "SELECT ent.id, acao.id, obj.id, ent.nome, rel.pode, acao.nome, acao.tem_objeto, bai.nome, tdl.nome, log.nome, obj.numero, obj.complemento FROM permissao_e_endereco rel LEFT JOIN entidade ent ON ent.id = rel.entidade LEFT JOIN acao ON acao.id = rel.acao LEFT JOIN endereco obj ON obj.id = rel.com LEFT JOIN bairro bai ON bai.id = obj.bairro LEFT JOIN logradouro log ON log.id = obj.logradouro LEFT JOIN tipo_de_logradouro tdl ON tdl.id = log.tipo_de_logradouro ORDER BY ent.id, acao.id, obj.id;")){
				// Caso possua linhas da permissão
				if(mysqli_num_rows($db_query)){
					// Para cada linha
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = (int) $db_result[1];
						$db_result[2] = (int) $db_result[2];
						$db_result[3] = htmlspecialchars($db_result[3]);
						if($db_result[3] === '') $db_result[3] = 'Qualquer um';
						$db_result[4] = (int) $db_result[4];
						if($db_result[4] === 1) $db_result[4] = 'Pode'; else $db_result[4] = 'Não pode';
						$db_result[5] = htmlspecialchars($db_result[5]);
						$db_result[6] = (int) $db_result[6];
						// Nome do objeto
						if($db_result[6] === 1){
							if($db_result[2] !== 0){
								$db_result[7] = htmlspecialchars($db_result[7]);
								$db_result[8] = htmlspecialchars($db_result[8]);
								$db_result[9] = htmlspecialchars($db_result[9]);
								$db_result[10] = (int) $db_result[10];
								$db_result[11] = htmlspecialchars($db_result[11]);
								$end = "$db_result[7], $db_result[8] $db_result[9]";
								if($db_result[10]) $end = "$end, $db_result[10]"; else $end = "$end, S/N";
								if($db_result[11]) $end = "$end, $db_result[11]";
							} else $end = 'Qualquer';
						} else $end = '';

						// Imprime linha
						echo
							'<form action="excluir.permissao.e.endereco.php" method="post" class="row">', $EOL,
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>', $EOL,
								'<input type="hidden" name="acao" value="', $db_result[1], '"/>', $EOL,
								'<input type="hidden" name="obj" value="', $db_result[2], '"/>', $EOL,
								'<input type="text" value="', $db_result[3], '" class="name"/>', $EOL,
								'<input type="text" value="', $db_result[4], '" class="short"/>', $EOL,
								'<input type="text" value="', $db_result[5], '" class="name"/>', $EOL,
								'<input type="text" value="', $end,'" class="name"/>', $EOL,
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja exclui esta permissão?\');"/>', $EOL,
							'</form>', $EOL
						;
					}
				// Caso não possua linhas de permissão a exibir
				} else echo '<p>Sem dados a exibir.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Tenta selecionar ações
			if($db_query = mysqli_query($db_link, "SELECT id, nome FROM acao WHERE id IN (49,50,51) ORDER BY id;")){
				// Se retornou ações
				if(mysqli_num_rows($db_query)){
					// Inicia formulário
					echo
						'<form action="adicionar.permissao.e.endereco.php" method="post" class="new">', $EOL,
							'<input type="number" id="endereco-entidade-id" value="0" name="entidade" min="0"/>', $EOL,
							'<input type="text" id="endereco-entidade-nome" value="Qualquer um"/>', $EOL,
							'<select name="pode">', $EOL,
								'<option value="1">Pode</option>', $EOL,
								'<option value="0">Não pode</option>', $EOL,
							'</select>', $EOL,
							'<select name="acao">', $EOL
					;

					// Para cada ação selecionada
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos do DB
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = htmlspecialchars($db_result[1]);
						// Imprime
						echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
					}

					// Campo do objeto
					echo
							'</select>', $EOL,
							'<input type="number" id="endereco-obj-id" value="0" name="obj" min="0"/>', $EOL,
							'<input type="text" id="endereco-obj-nome" value="Qualquer"/>', $EOL,
							'<input type="submit" value="Adicionar"/>', $EOL,
						'</form>', $EOL
					;
				// Caso contrário
				} else echo '<p class="but">Sem possibilidade de inserção.</p>', $EOL;

				// Limpa dados no servidor
				mysqli_free_result($db_query);
			// Caso não tenha conseguido realizar a consulta
			} else {
				// Seleciona-se e escapa-se o erro
				$error = htmlspecialchars(mysqli_error($db_link));
				// Exibe a mensagem de erro
				echo "<p class=\"error but\">Erro na consulta com a Base de Dados: $error.</p>", $EOL;
			}

			// Fim da seção
			echo
				'</section>', $EOL
			;
		// Caso não possua permissão
		} else echo '<section><p class="error">Você não tem permissão para exibir estes dados.</p></section>', $EOL;

		// Finaliza conexão com o servidor da Base de Dados
		mysqli_close($db_link);
	// Caso não pudera conectar ao servidor da Base de Dados
	} else require_once('db.link.err.echo.section.php');

	// Fecha body e html
	require_once('inc.bot.php');
// Se não logado
} else require_once('login.err.php');
