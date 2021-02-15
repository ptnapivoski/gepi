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

			// Se for um tipo de logradouro válido
			if($('#tipo-de-logradouro-select').val() > 0){
				// Requisita via AJAX
				$.ajax({
					// De modo sincronizado
					async: false,
					// O select dos logradouros daquela cidade, daquele tipo e com dado filtro
					url: 'select.logradouro.php?cidade='+$('#cidade-select').val()+'&tipo_de_logradouro='+$('#tipo-de-logradouro-select').val()+'&filtro='+encodeURIComponent($('#filtro-de-nome-de-logradouro').val())
				// Com os dados requisitados
				}).done(function(data){
					// Insere no lugar apropriado
					$('#logradouro-select').empty().html(data);
				});
			}
		}
	});

	// Ao alterar o select dos tipos de logradouro
	$('#tipo-de-logradouro-select').change(function(){
		// Se for um tipo de logradouro e uma cidade válida
		if($('#tipo-de-logradouro-select').val() > 0 && $('#cidade-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// O select dos logradouros daquela cidade, daquele tipo e com dado filtro
				url: 'select.logradouro.php?cidade='+$('#cidade-select').val()+'&tipo_de_logradouro='+$('#tipo-de-logradouro-select').val()+'&filtro='+encodeURIComponent($('#filtro-de-nome-de-logradouro').val())
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#logradouro-select').empty().html(data);
			});
		}
	});

	// Ao alterar o filtro de nome de logradouros
	$('#filtro-de-nome-de-logradouro').change(function(){
		// Se for um tipo de logradouro e uma cidade válida
		if($('#tipo-de-logradouro-select').val() > 0 && $('#cidade-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// O select dos logradouros daquela cidade, daquele tipo e com dado filtro
				url: 'select.logradouro.php?cidade='+$('#cidade-select').val()+'&tipo_de_logradouro='+$('#tipo-de-logradouro-select').val()+'&filtro='+encodeURIComponent($('#filtro-de-nome-de-logradouro').val())
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#logradouro-select').empty().html(data);
			});
		}
	});

	// Função explícita de atualização do campo dos bairros
	update_bairro = function(){
		// Se for uma cidade válida
		if($('#cidade-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// O select dos bairros daquela cidade
				url:'select.bairro.php?cidade='+$('#cidade-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#bairro-select').empty().html(data);
			});
		}
	}

	// Função explícita de atualização do campo dos logradouros
	update_logradouro = function(){
		// Se for um tipo de logradouro e uma cidade válida
		if($('#tipo-de-logradouro-select').val() > 0 && $('#cidade-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// O select dos logradouros daquela cidade, daquele tipo e com dado filtro
				url: 'select.logradouro.php?cidade='+$('#cidade-select').val()+'&tipo_de_logradouro='+$('#tipo-de-logradouro-select').val()+'&filtro='+encodeURIComponent($('#filtro-de-nome-de-logradouro').val())
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#logradouro-select').empty().html(data);
			});
		}
	}

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
