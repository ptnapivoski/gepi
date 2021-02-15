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

			// Se o tipo de logradouro selecionado for válido
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
		// Se for uma cidade válida e um tipo de logradouro válido
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
		// Se for uma cidade válida e um tipo de logradouro válido
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
});
