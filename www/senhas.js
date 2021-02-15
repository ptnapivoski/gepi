$(function(){
	// Ao alterar o ID da entidade
	$('#alterar').change(function(){
		// Se for uma entidade válida
		if($('#alterar').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#alterar').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#alterar-nome').val(data);
			});
		// Caso não seja válido, colocar a entidade vazia
		} else $('#alterar-nome').val('Inválido');
	});

	// Ao alterar o ID da entidade
	$('#excluir').change(function(){
		// Se for uma entidade válida
		if($('#excluir').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.entidade.php?id='+$('#excluir').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#excluir-nome').val(data);
			});
		// Caso não seja válido, colocar a entidade vazia
		} else $('#excluir-nome').val('Inválido');
	});
});
