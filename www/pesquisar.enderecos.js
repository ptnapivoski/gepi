$(function(){
	// Ao alterar o select dos países
	$('#pais-select').change(function(){
		// Se for um país válido
		if($('#pais-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// O select das unidades federativas daquele país
				url: 'select.uf.php?pais='+$('#pais-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#uf-select').empty().html(data);
			});
		}
	});

	// Ao alterar o select das unidades federativas
	$('#uf-select').change(function(){
		// Se for uma unidade federativa válida
		if($('#uf-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// O select das cidades daquela unidade federativa
				url: 'select.cidade.php?uf='+$('#uf-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#cidade-select').empty().html(data);
			});
		}
	});

	// Ao alterar o select das cidades
	$('#cidade-select').change(function(){
		// Se for uma cidade válida
		if($('#cidade-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// O select dos bairros daquela cidade
				url: 'select.bairro.php?cidade='+$('#cidade-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#bairro-select').empty().html(data);
			});
		}
	});

	// Ao alterar o select dos bairros
	$('#bairro-select').change(function(){
		// Se for um bairro válido
		if($('#bairro-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// A tabela dos endereços daquele bairro
				url: 'table.endereco.php?bairro='+$('#bairro-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#endereco-div').empty().html(data);
			});
		}
	});

	// Seleciona por padrão o Brasil
	$('#pais-select').val(1);
	$('#pais-select').change();
	// Rio Grande do Sul
	$('#uf-select').val(23);
	$('#uf-select').change();
	// E Rio Grande
	$('#cidade-select').val(1);
	$('#cidade-select').change();
});
