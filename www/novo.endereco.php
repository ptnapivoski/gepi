<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Inclui começo padrão: abre html e head
	require_once('inc.top.php');
	// Coloca o título do documento
	echo '<title>GEPI: Endereço novo</title>', $EOL;
	// Inclue meio comum: css, jquery, fecha head e abre body
	require_once('inc.mid.php');
	// Coloca JavaScript da página
	echo '<script src="novo.endereco.js"></script>', $EOL;
	// Inclue menu
	require_once('inc.menu.php');
	// Inclue mensagem da sessão
	require_once('inc.msg.php');
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		// Começa a seção
		echo
			'<section class="cad">', $EOL,
				// Título da seção
				'<h1>Endereço novo</h1>', $EOL,
				// Começa o formulário de inserção
				'<form action="adicionar.endereco.php" method="post">', $EOL
		;

		// Tenta selecionar os países
		if($db_query = mysqli_query($db_link, 'SELECT id, nome FROM pais ORDER BY id;')){
			// Se selecionou pelo menos um
			if(mysqli_num_rows($db_query)){
				// Inicia o campo select
				echo
					'<p class="select-field">', $EOL,
						'<label>País: ', $EOL,
							'<select id="pais-select">', $EOL,
								'<option value="0">Selecione um país</option>', $EOL
				;

				// Para cada um selecionado
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);
					// Imprime
					echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
				}

				// Termina o campo
				echo
							'</select>', $EOL,
						'</label>', $EOL,
					'</p>', $EOL
				;
			// Caso não tenha selecionado algum
			} else echo '<p class="error">Base de dados inconsistente.</p>', $EOL;
		// Caso ocorrera um problema com a consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		echo
			// Select da unidade federativa
			'<p class="select-field">', $EOL,
				'<label>Unidade federativa: ', $EOL,
					'<select id="uf-select">', $EOL,
						'<option value="0">Selecione um país no campo anterior</option>', $EOL,
					'</select>', $EOL,
				'</label>', $EOL,
			'</p>', $EOL,
			// Select da cidade
			'<p class="select-field">', $EOL,
				'<label>Cidade: ', $EOL,
					'<select id="cidade-select">', $EOL,
						'<option value="0">Selecione um país no campo anterior</option>', $EOL,
					'</select>', $EOL,
				'</label>', $EOL,
			'</p>', $EOL,
			// Select do bairro
			'<p class="select-field">', $EOL,
				'<label>Bairro: ', $EOL,
					'<select id="bairro-select" name="bairro">', $EOL,
						'<option value="0">Selecione um país no campo anterior</option>', $EOL,
					'</select>', $EOL,
				'</label> <a href="cadastros.php#bairro-sec" target="_blank">Editar</a>, <a href="javascript:update_bairro();">Atualizar</a>', $EOL,
			'</p>', $EOL
		;

		// Tenta selecionar os tipos de logradouro
		if($db_query = mysqli_query($db_link, 'SELECT id, nome FROM tipo_de_logradouro ORDER BY id;')){
			// Se selecionou pelo menos um
			if(mysqli_num_rows($db_query)){
				// Inicia o campo select
				echo
					'<p class="select-field">', $EOL,
						'<label>Tipo de logradouro: ', $EOL,
							'<select id="tipo-de-logradouro-select">', $EOL,
								'<option value="0">Selecione um tipo de logradouro</option>', $EOL
				;

				// Para cada um selecionado
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);
					// Imprime
					echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
				}

				// Termina o campo
				echo
							'</select>', $EOL,
						'</label>', $EOL,
					'</p>', $EOL
				;
			// Caso não tenha selecionado algum
			} else echo '<p class="error">Base de dados inconsistente.</p>', $EOL;
		// Caso ocorrera um problema com a consulta
		} else echo '<p class="error">Erro na consulta com a Base de Dados.</p>', $EOL;

		echo
					// Campo do logradouro
					'<p class="select-field">', $EOL,
						'<label for="logradouro-select">Logradouro:</label> ', $EOL,
						'<input type="text" id="filtro-de-nome-de-logradouro" placeholder="Filtro de logradouro" value=""/> ', $EOL,
						'<select id="logradouro-select" name="logradouro">', $EOL,
							'<option value="0">Selecione um tipo de logradouro no campo anterior</option>', $EOL,
						'</select>', $EOL,
						'<a href="cadastros.php#logradouro-sec" target="_blank">Editar</a>, <a href="javascript:update_logradouro();">Atualizar</a>', $EOL,
					'</p>', $EOL,
					// Campo do número
					'<p class="lab">', $EOL,
						'<label>Número: <input type="number" name="numero"/></label>', $EOL,
					'</p>', $EOL,
					// Campo do complemento
					'<p class="lab">', $EOL,
						'<label>Complemento: <input type="text" name="complemento"/></label>', $EOL,
					'</p>', $EOL,
					// Campo do CEP
					'<p class="lab">', $EOL,
						'<label>CEP: <input type="text" name="cep"/></label>', $EOL,
					'</p>', $EOL,
					// Campo do geocódigo
					'<p class="lab">', $EOL,
						'<label>Geocódigo: <input type="number" name="geocodigo"/></label>', $EOL,
					'</p>', $EOL,
					// Campo da geometria
					'<p class="lab">', $EOL,
						'<label>Geom: <input type="text" name="geom"/></label>', $EOL,
					'</p>', $EOL,
					// Botão de submissão
					'<p class="lab">', $EOL,
						'<input type="submit" value="Adicionar"/>', $EOL,
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
