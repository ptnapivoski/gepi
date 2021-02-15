<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Inclui começo padrão: abre html e head
	require_once('inc.top.php');
	// Coloca o título do documento
	echo '<title>GEPI: Endereços</title>', $EOL;
	// Inclue meio comum: css, jquery, fecha head e abre body
	require_once('inc.mid.php');
	// Coloca JavaScript da página
	echo '<script src="pesquisar.enderecos.js"></script>', $EOL;
	// Inclue menu
	require_once('inc.menu.php');
	// Inclue mensagem da sessão
	require_once('inc.msg.php');
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		echo
			// Começa a seção
			'<section class="cad">', $EOL,
				// Título e link para formulário de novo endereço
				'<h1>Endereços, <a target="_blank" href="novo.endereco.php">Novo</a></h1>', $EOL,
				// Select do país
				'<p class="select-field">', $EOL,
					'<label>País: ', $EOL,
						'<select id="pais-select">', $EOL
		;

		// Tenta selecionar os países
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM pais ORDER BY id;")){
			// Se selecionou pelo menos um país
			if(mysqli_num_rows($db_query)){
				// Option padrão
				echo '<option value="0">Selecione um país</option>', $EOL;
				// Para cada um selecionado
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida dados vindos
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Os imprime
					echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
				}

			// Caso retornou nenhum
			} else echo '<option value="0">Nenhum país encontrado</option>', $EOL;

		// Caso tenha ocorrido problema se consulta
		} else echo '<option value="0">Erro na consulta com a Base de Dados.</option>', $EOL;

		echo
						'</select>', $EOL,
					'</label>', $EOL,
				'</p>', $EOL,
				// Select das unidades federativas
				'<p class="select-field">', $EOL,
					'<label>Unidade federativa: ', $EOL,
						'<select id="uf-select">', $EOL,
							'<option value="0">Selecione um país no campo anterior</option>', $EOL,
						'</select>', $EOL,
					'</label>', $EOL,
				'</p>', $EOL,
				// Select das cidades
				'<p class="select-field">', $EOL,
					'<label>Cidade: ', $EOL,
						'<select id="cidade-select">', $EOL,
							'<option value="0">Selecione um país no campo anterior</option>', $EOL,
						'</select>', $EOL,
					'</label>', $EOL,
				'</p>', $EOL,
				// Select dos bairros
				'<p class="select-field">', $EOL,
					'<label>Bairro: ', $EOL,
						'<select id="bairro-select">', $EOL,
							'<option value="0">Selecione um país no campo anterior</option>', $EOL,
						'</select>', $EOL,
					'</label>', $EOL,
				'</p>', $EOL,
				// Lugar no qual colocar a requisição AJAX dos endereços
				'<div id="endereco-div"></div>', $EOL,
			'</section>', $EOL
		;

		// Fecha a conexão com o servidor da Base de Dados
		mysqli_close($db_link);

	// Caso não tenha conseguido conectar ao servidor de Base de Dados
	} else require_once('db.link.err.echo.section.php');

	// Fecha body e html
	require_once('inc.bot.php');
// Se não logado
} else require_once('login.err.php');
