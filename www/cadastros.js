$(function(){
	// Ao alterar o select dos países na seção das unidades federativas
	$('#uf-pais-select').change(function(){
		// Se for um país válido
		if($('#uf-pais-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// A tabela das unidades federativas daquele país
				url: 'table.uf.php?pais='+$('#uf-pais-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#uf-div').empty().html(data);
			});
		}
	});

	// Ao alterar o select dos países na seção das cidades
	$('#cidade-pais-select').change(function(){
		// Se for um país válido
		if($('#cidade-pais-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// O select das unidades federativas daquele país
				url: 'select.uf.php?pais='+$('#cidade-pais-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#cidade-uf-select').empty().html(data);
			});
		}
	});

	// Ao alterar o select das unidades federativas na seção das cidades
	$('#cidade-uf-select').change(function(){
		// Se for uma unidade federativa válida
		if($('#cidade-uf-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// A tabela das cidades daquela unidade federativa
				url: 'table.cidade.php?uf='+$('#cidade-uf-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#cidade-div').empty().html(data);
			});
		}
	});

	// Ao alterar o select dos países na seção dos logradouros
	$('#logradouro-pais-select').change(function(){
		// Se for um país válido
		if($('#logradouro-pais-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// O select das unidades federativas daquele país
				url: 'select.uf.php?pais='+$('#logradouro-pais-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#logradouro-uf-select').empty().html(data);
			});

			// Configura o select das cidades para informar que deve ser selecionada a unidade federativa
			$('#logradouro-cidade-select').empty().html('<option value="0">Selecione uma unidade federativa no campo anterior</option>');
		}
	});

	// Ao alterar o select das unidades federativas na seção dos logradouros
	$('#logradouro-uf-select').change(function(){
		// Se for uma unidade federativa válida
		if($('#logradouro-uf-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// O select das cidades daquela unidade federativa
				url: 'select.cidade.php?uf='+$('#logradouro-uf-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#logradouro-cidade-select').empty().html(data);
			});
		}
	});

	// Ao alterar o select das cidades na seção dos logradouros
	$('#logradouro-cidade-select').change(function(){
		// Se for uma cidade válida e um tipo de logradouro válido
		if($('#logradouro-cidade-select').val() > 0 && $('#logradouro-tipo-de-logradouro-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// A tabela dos logradouros daquela cidade e daquele tipo de logradouro
				url: 'table.logradouro.php?cidade='+$('#logradouro-cidade-select').val()+'&tipo_de_logradouro='+$('#logradouro-tipo-de-logradouro-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#logradouro-div').empty().html(data);
			});
		}
	});

	// Ao alterar o select dos tipos de logradouros na seção dos logradouros
	$('#logradouro-tipo-de-logradouro-select').change(function(){
		// Se for uma cidade válida e um tipo de logradouro válido
		if($('#logradouro-cidade-select').val() > 0 && $('#logradouro-tipo-de-logradouro-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// O tabela dos logradouros daquela cidade e daquele tipo de logradouro
				url: 'table.logradouro.php?cidade='+$('#logradouro-cidade-select').val()+'&tipo_de_logradouro='+$('#logradouro-tipo-de-logradouro-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#logradouro-div').empty().html(data);
			});
		}
	});

	// Ao alterar o select dos países na seção das unidades federativas
	$('#bairro-pais-select').change(function(){
		// Se for um país válido
		if($('#bairro-pais-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// O select das unidades federativas daquele país
				url: 'select.uf.php?pais='+$('#bairro-pais-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#bairro-uf-select').empty().html(data);
			});

			// Configura o select das cidades para informar que deve ser selecionada a unidade federativa
			$('#bairro-cidade-select').empty().html('<option value="0">Selecione uma unidade federativa no campo anterior</option>');
		}
	});

	// Ao alterar o select das unidades federativas na seção dos bairros
	$('#bairro-uf-select').change(function(){
		// Se for uma unidade federativa válida
		if($('#bairro-uf-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// O select das cidades daquela unidade federativa
				url: 'select.cidade.php?uf='+$('#bairro-uf-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#bairro-cidade-select').empty().html(data);
			});
		}
	});

	// Ao alterar o select das cidades na seção dos bairros
	$('#bairro-cidade-select').change(function(){
		// Se for uma cidade válida
		if($('#bairro-cidade-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// A tabela dos bairros daquela cidade
				url: 'table.bairro.php?cidade='+$('#bairro-cidade-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#bairro-div').empty().html(data);
			});
		}
	});

	// Em todos os selects de país, seleciona o Brasil
	$('#uf-pais-select').val(1);
	$('#uf-pais-select').change();
	$('#cidade-pais-select').val(1);
	$('#cidade-pais-select').change();
	$('#logradouro-pais-select').val(1);
	$('#logradouro-pais-select').change();
	$('#bairro-pais-select').val(1);
	$('#bairro-pais-select').change();

	// Em todos os selects de unidade federativa, seleciona Rio Grande do Sul
	$('#cidade-uf-select').val(23);
	$('#cidade-uf-select').change();
	$('#logradouro-uf-select').val(23);
	$('#logradouro-uf-select').change();
	$('#bairro-uf-select').val(23);
	$('#bairro-uf-select').change();

	// Em todos os selects de cidade, seleciona Rio Grande
	$('#logradouro-cidade-select').val(1);
	$('#logradouro-cidade-select').change();
	$('#bairro-cidade-select').val(1);
	$('#bairro-cidade-select').change();
});
