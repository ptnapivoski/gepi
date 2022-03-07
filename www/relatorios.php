<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Inclui começo padrão: abre html e head
	require_once('inc.top.php');
	// Coloca o título do documento
	echo '<title>GEPI: Relatórios</title>', $EOL;
	// Inclue meio comum: css, jquery, fecha head e abre body
	require_once('inc.mid.php');
	// Coloca JavaScript da página
	echo '<script src="relatorios.js"></script>', $EOL;
	// Inclue menu
	require_once('inc.menu.php');
	// Inclue mensagem da sessão
	require_once('inc.msg.php');
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		echo
			'<section class="cad">', $EOL,
				'<h1>Diagnósticos e cidade</h1>', $EOL,
				// Formulário
				'<form action="relatorio.1.php" method="post">', $EOL,
					// Select dos países
					'<p class="select-field">', $EOL,
						'<label>País:', $EOL,
							'<select id="rel-1-pais-select">', $EOL
		;

		// Tenta selecionar os países
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM pais ORDER BY id;")){
			// Se retornou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Linha padrão
				echo '<option value="0">Selecione um país</option>', $EOL;

				// Para cada linha
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida dados
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Imprime a linha correspondente
					echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
				}
			// Se não retornou pelo menos uma linha
			} else echo '<option value="0">Nenhum país encontrado</option>', $EOL;

			// Limpa consulta no servidor
			mysqli_free_result($db_query);
		// Se houve problema na consulta
		} else require('db.query.err.echo.option.php');

		echo
							'</select>', $EOL,
						'</label>', $EOL,
					'</p>', $EOL,
					// Select das unidades federativas
					'<p class="select-field">', $EOL,
						'<label>Unidade federativa:', $EOL,
							'<select id="rel-1-uf-select">', $EOL,
								'<option value="0">Selecione um país no campo anterior</option>', $EOL,
							'</select>', $EOL,
						'</label>', $EOL,
					'</p>', $EOL,
					// Select das cidades
					'<p class="select-field">', $EOL,
						'<label>Cidade:', $EOL,
							'<select id="rel-1-cidade-select" name="cidade">', $EOL,
								'<option value="0">Selecione um país no campo anterior</option>', $EOL,
							'</select>', $EOL,
						'</label>', $EOL,
					'</p>', $EOL,
					// Select dos diagnósticos
					'<p class="select-field">', $EOL,
						'<label>Diagnóstico:', $EOL,
							'<select name="diagnostico">', $EOL
		;

		// Tenta selecionar os diagnósticos
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM diagnostico ORDER BY id;")){
			// Se retornou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Linha padrão
				echo '<option value="0">Selecione um diagnóstico</option>', $EOL;

				// Para cada linha
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida dados
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Imprime a linha correspondente
					echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
				}
			// Se não retornou pelo menos uma linha
			} else echo '<option value="0">Nenhum diagnóstico encontrado</option>', $EOL;

			// Limpa consulta no servidor
			mysqli_free_result($db_query);
		// Se houve problema na consulta
		} else require('db.query.err.echo.option.php');

		echo
							'</select>', $EOL,
						'</label>', $EOL,
					'</p>', $EOL,
					'<p><input type="submit" value="Selecionar"/></p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			'<section class="cad">', $EOL,
				'<h1>Tecnologias e cidade</h1>', $EOL,
				// Formulário
				'<form action="relatorio.2.php" method="post">', $EOL,
					// Select dos países
					'<p class="select-field">', $EOL,
						'<label>País:', $EOL,
							'<select id="rel-2-pais-select">', $EOL
		;

		// Tenta selecionar os países
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM pais ORDER BY id;")){
			// Se retornou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Linha padrão
				echo '<option value="0">Selecione um país</option>', $EOL;

				// Para cada linha
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida dados
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Imprime a linha correspondente
					echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
				}
			// Se não retornou pelo menos uma linha
			} else echo '<option value="0">Nenhum país encontrado</option>', $EOL;

			// Limpa consulta no servidor
			mysqli_free_result($db_query);
		// Se houve problema na consulta
		} else require('db.query.err.echo.option.php');

		echo
							'</select>', $EOL,
						'</label>', $EOL,
					'</p>', $EOL,
					// Select das unidades federativas
					'<p class="select-field">', $EOL,
						'<label>Unidade federativa:', $EOL,
							'<select id="rel-2-uf-select">', $EOL,
								'<option value="0">Selecione um país no campo anterior</option>', $EOL,
							'</select>', $EOL,
						'</label>', $EOL,
					'</p>', $EOL,
					// Select das cidades
					'<p class="select-field">', $EOL,
						'<label>Cidade:', $EOL,
							'<select id="rel-2-cidade-select" name="cidade">', $EOL,
								'<option value="0">Selecione um país no campo anterior</option>', $EOL,
							'</select>', $EOL,
						'</label>', $EOL,
					'</p>', $EOL,
					// Select das tecnologias
					'<p class="select-field">', $EOL,
						'<label>Tecnologia:', $EOL,
							'<select name="tecnologia">', $EOL
		;

		// Tenta selecionar as tecnologias
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM tecnologia ORDER BY id;")){
			// Se retornou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Linha padrão
				echo '<option value="0">Selecione uma tecnologia</option>', $EOL;

				// Para cada linha
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida dados
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Imprime a linha correspondente
					echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
				}
			// Se não retornou pelo menos uma linha
			} else echo '<option value="0">Nenhuma tecnologia encontrada</option>', $EOL;

			// Limpa consulta no servidor
			mysqli_free_result($db_query);
		// Se houve problema na consulta
		} else require('db.query.err.echo.option.php');

		echo
							'</select>', $EOL,
						'</label>', $EOL,
					'</p>', $EOL,
					'<p><input type="submit" value="Selecionar"/></p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL,
			'<section class="cad">', $EOL,
				'<h1>Diagnósticos e frequências</h1>', $EOL,
				// Formulário
				'<form action="relatorio.3.php" method="post">', $EOL,
					// Select dos diagnósticos
					'<p class="select-field">', $EOL,
						'<label>Diagnóstico:', $EOL,
							'<select name="diagnostico">', $EOL
		;

		// Tenta selecionar os diagnósticos
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM diagnostico ORDER BY id;")){
			// Se retornou pelo menos uma linha
			if(mysqli_num_rows($db_query)){
				// Linha padrão
				echo '<option value="0">Qualquer</option>', $EOL;

				// Para cada linha
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida dados
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Imprime a linha correspondente
					echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
				}
			// Se não retornou pelo menos uma linha
			} else echo '<option value="0">Nenhum diagnóstico encontrado</option>', $EOL;

			// Limpa consulta no servidor
			mysqli_free_result($db_query);
		// Se houve problema na consulta
		} else require('db.query.err.echo.option.php');

		echo
							'</select>', $EOL,
						'</label>', $EOL,
					'</p>', $EOL,
					'<p class="lab"><label>Ano: <input type="number" name="ano" value="', date('Y') , '" min="0"/></label></p>', $EOL,
					'<p><input type="submit" value="Selecionar"/></p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL
		;

		// Finaliza conexão com o servidor da Base de Dados
		mysqli_close($db_link);
	// Caso não pudera conectar ao servidor da Base de Dados
	} else require_once('db.link.err.echo.section.php');

	// Fecha body e html
	require_once('inc.bot.php');
// Se não logado
} else require_once('login.err.php');
