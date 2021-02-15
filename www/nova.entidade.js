$(function(){
	// Ao alterar o ID do endereço
	$('#endereco').change(function(){
		// Se for um endereço válido
		if($('#endereco').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.endereco.php?id='+$('#endereco').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#endereco-nome').val(data);
			});
		// Caso não seja válido, colocar o endereço vazio
		} else $('#endereco-nome').val('Nenhum');
	});
});
