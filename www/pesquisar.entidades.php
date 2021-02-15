<?php
// Inicializa ambiente
require_once('init.php');

// Se logado
if($_SESSION['user']){
	// Inclui começo padrão: abre html e head
	require_once('inc.top.php');
	// Coloca o título do documento
	echo '<title>GEPI: Entidades</title>', $EOL;
	// Inclue meio comum: css, jquery, fecha head e abre body
	require_once('inc.mid.php');
	// Inclue menu
	require_once('inc.menu.php');
	// Inclue mensagem da sessão
	require_once('inc.msg.php');
	// Tenta conectar ao DB
	require_once('db.link.php');

	// Se conectado ao DB
	if($db_link){
		echo
			// Começa primeira seção
			'<section>', $EOL,
				// Título da seção e link para nova entidade
				'<h1>Entidades, <a target="_blank" href="nova.entidade.php">Nova</a></h1>', $EOL,
				// Começa formulário de pesquisa
				'<form action="pesquisar.entidades.php" method="post" class="new">', $EOL,
					// Campo do ID da entidade
					'<p class="lab">',
						'<label>ID: <input type="number" name="id" value="', (isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '0'), '" min="0"/> </label>',
					'</p>', $EOL,
					// Campo do tipo da entidade
					'<p class="select-field">', $EOL,
						'<label>Tipo de entidade: ', $EOL,
							'<select name="tipo_de_entidade">', $EOL
		;

		// Tenta selecionar os tipos de entidade
		if($db_query = mysqli_query($db_link, "SELECT id, nome FROM tipo_de_entidade ORDER BY id;")){
			// Se selecionou pelo menos um tipo de entidade
			if(mysqli_num_rows($db_query)){
				// Tipo qualquer
				echo '<option value="0"', ((isset($_POST['tipo_de_entidade']) && $_POST['id'] === '0') ? ' selected="selected"' : ''), '>Qualquer</option>', $EOL;

				// Para cada um selecionado
				while($db_result = mysqli_fetch_row($db_query)){
					// Valida os dados
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);

					// Opção do tipo da entidade selecionado
					echo '<option value="', $db_result[0], '"', ((isset($_POST['tipo_de_entidade']) && $_POST['tipo_de_entidade'] == $db_result[0]) ? ' selected="selected">' : '>'), $db_result[1], '</option>', $EOL;
				}

			// Caso não existam tipos de entidade
			} else echo '<option value="0">Nenhum encontrado</option>', $EOL;

		// Caso tenha ocorrido um problema com a consulta
		} else echo '<option value="0">Erro na consulta com a Base de Dados</option>', $EOL;

		echo
							'</select>', $EOL,
						'</label>', $EOL,
					'</p>', $EOL,
					'<p class="lab">', $EOL,
						'<label>Nome: <input type="text" name="nome" value="', (isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''), '"/></label>', $EOL,
					'</p>', $EOL,
					'<p class="lab">',
						'<input type="submit" value="Pesquisar"/>',
					'</p>', $EOL,
				'</form>', $EOL,
			'</section>', $EOL
		;

		// Caso ocorrera submissão do formulário
		if(isset($_POST['id']) && isset($_POST['tipo_de_entidade']) && isset($_POST['nome'])){
			// Começa a seção exibindo os resultados
			echo
				'<section>', $EOL,
					'<h1>Resultado</h1>', $EOL
			;

			// Valida os dados vindos do formulário
			$id = (int) $_POST['id'];
			$tipo_de_entidade = (int) $_POST['tipo_de_entidade'];
			$nome = mysqli_real_escape_string($db_link, $_POST['nome']);

			// Se foi pedido por ID da entidade, seleciona apenas ela
			if($id){
				$query = "SELECT id, nome FROM entidade WHERE id = $id;";

			// Para o preenchimento dos outros elementos do formulário
			} else {
				// Começa a array das condições de seleção
				$cond = array();
				// Se fora selecionado o tipo de entidade, adicionar às condições de seleção
				if($tipo_de_entidade) $cond[] = "tipo_de_entidade = $tipo_de_entidade";
				// Se fora preenchido o nome, adicionar às condições de seleção
				if($nome) $cond[] = "nome LIKE '%$nome%'";
				// Junta as condições
				$cond = implode(' AND ', $cond);
				// Começa a consulta
				$query = "SELECT id, nome FROM entidade";
				// Se há condições para seleção, as adiciona
				if($cond) $query = "$query WHERE $cond";
				// Ordena por nome
				$query = "$query ORDER BY nome";
			}

			// Tenta selecionar as entidades
			if($db_query = mysqli_query($db_link, $query)){
				// Se conseguiu selecionar pelo menos uma
				if(mysqli_num_rows($db_query)){
					// Começa a tabela para exibir
					echo '<table class="but">', $EOL;
					// Para cada selecionado
					while($db_result = mysqli_fetch_row($db_query)){
						// Valida dados vindos
						$db_result[0] = (int) $db_result[0];
						$db_result[1] = htmlspecialchars($db_result[1]);

						// Cria o formulário para exibir a entidade
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
					// Termina a tabela
					echo '</table>', $EOL;

				// Caso não tenha conseguido encontrar alguma entidade
				} else echo '<p class="but">Nenhuma encontrada</p>', $EOL;

			// Caso ocorrera um problema na consulta
			} else echo '<p class="error but">Erro na consulta com a Base de Dados.</p>', $EOL;

			// Termina a seção dos resultados
			echo '</section>', $EOL;
		}

		// Fecha a conexão com o servidor da Base de Dados
		mysqli_close($db_link);

	// Caso não tenha conseguido conectar ao servidor de Base de Dados
	} else require_once('db.link.err.echo.section.php');

	// Fecha body e html
	require_once('inc.bot.php');
// Se não logado
} else require_once('login.err.php');
