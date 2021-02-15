<?php

function perm($db_link, $tbl, $ac, $obj){
	// Por padrão não permite a ação
	$perm = FALSE;
	// Critérios de seleção da permissão.
	$queries = array(
		 // Usuário logado pode executar a ação com aquele objeto?
		 "entidade = $_SESSION[user] AND acao = $ac AND com = $obj"
		 // Qualquer usuário logado pode executar a ação com aquele objeto?
		,"entidade IS NULL AND acao = $ac AND com = $obj"
		 // Usuário logado pode executar a ação com qualquer objeto?
		,"entidade = $_SESSION[user] AND acao = $ac AND com IS NULL"
		 // Qualquer usuário logado pode executar a ação com qualquer objeto?
		,"entidade IS NULL AND acao = $ac AND com IS NULL"
	);

	// Se provido objeto
	if($obj)
		// Começa na primeira query
		$i = 0;
	// Caso contrário
	else
		// Começa na terceira query
		$i = 2;
	// Para cada critério de seleção de permissão
	for(;$i < 4;$i++){
		// Tenta selecionar uma linha que contenha o critério
		if($db_query_perm = mysqli_query($db_link, "SELECT pode FROM $tbl WHERE $queries[$i];")){
			// Se houver uma linha com aquele critério
			if(mysqli_num_rows($db_query_perm) === 1){
				// Recebe os dados da linha consultada
				$db_result_perm = mysqli_fetch_row($db_query_perm);
				// Limpa a consulta no DB
				mysqli_free_result($db_query_perm);
				// Se pode, configura a permissão com verdadeiro
				if($db_result_perm[0] === '1') $perm = TRUE;
				// E sai do loop de seleção dos critérios
				break;
			// Se não há linha para aquele critério
			} else {
				//simplesmente limpa a consulta
				mysqli_free_result($db_query_perm);
				// E tenta outro critério
				continue;
			}
		// Se há problema na consulta de critérios simplesmente sai
		} else break;
	}

	return $perm;
}
