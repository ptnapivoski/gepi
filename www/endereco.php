<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Inclui começo padrão: abre html e head
	require_once('inc.top.php');
	// Coloca o título do documento
	echo '<title>GEPI: Endereço</title>', $EOL;
	// Inclue meio comum: css, jquery, fecha head e abre body
	require_once('inc.mid.php');
	// Coloca JavaScript da página
	echo '<script src="endereco.js"></script>', $EOL;
	// Inclue menu
	require_once('inc.menu.php');
	// Inclue mensagem da sessão
	require_once('inc.msg.php');
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Endereço a selecionar
		$id = (int) $_GET['id'];

		// Inicia seção do endereço
		echo
			'<section class="cad">', $EOL,
				'<h1>Endereço</h1>', $EOL
		;

		// Tenta selecionar aquele endereço
		if($db_query_1 = mysqli_query($db_link, "SELECT bai.id, log.id, log.tipo_de_logradouro, cid.id, uf.id, uf.pais, end.numero, end.complemento, end.cep, end.geocodigo, ST_AsText(end.geom) FROM endereco end LEFT JOIN bairro bai ON end.bairro = bai.id LEFT JOIN logradouro log ON end.logradouro = log.id LEFT JOIN cidade cid ON bai.cidade = cid.id LEFT JOIN uf ON cid.uf = uf.id WHERE end.id = $id;")){
			// Se selecionou uma linha
			if(mysqli_num_rows($db_query_1) === 1){
				// Tenta selecionar os paises
				$db_query_2 = mysqli_query($db_link, 'SELECT id, nome FROM pais ORDER BY id;');
				// Tenta selecionar os tipos de logradouro
				$db_query_3 = mysqli_query($db_link, 'SELECT id, nome FROM tipo_de_logradouro ORDER BY id;');

				// Se conseguiu selecionar tudo e pelo menos uma linha para cada consulta
				if($db_query_2 && $db_query_3 && mysqli_num_rows($db_query_2) && mysqli_num_rows($db_query_3)){
					// Recebe os dados da consulta do endereço
					$db_result_1 = mysqli_fetch_row($db_query_1);
					$bairro             = (int) $db_result_1[0];
					$logradouro         = (int) $db_result_1[1];
					$tipo_de_logradouro = (int) $db_result_1[2];
					$cidade             = (int) $db_result_1[3];
					$uf                 = (int) $db_result_1[4];
					$pais               = (int) $db_result_1[5];
					$numero             = (int) $db_result_1[6];
					$complemento        = htmlspecialchars($db_result_1[7]);
					$cep                = htmlspecialchars($db_result_1[8]);
					$geocodigo          = (int) $db_result_1[9];
					$geom               = htmlspecialchars($db_result_1[10]);

					// Inicia o formulário
					echo
						'<form action="alterar.endereco.php" method="post">', $EOL,
							'<p class="lab">', $EOL,
								'<label>ID: <input type="number" name="id" readonly="readonly" value="', $id, '"/></label>', $EOL,
							'</p>', $EOL,
							'<p class="select-field">', $EOL,
								'<label>País: ', $EOL,
									'<select id="pais-select">', $EOL,
										'<option value="0">Selecione um país</option>', $EOL
					;

					// Da consulta dos países, seleciona as linhas
					while($db_result_2 = mysqli_fetch_row($db_query_2)){
						// Valida dados
						$db_result_2[0] = (int) $db_result_2[0];
						$db_result_2[1] = htmlspecialchars($db_result_2[1]);

						// Imprime as opções
						echo '<option value="', $db_result_2[0], '">', $db_result_2[1], '</option>', $EOL;
					}

					// Continua com os outros elementos
					echo
								'</select>', $EOL,
							'</label>', $EOL,
						'</p>', $EOL,
						'<p class="select-field">', $EOL,
							'<label>Unidade federativa: ', $EOL,
								'<select id="uf-select">', $EOL,
									'<option value="0">Selecione um país no campo anterior</option>', $EOL,
								'</select>', $EOL,
							'</label>', $EOL,
						'</p>', $EOL,
						'<p class="select-field">', $EOL,
							'<label>Cidade: ', $EOL,
								'<select id="cidade-select">', $EOL,
									'<option value="0">Selecione um país no campo anterior</option>', $EOL,
								'</select>', $EOL,
							'</label>', $EOL,
						'</p>', $EOL,
						'<p class="select-field">', $EOL,
							'<label>Bairro: ', $EOL,
								'<select id="bairro-select" name="bairro">', $EOL,
									'<option value="0">Selecione um país no campo anterior</option>', $EOL,
								'</select>', $EOL,
							'</label>', $EOL,
						'</p>', $EOL,
						'<p class="select-field">', $EOL,
							'<label>Tipo de logradouro: ', $EOL,
								'<select id="tipo-de-logradouro-select">', $EOL,
									'<option value="0">Selecione um tipo de logradouro</option>', $EOL
					;

					// Da consulta dos tipos de logradouro, seleciona as linhas
					while($db_result_3 = mysqli_fetch_row($db_query_3)){
						// Valida dados
						$db_result_3[0] = (int) $db_result_3[0];
						$db_result_3[1] = htmlspecialchars($db_result_3[1]);

						// Imprime as opções
						echo '<option value="', $db_result_3[0], '">', $db_result_3[1], '</option>', $EOL;
					}

					// Continua com os outros elementos
					echo
									'</select>', $EOL,
								'</label>', $EOL,
							'</p>', $EOL,
							'<p class="select-field">', $EOL,
								'<label for="logradouro-select">Logradouro:</label> ', $EOL,
								'<input type="text" id="filtro-de-nome-de-logradouro" placeholder="Filtro de logradouro" value=""/> ', $EOL,
								'<select id="logradouro-select" name="logradouro">', $EOL,
									'<option value="0">Selecione um país no campo anterior</option>', $EOL,
								'</select>', $EOL,
							'</p>', $EOL,
							'<p class="lab">', $EOL,
								'<label>Número: <input type="number" name="numero" value="', $numero, '" min="0"/></label>', $EOL,
							'</p>', $EOL,
							'<p class="lab">', $EOL,
								'<label>Complemento: <input type="text" name="complemento" value="', $complemento, '"/></label>', $EOL,
							'</p>', $EOL,
							'<p class="lab">', $EOL,
								'<label>CEP: <input type="text" name="cep" value="', $cep, '"/></label>', $EOL,
							'</p>', $EOL,
							'<p class="lab">', $EOL,
								'<label>Geocódigo: <input type="number" name="geocodigo" value="', $geocodigo, '"/></label>', $EOL,
							'</p>', $EOL,
							'<p class="lab">', $EOL,
								'<label>Geom: <input type="text" name="geom" value="', $geom, '"/></label>', $EOL,
							'</p>', $EOL,
							'<p class="lab">', $EOL,
								'<input type="submit" value="Alterar"/>', $EOL,
							'</p>', $EOL,
						'</form>', $EOL,
						// Seleciona os selects pertinentes
						'<script>',
							'$(function(){',
								'$("#pais-select").val(', $pais,');',
								'$("#pais-select").change();',
								'$("#uf-select").val(', $uf,');',
								'$("#uf-select").change();',
								'$("#cidade-select").val(', $cidade,');',
								'$("#cidade-select").change();',
								'$("#bairro-select").val(', $bairro,');',
								'$("#bairro-select").change();',
								'$("#tipo-de-logradouro-select").val(', $tipo_de_logradouro,');',
								'$("#tipo-de-logradouro-select").change();',
								'$("#logradouro-select").val(', $logradouro,');',
								'$("#logradouro-select").change();',
							'});',
						'</script>', $EOL
					;

				// Caso ocorrera um problema nas consultas
				} else echo '<p class="but error">Problema ao consultar a Base de Dados.</p>', $EOL;

				// Limpa do servidor as consultas
				if($db_query_2) mysqli_free_result($db_query_2);
				if($db_query_3) mysqli_free_result($db_query_3);

			// Se não selecionou uma linha
			} else echo '<p class="but error">Endereço não encontrado</p>', $EOL;

			// Limpa a consulta no servidor
			mysqli_free_result($db_query_1);

		// Caso tenha problema na consulta
		} else require('db.query.err.echo.p.php');

		// Finaliza seção
		echo
			'</section>', $EOL,
			// E começa a das entidades vinculadas ao endereço
			'<section class="cad">', $EOL,
				'<h1>Entidades, <a target="_blank" href="nova.entidade.php?endereco=', $id, '">Nova entidade</a></h1>', $EOL
		;

		// Tenta selecionar as entidades daquele endereço
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM entidade WHERE endereco = $id ORDER BY id;")){
			// Se encontrou pelo menos uma
			if(mysqli_num_rows($db_query)){
				// Inicia a tabela
				echo '<table class="but">', $EOL;
				// Para cada linha selecionada
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Cria os formulários para aqueles dados
					echo
						'<tr>', $EOL,
							'<td>', $EOL,
								'<form action="entidade.php" method="get" target="_blank">', $EOL,
									'<input type="number" name="id" readonly="readonly" value="', $db_result[0], '"/> ',
									'<input type="text" class="address" readonly="readonly" value="', $db_result[1], '"/> ',
									'<input type="submit" value="Visualizar"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
							'<td>', $EOL,
								'<form action="excluir.entidade.php" method="post">', $EOL,
									'<input type="hidden" name="id" value="', $db_result[0], '"/>',
									'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir a entidade \\\'', str_replace("'", '\\\'', $db_result[1]), '\\\'?\');"/>', $EOL,
								'</form>', $EOL,
							'</td>', $EOL,
						'</tr>', $EOL
					;
				}
				// Finaliza a tabela
				echo '</table>', $EOL;

			// Se não selecionou nenhuma linha
			} else echo '<p class="but">Nenhuma encontrada</p>', $EOL;

		// Caso tenha problema na consulta
		} else require('db.query.err.echo.p.php');

		// Finaliza a seção
		echo '</section>', $EOL;

		// Fecha a conexão com o servidor da Base de Dados
		mysqli_close($db_link);

	// Caso não tenha conseguido conectar ao servidor de Base de Dados
	} else require_once('db.link.err.echo.section.php');

	// Fecha body e html
	require_once('inc.bot.php');
// Se não logado
} else require_once('login.err.php');
