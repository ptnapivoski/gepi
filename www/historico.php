<?php

function historico($db_link, $sec){
	global $id, $FMS, $FDIR, $EOL;

	$sec = (int) $sec;

	// Formulário para a inserção de histórico
	echo
		'<section class="cad">', $EOL,
			'<h1>Histórico de pareceres</h1>', $EOL,
			'<form action="adicionar.historico.php" method="post" enctype="multipart/form-data" class="new">', $EOL,
				'<input type="hidden" name="sobre" value="', $id, '" />', $EOL,
				'<input type="hidden" name="sec" value="', $sec, '" />', $EOL,
				'<p class="lab"><label>Título: <input type="text" name="titulo" style="width:885px"/></label></p>', $EOL,
				'<p class="lab"><label for="descricao">Descrição: </label></p>', $EOL,
				'<p><textarea id="descricao" name="descricao" style="width:918px;height:150px"></textarea></p>', $EOL,
				'<input type="hidden" name="MAX_FILE_SIZE" value="', $FMS, '" />', $EOL,
				'<p class="lab but"><label>Anexo: <input id="arquivo" name="arquivo" type="file"/></label> Máximo: ', number_format($FMS,0,',','.'), ' bytes</p>', $EOL,
				'<p class="but"><input type="submit" value="Adicionar"/></p>', $EOL,
			'</form>', $EOL,
		'</section>', $EOL
	;

	// Caso possua permissão
	if(perm($db_link, 'permissao_e_entidade', 77, $id)){
		// Filtrar seção?
		if($sec) $secq = "AND his.secao = $sec"; else $secq = '';
		// Tenta selecionar históricos
		if($db_query = mysqli_query($db_link, "SELECT ent1.id, ent1.nome, DATE_FORMAT(his.quando, '%Y-%m-%d %H:%i:%s'), DATE_FORMAT(his.quando, '%d/%m/%Y %H:%i:%s'), his.titulo, his.descricao, his.arquivo FROM historico his LEFT JOIN entidade ent1 ON ent1.id = his.entidade LEFT JOIN entidade ent2 ON ent2.id = his.sobre WHERE ent2.id = $id $secq ORDER BY his.quando DESC;")){
			// Ao selecionar pelo menos um histórico
			if(mysqli_num_rows($db_query)){
				// Para cada possível histórico existente cadastrado
				for($i = 1;$db_result = mysqli_fetch_row($db_query);$i++){
					// Trata entrada
					$db_result[0] = (int) $db_result[0];
					$db_result[1] = htmlspecialchars($db_result[1]);
					$db_result[2] = htmlspecialchars($db_result[2]);
					$db_result[3] = htmlspecialchars($db_result[3]);
					$db_result[4] = htmlspecialchars($db_result[4]);
					$db_result[5] = htmlspecialchars($db_result[5]);
					if($db_result[6] !== NULL) $db_result[6] = htmlspecialchars($db_result[6]);

					// Imprime os dados pertinentes
					echo
						'<section>', $EOL,
							'<p><b>Por:</b> ', $db_result[1], '</p>', $EOL,
							'<p class="but"><b>Quando:</b> ', $db_result[3], '</p>', $EOL,
							'<p class="but"><b>Título:</b> ', $db_result[4], '</p>', $EOL,
							// Link para mostrar a descrição
							'<p class="but">',
								'<a href="javascript:desc(', $sec, ',', $i, ')"><b>Descrição <span id="hist-', $sec, '-', $i, '-a">▼</span><span id="hist-', $sec, '-', $i, '-b">▲</span></b></a>',
							'</p>', $EOL,
							// Esconde descrição inicialmente
							'<script>',
								'$(function(){',
									'$("#hist-', $sec, '-', $i, '").hide();',
									'$("#hist-', $sec, '-', $i, '-b").hide();',
								'});',
							'</script>', $EOL,
							'<div id="hist-', $sec, '-', $i, '">',
								'<p class="but text">'
					;

					// Parágrafos a exibir
					$pars = str_replace("\r\n",'</p><p class="but text">',$db_result[5]);

					echo $pars, '</p></div>', $EOL;

					// Se tem anexo, exibe link
					if($db_result[6])
						echo '<p class="but"><b><a href="', $FDIR, '/', $db_result[6], '">Anexo</a></b></p>', $EOL;
					else
						echo '<p class="but"><b>Sem anexo</b></p>', $EOL;

					// Formulário para exclusão
					echo
							'<form method="post" action="excluir.historico.php" class="but">',
								'<input type="hidden" name="entidade" value="', $db_result[0], '"/>',
								'<input type="hidden" name="sobre" value="', $id, '"/>',
								'<input type="hidden" name="quando" value="', $db_result[2], '"/>',
								'<input type="hidden" name="sec" value="', $sec, '"/>',
								'<input type="submit" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir este histórico?\');"/>',
							'</form>', $EOL,
						'</section>', $EOL
					;
				}
			// Caso não tenha selecionado históricos
			} else echo '<section><p>Nenhum histórico a listar</p></section>', $EOL;
		// Caso tenha ocorrido problema com a consulta
		} else {
			// Seleciona-se e escapa-se o erro
			$error = htmlspecialchars(mysqli_error($db_link));
			// E o inclui na mensagem passada ao usuário
			echo '<section><p class="error">Erro na consulta com a Base de Dados: ', $error, '</p></section>', $EOL;
		}
	// Caso não possua permissão
	} else echo '<section><p class="error">Você não tem permissão para visualizar estes dados.</p></section>', $EOL;
}