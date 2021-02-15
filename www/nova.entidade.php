<?php

// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Inclui começo padrão: abre html e head
	require_once('inc.top.php');
	// Coloca o título do documento
	echo '<title>GEPI: Entidade nova</title>', $EOL;
	// Inclue meio comum: css, jquery, fecha head e abre body
	require_once('inc.mid.php');
	// Coloca JavaScript da página
	echo '<script src="nova.entidade.js"></script>', $EOL;
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
				'<h1>Entidade nova</h1>', $EOL,
					// Começa o formulário
					'<form action="adicionar.entidade.php" method="post">', $EOL
		;

		// Tenta selecionar os tipos de identidade
		if($db_query = mysqli_query($db_link, 'SELECT id, nome FROM tipo_de_entidade ORDER BY id;')){
			// Se selecionou pelo menos um
			if(mysqli_num_rows($db_query)){
				// Inicia o campo select
				echo
					'<p class="select-field">', $EOL,
						'<label>Tipo de entidade: ', $EOL,
							'<select name="tipo_de_entidade" id="tipo-de-entidade-select">', $EOL,
								'<option value="0">Selecione um tipo de entidade</option>', $EOL
				;

				// Para cada um selecionado
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);
					// Imprime
					echo '<option value="', $db_result[0], '">', $db_result[1], '</option>', $EOL;
				}

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
					// Campo do nome
					'<p class="lab">', $EOL,
						'<label>Nome: <input type="text" required="required" name="nome"/></label>', $EOL,
					'</p>', $EOL,
					// Campo do endereço
					'<p class="lab">', $EOL,
						'<label>Endereço: <input type="number" name="endereco" id="endereco" value="0" min="0"/></label> ',
						'<input type="text" readonly="readonly" class="address2" id="endereco-nome" value="Nenhum"/>', $EOL,
					'</p>', $EOL,
					// Botão de submeter
					'<p class="lab">', $EOL,
						'<input type="submit" value="Adicionar"/>', $EOL,
					'</p>', $EOL,
				'</form>', $EOL,
			// Finaliza a seção
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
