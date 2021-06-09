<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Inclui começo padrão: abre html e head
	require_once('inc.top.php');
	// Coloca o título do documento
	echo '<title>GEPI: Cadastros</title>', $EOL;
	// Inclue meio comum: css, jquery, fecha head e abre body
	require_once('inc.mid.php');
	// Coloca JavaScript da página
	echo '<script src="cadastros.js"></script>', $EOL;
	// Inclue menu
	require_once('inc.menu.php');
	// Inclue mensagem da sessão
	require_once('inc.msg.php');
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		echo
			// Inicia a seção dos diagnósticos
			'<section class="cad" id="diagnostico-sec">', $EOL,
				'<h1>Diagnósticos</h1>', $EOL
		;

		// Tenta selecionar os diagnósticos
		if($db_query = mysqli_query($db_link, "SELECT id, nome, cid FROM diagnostico ORDER BY nome;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);
					$db_result[2] = htmlspecialchars($db_result[2]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.diagnostico.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="diagnostico-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<label>CID: <input type="text" name="cid" value="', $db_result[2], '"/></label> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#diagnostico-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar o diagnóstico \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.diagnostico.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o diagnóstico \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhum encontrado</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.diagnostico.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Novo: <input type="text" name="nome" id="novo-diagnostico" required="required" value="" /></label> ',
						'<label>CID: <input type="text" name="cid" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#novo-diagnostico\').val()) return confirm(\'Tem certeza que deseja inserir o diagnóstico \\\'\' + $(\'#novo-diagnostico\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção dos logradouros
			'<section class="cad" id="logradouro-sec">', $EOL,
				'<h1>Logradouros</h1>', $EOL,
				// Select dos países
				'<p class="select-field">', $EOL,
					'<label>País:', $EOL,
						'<select id="logradouro-pais-select">', $EOL
		;

		// Tenta selecionar os países
		if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM pais ORDER BY id;")){
			// Se retornou pelo menos uma linha
			if(mysqli_num_rows($db_query_1)){
				// Linha padrão
				echo '<option value="0">Selecione um país</option>', $EOL;

				// Para cada linha
				while($db_result = mysqli_fetch_row($db_query_1)){
					// Valida dados
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Imprime a linha correspondente
					echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
				}
			// Se não retornou pelo menos uma linha
			} else echo '<option value="0">Nenhum país encontrado</option>', $EOL;

			// Limpa consulta no servidor
			mysqli_free_result($db_query_1);
		// Se houve problema na consulta
		} else echo '<option value="0">Problema na consulta com a Base de Dados</option>', $EOL;

		echo
						'</select>', $EOL,
					'</label>', $EOL,
				'</p>', $EOL,
				// Select das unidades federativas
				'<p class="select-field">', $EOL,
					'<label>Unidade federativa:', $EOL,
						'<select id="logradouro-uf-select">', $EOL,
							'<option value="0">Selecione um país no campo anterior</option>', $EOL,
						'</select>', $EOL,
					'</label>', $EOL,
				'</p>', $EOL,
				// Select das cidades
				'<p class="select-field">', $EOL,
					'<label>Cidade:', $EOL,
						'<select id="logradouro-cidade-select">', $EOL,
							'<option value="0">Selecione um país no campo anterior</option>', $EOL,
						'</select>', $EOL,
					'</label>', $EOL,
				'</p>', $EOL,
				// Select dos tipos de logradouro
				'<p class="select-field">', $EOL,
					'<label>Tipo de logradouro:', $EOL,
						'<select id="logradouro-tipo-de-logradouro-select">', $EOL
		;

		// Tenta selecionar os tipos de logradouro
		if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM tipo_de_logradouro ORDER BY id;")){
			// Se retornou pelo menos uma linha
			if(mysqli_num_rows($db_query_1)){
				// Linha padrão
				echo '<option value="0">Selecione um tipo de logradouro</option>', $EOL;

				// Para cada linha
				while($db_result = mysqli_fetch_row($db_query_1)){
					// Valida dados
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Imprime a linha correspondente
					echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
				}
			// Se não retornou pelo menos uma linha
			} else echo '<option value="0">Nenhum tipo de logradouro encontrado</option>', $EOL;

			// Limpa consulta no servidor
			mysqli_free_result($db_query_1);
		// Se houve problema na consulta
		} else echo '<option value="0">Problema na consulta com a Base de Dados</option>', $EOL;

		echo
						'</select>', $EOL,
					'</label>', $EOL,
				'</p>', $EOL,
				// Lugar no qual colocar o conteúdo requisitado via AJAX
				'<div id="logradouro-div"></div>', $EOL,
			'</section>', $EOL,
			// Inicia a seção dos bairros
			'<section class="cad" id="bairro-sec">', $EOL,
				'<h1>Bairros</h1>', $EOL,
				// Select dos países
				'<p class="select-field">', $EOL,
					'<label>País:', $EOL,
						'<select id="bairro-pais-select">', $EOL
		;

		// Tenta selecionar os países
		if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM pais ORDER BY id;")){
			// Se retornou pelo menos uma linha
			if(mysqli_num_rows($db_query_1)){
				// Linha padrão
				echo '<option value="0">Selecione um país</option>', $EOL;

				// Para cada linha
				while($db_result = mysqli_fetch_row($db_query_1)){
					// Valida dados
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Imprime a linha correspondente
					echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
				}
			// Se não retornou pelo menos uma linha
			} else echo '<option value="0">Nenhum país encontrado</option>', $EOL;

			// Limpa consulta no servidor
			mysqli_free_result($db_query_1);
		// Se houve problema na consulta
		} else echo '<option value="0">Problema na consulta com a Base de Dados</option>', $EOL;

		echo
						'</select>', $EOL,
					'</label>', $EOL,
				'</p>', $EOL,
				// Select das unidades federativas
				'<p class="select-field">', $EOL,
					'<label>Unidade federativa:', $EOL,
						'<select id="bairro-uf-select">', $EOL,
							'<option value="0">Selecione um país no campo anterior</option>', $EOL,
						'</select>', $EOL,
					'</label>', $EOL,
				'</p>', $EOL,
				// Select das cidades
				'<p class="select-field">', $EOL,
					'<label>Cidade:', $EOL,
						'<select id="bairro-cidade-select">', $EOL,
							'<option value="0">Selecione um país no campo anterior</option>', $EOL,
						'</select>', $EOL,
					'</label>', $EOL,
				'</p>', $EOL,
				// Lugar no qual colocar o conteúdo requisitado via AJAX
				'<div id="bairro-div"></div>', $EOL,
			'</section>', $EOL,
			// Inicia a seção das cidades
			'<section class="cad" id="cidade-sec">', $EOL,
				'<h1>Cidades</h1>', $EOL,
				// Select dos países
				'<p class="select-field">', $EOL,
					'<label>País:', $EOL,
						'<select id="cidade-pais-select">', $EOL
		;

		// Tenta selecionar os países
		if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM pais ORDER BY id;")){
			// Se retornou pelo menos uma linha
			if(mysqli_num_rows($db_query_1)){
				// Linha padrão
				echo '<option value="0">Selecione um país</option>', $EOL;

				// Para cada linha
				while($db_result = mysqli_fetch_row($db_query_1)){
					// Valida dados
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Imprime a linha correspondente
					echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
				}
			// Se não retornou pelo menos uma linha
			} else echo '<option value="0">Nenhum país encontrado</option>', $EOL;

			// Limpa consulta no servidor
			mysqli_free_result($db_query_1);
		// Se houve problema na consulta
		} else echo '<option value="0">Problema na consulta com a Base de Dados</option>', $EOL;

		echo
						'</select>', $EOL,
					'</label>', $EOL,
				'</p>', $EOL,
				// Select das unidades federativas
				'<p class="select-field">', $EOL,
					'<label>Unidade federativa:', $EOL,
						'<select id="cidade-uf-select">', $EOL,
							'<option value="0">Selecione um país no campo anterior</option>', $EOL,
						'</select>', $EOL,
					'</label>', $EOL,
				'</p>', $EOL,
				// Lugar no qual colocar o conteúdo requisitado via AJAX
				'<div id="cidade-div"></div>', $EOL,
			'</section>', $EOL,
			// Inicia a seção das unidades federativas
			'<section class="cad" id="uf-sec">', $EOL,
				'<h1>Unidades federativas</h1>', $EOL,
				// Select dos países
				'<p class="select-field">', $EOL,
					'<label>País:', $EOL,
						'<select id="uf-pais-select">', $EOL
		;

		// Tenta selecionar os países
		if($db_query_1 = mysqli_query($db_link, "SELECT id, nome FROM pais ORDER BY id;")){
			// Se retornou pelo menos uma linha
			if(mysqli_num_rows($db_query_1)){
				// Linha padrão
				echo '<option value="0">Selecione um país</option>', $EOL;

				// Para cada linha
				while($db_result = mysqli_fetch_row($db_query_1)){
					// Valida dados
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Imprime a linha correspondente
					echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
				}
			// Se não retornou pelo menos uma linha
			} else echo '<option value="0">Nenhum país encontrado</option>', $EOL;

			// Limpa consulta no servidor
			mysqli_free_result($db_query_1);
		// Se houve problema na consulta
		} else echo '<option value="0">Problema na consulta com a Base de Dados</option>', $EOL;

		echo
						'</select>', $EOL,
					'</label>', $EOL,
				'</p>', $EOL,
				// Lugar no qual colocar o conteúdo requisitado via AJAX
				'<div id="uf-div"></div>', $EOL,
			'</section>', $EOL,
			// Inicia a seção dos países
			'<section class="cad" id="pais-sec">', $EOL,
				'<h1>Países</h1>', $EOL
		;

		// Tenta selecionar os países
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM pais ORDER BY id;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.pais.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="pais-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#pais-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar o país \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.pais.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o país \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhum encontrado</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.pais.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Novo: <input type="text" name="nome" id="novo-pais" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#novo-pais\').val()) return confirm(\'Tem certeza que deseja inserir o país \\\'\' + $(\'#novo-pais\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção dos gêneros
			'<section class="cad" id="genero-sec">', $EOL,
				'<h1>Gêneros</h1>', $EOL
		;

		// Tenta selecionar os gêneros
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM genero ORDER BY id;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.genero.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="genero-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#genero-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar o gênero \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.genero.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o gênero \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhum encontrado</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.genero.php" class="new" method="post">', $EOL,
					'<p>',
						'<label>Novo: <input type="text" name="nome" id="novo-genero" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#novo-genero\').val()) return confirm(\'Tem certeza que deseja inserir o gênero \\\'\' + $(\'#novo-genero\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção dos estados civis
			'<section class="cad" id="estado-civil-sec">', $EOL,
				'<h1>Estados civis</h1>', $EOL
		;

		// Tenta selecionar os estados civis
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM estado_civil ORDER BY id;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					$db_result[0] = (int) $db_result[0];
					// Valida os dados vindos
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.estado.civil.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="estado-civil-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#estado-civil-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar o estado civil \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.estado.civil.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o estado civil \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhum encontrado</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.estado.civil.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Novo: <input type="text" name="nome" id="novo-estado-civil" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#novo-estado-civil\').val()) return confirm(\'Tem certeza que deseja inserir o estado civil \\\'\' + $(\'#novo-estado-civil\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção dos status de diagnóstico
			'<section class="cad" id="status-de-diagnostico-sec">', $EOL,
				'<h1>Status de diagnóstico</h1>', $EOL
		;

		// Tenta selecionar os status de diagnóstico
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM status_de_diagnostico ORDER BY id;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.status.de.diagnostico.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="status-de-diagnostico-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#status-de-diagnostico-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar o status de diagnóstico \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.status.de.diagnostico.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o status de diagnóstico \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhum encontrado</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.status.de.diagnostico.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Novo: <input type="text" name="nome" id="novo-status-de-diagnostico" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#novo-status-de-diagnostico\').val()) return confirm(\'Tem certeza que deseja inserir o status de diagnóstico \\\'\' + $(\'#novo-status-de-diagnostico\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção das escolaridades
			'<section class="cad" id="escolaridade-sec">', $EOL,
				'<h1>Escolaridade</h1>', $EOL
		;

		// Tenta selecionar as escolaridades
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM escolaridade ORDER BY id;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.escolaridade.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="escolaridade-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#escolaridade-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar a escolaridade \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.escolaridade.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir a escolaridade \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhuma encontrada</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.escolaridade.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Nova: <input type="text" name="nome" id="nova-escolaridade" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#nova-escolaridade\').val()) return confirm(\'Tem certeza que deseja inserir a escolaridade \\\'\' + $(\'#nova-escolaridade\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção das séries escolares
			'<section class="cad" id="serie-escolar-sec">', $EOL,
				'<h1>Séries escolares</h1>', $EOL
		;

		// Tenta selecionar as séries escolares
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM serie_escolar ORDER BY id;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.serie.escolar.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="serie-escolar-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#serie-escolar-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar a série escolar \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.serie.escolar.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir a série escolar \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhuma encontrada</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.serie.escolar.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Nova: <input type="text" name="nome" id="nova-serie-escolar" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#nova-serie-escolar\').val()) return confirm(\'Tem certeza que deseja inserir a série escolar \\\'\' + $(\'#nova-serie-escolar\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção dos turnos escolares
			'<section class="cad" id="turno-escolar-sec">', $EOL,
				'<h1>Turno escolar</h1>', $EOL
		;

		// Tenta selecionar os turnos escolares
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM turno_escolar ORDER BY id;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.turno.escolar.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="turno-escolar-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#turno-escolar-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar o turno escolar \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.turno.escolar.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o turno escolar \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhum encontrado</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.turno.escolar.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Novo: <input type="text" name="nome" id="novo-turno-escolar" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#novo-turno-escolar\').val()) return confirm(\'Tem certeza que deseja inserir o turno escolar \\\'\' + $(\'#novo-turno-escolar\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção das raças
			'<section class="cad" id="raca-sec">', $EOL,
				'<h1>Raças</h1>', $EOL
		;

		// Tenta selecionar as raças
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM raca ORDER BY id;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.raca.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="raca-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#raca-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar a raça \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.raca.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir a raça \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhuma encontrada</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.raca.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Nova: <input type="text" name="nome" id="nova-raca" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#nova-raca\').val()) return confirm(\'Tem certeza que deseja inserir a raça \\\'\' + $(\'#nova-raca\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção dos benefícios
			'<section class="cad" id="beneficio-sec">', $EOL,
				'<h1>Benefícios</h1>', $EOL
		;

		// Tenta selecionar os benefícios
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM beneficio ORDER BY nome;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.beneficio.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="beneficio-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#beneficio-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar o benefício \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.beneficio.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o benefício \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhum encontrado</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.beneficio.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Novo: <input type="text" name="nome" id="novo-beneficio" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#novo-beneficio\').val()) return confirm(\'Tem certeza que deseja inserir o benefício \\\'\' + $(\'#novo-beneficio\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção das tecnologias
			'<section class="cad" id="tecnologia-sec">', $EOL,
				'<h1>Tecnologias</h1>', $EOL
		;

		// Tenta selecionar as tecnologias
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM tecnologia ORDER BY nome;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.tecnologia.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="tecnologia-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#tecnologia-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar a tecnologia \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.tecnologia.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir a tecnologia \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhuma encontrada</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.tecnologia.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Nova: <input type="text" name="nome" id="nova-tecnologia" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#nova-tecnologia\').val()) return confirm(\'Tem certeza que deseja inserir a tecnologia \\\'\' + $(\'#nova-tecnologia\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção das barreiras
			'<section class="cad" id="barreira-sec">', $EOL,
				'<h1>Barreiras</h1>', $EOL
		;

		// Tenta selecionar as barreiras
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM barreira ORDER BY nome;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.barreira.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="barreira-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#barreira-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar a barreira \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.barreira.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir a barreira \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhuma encontrada</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.barreira.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Nova: <input type="text" name="nome" id="nova-barreira" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#nova-barreira\').val()) return confirm(\'Tem certeza que deseja inserir a barreira \\\'\' + $(\'#nova-barreira\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção das adaptações arquitetônicas
			'<section class="cad" id="adaptacao-arquitetonica-sec">', $EOL,
				'<h1>Adaptações arquitetônicas</h1>', $EOL
		;

		// Tenta selecionar as adaptações arquitetônicas
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM adaptacao_arquitetonica ORDER BY nome;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.adaptacao.arquitetonica.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="adaptacao-arquitetonica-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#adaptacao-arquitetonica-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar a adaptação arquitetônica \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.adaptacao.arquitetonica.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir a adaptação arquitetônica \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhuma encontrada</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.adaptacao.arquitetonica.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Nova: <input type="text" name="nome" id="nova-adaptacao-arquitetonica" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#nova-adaptacao-arquitetonica\').val()) return confirm(\'Tem certeza que deseja inserir a adaptação arquitetônica \\\'\' + $(\'#nova-adaptacao-arquitetonica\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção dos tipos de entidade
			'<section class="cad" id="tipo-de-entidade-sec">', $EOL,
				'<h1>Tipos de entidade</h1>', $EOL
		;

		// Tenta selecionar os tipos de entidade
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM tipo_de_entidade ORDER BY id;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.tipo.de.entidade.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="tipo-de-entidade-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#tipo-de-entidade-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar o tipo de entidade \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.tipo.de.entidade.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o tipo de entidade \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhum encontrado</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.tipo.de.entidade.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Novo: <input type="text" name="nome" id="novo-tipo-de-entidade" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#novo-tipo-de-entidade\').val()) return confirm(\'Tem certeza que deseja inserir o tipo de entidade \\\'\' + $(\'#novo-tipo-de-entidade\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção dos tipos de residência
			'<section class="cad" id="tipo-de-residencia-sec">', $EOL,
				'<h1>Tipos de residência</h1>', $EOL
		;

		// Tenta selecionar os tipos de residência
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM tipo_de_residencia ORDER BY id;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.tipo.de.residencia.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="tipo-de-residencia-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#tipo-de-residencia-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar o tipo de residência \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.tipo.de.residencia.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o tipo de residência \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhum encontrado</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.tipo.de.residencia.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Novo: <input type="text" name="nome" id="novo-tipo-de-residencia" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#novo-tipo-de-residencia\').val()) return confirm(\'Tem certeza que deseja inserir o tipo de residência \\\'\' + $(\'#novo-tipo-de-residencia\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção dos tipos de logradouro
			'<section class="cad" id="tipo-de-logradouro-sec">', $EOL,
				'<h1>Tipos de logradouro</h1>', $EOL
		;

		// Tenta selecionar os tipos de logradouro
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM tipo_de_logradouro ORDER BY id;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.tipo.de.logradouro.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="tipo-de-logradouro-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#tipo-de-logradouro-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar o tipo de logradouro \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.tipo.de.logradouro.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o tipo de logradouro \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhum encontrado</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.tipo.de.logradouro.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Novo: <input type="text" name="nome" id="novo-tipo-de-logradouro" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#novo-tipo-de-logradouro\').val()) return confirm(\'Tem certeza que deseja inserir o tipo de logradouro \\\'\' + $(\'#novo-tipo-de-logradouro\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção dos vínculos pessoais
			'<section class="cad" id="vinculo-pessoal-sec">', $EOL,
				'<h1>Vínculos pessoais</h1>', $EOL
		;

		// Tenta selecionar os vínculos pessoais
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM vinculo_pessoal ORDER BY id;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.vinculo.pessoal.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="vinculo-pessoal-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#vinculo-pessoal-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar o vínculo pessoal \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.vinculo.pessoal.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o vínculo pessoal \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhum encontrado</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.vinculo.pessoal.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Novo: <input type="text" name="nome" id="novo-vinculo-pessoal" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#novo-vinculo-pessoal\').val()) return confirm(\'Tem certeza que deseja inserir o vínculo pessoal \\\'\' + $(\'#novo-vinculo-pessoal\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção das profissões
			'<section class="cad" id="profissao-sec">', $EOL,
				'<h1>Profissões</h1>', $EOL
		;

		// Tenta selecionar as profissões
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM profissao ORDER BY nome;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.profissao.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="profissao-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#profissao-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar a profissão \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.profissao.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir a profissão \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhuma encontrada</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.profissao.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Nova: <input type="text" name="nome" id="nova-profissao" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#nova-profissao\').val()) return confirm(\'Tem certeza que deseja inserir a profissão \\\'\' + $(\'#nova-profissao\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção das medicações
			'<section class="cad" id="medicacao-sec">', $EOL,
				'<h1>Medicações</h1>', $EOL
		;

		// Tenta selecionar as medicações
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM medicacao ORDER BY nome;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.medicacao.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="medicacao-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#medicacao-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar a medicação \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.medicacao.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir a medicação \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhuma encontrada</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.medicacao.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Nova: <input type="text" name="nome" id="nova-medicacao" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#nova-medicacao\').val()) return confirm(\'Tem certeza que deseja inserir a medicação \\\'\' + $(\'#nova-medicacao\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção dos serviços de saúde
			'<section class="cad" id="servico-de-saude-sec">', $EOL,
				'<h1>Serviços de Saúde</h1>', $EOL
		;

		// Tenta selecionar os serviços de saúde
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM servico_de_saude ORDER BY nome;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.servico.de.saude.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="servico-de-saude-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#servico-de-saude-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar o serviço de saúde \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.servico.de.saude.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o serviço de saúde \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhum encontrado</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.servico.de.saude.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Novo: <input type="text" name="nome" id="novo-servico-de-saude" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#novo-servico-de-saude\').val()) return confirm(\'Tem certeza que deseja inserir o serviço de saúde \\\'\' + $(\'#novo-servico-de-saude\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção dos serviços de educação
			'<section class="cad" id="servico-de-educacao-sec">', $EOL,
				'<h1>Serviços de Educação</h1>', $EOL
		;

		// Tenta selecionar os serviços de educação
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM servico_de_educacao ORDER BY nome;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.servico.de.educacao.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="servico-de-educacao-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#servico-de-educacao-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar o serviço de educação \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.servico.de.educacao.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o serviço de educação \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhum encontrado</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.servico.de.educacao.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Novo: <input type="text" name="nome" id="novo-servico-de-educacao" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#novo-servico-de-educacao\').val()) return confirm(\'Tem certeza que deseja inserir o serviço de educação \\\'\' + $(\'#novo-servico-de-educacao\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção dos serviços de assistência social
			'<section class="cad" id="servico-de-as-sec">', $EOL,
				'<h1>Serviços de Assitência Social</h1>', $EOL
		;

		// Tenta selecionar os serviços de assistência social
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM servico_de_as ORDER BY nome;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.servico.de.as.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="servico-de-as-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#servico-de-as-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar o serviço de assistência social \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.servico.de.as.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o serviço de assistência social \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhum encontrado</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.servico.de.as.php" method="post" class="new">', $EOL,
					'<p>',
						'<label>Novo: <input type="text" name="nome" id="novo-servico-de-as" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#novo-servico-de-as\').val()) return confirm(\'Tem certeza que deseja inserir o serviço de assistência social \\\'\' + $(\'#novo-servico-de-as\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção dos serviços de desesa dos direitos das pessoas com deficiência
			'<section class="cad" id="servico-de-ddpd-sec">', $EOL,
				'<h1>Serviços de Defesa dos Direitos das Pessoas com Deficiência</h1>', $EOL
		;

		// Tenta selecionar os serviços de desesa dos direitos das pessoas com deficiência
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM servico_de_ddpd ORDER BY nome;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.servico.de.ddpd.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="servico-de-ddpd-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#servico-de-ddpd-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar o serviço de defesa dos direitos das pessoas com deficiência \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.servico.de.ddpd.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o serviço de defesa dos direitos das pessoas com deficiência \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhum encontrado</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.servico.de.ddpd.php" class="new" method="post">', $EOL,
					'<p>',
						'<label>Novo: <input type="text" name="nome" id="novo-servico-de-ddpd" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#novo-servico-de-ddpd\').val()) return confirm(\'Tem certeza que deseja inserir o serviço de defesa dos direitos das pessoas com deficiência \\\'\' + $(\'#novo-servico-de-ddpd\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			// Inicia a seção dos serviços de mobilidade urbana
			'<section class="cad" id="servico-de-mob-sec">', $EOL,
				'<h1>Serviços de Mobilidade Urbana</h1>', $EOL
		;

		// Tenta selecionar os serviços de mobilidade urbana
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM servico_de_mob ORDER BY nome;")){
			// Se selecionou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table>', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="alterar.servico.de.mob.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="text" name="nome" id="servico-de-mob-', $db_result[0], '" required="required" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Alterar" onclick="if($(\'#servico-de-mob-', $db_result[0], '\').val()) return confirm(\'Tem certeza que deseja alterar o serviço de mobilidade urbana\\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.servico.de.mob.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir o serviço de mobilidade urbana \\\'', str_replace('\'', '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="error">Nenhum encontrado</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query);

		// Caso tenha problema na consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		// Formulário para inserção e finaliza seção
		echo
				'<form action="adicionar.servico.de.mob.php" class="new" method="post">', $EOL,
					'<p>',
						'<label>Novo: <input type="text" name="nome" id="novo-servico-de-mob" required="required" value="" /></label> ',
						'<input type="submit" value="Inserir" onclick="if($(\'#novo-servico-de-mob\').val()) return confirm(\'Tem certeza que deseja inserir o serviço de mobilidade urbana \\\'\' + $(\'#novo-servico-de-mob\').val() + \'\\\'?\');"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL
		;

		// Desconecta do servidor de Base de Dados
		mysqli_close($db_link);

	// Caso não tenha conseguido conectar ao servidor de Base de Dados
	} else require_once('db.link.err.echo.section.php');

	// Fecha body e html
	require_once('inc.bot.php');
// Se não logado
} else require_once('login.err.php');
