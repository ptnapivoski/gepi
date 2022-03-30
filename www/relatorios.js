$(function(){
	// Ao alterar o select dos países na parte para o primeiro relatório
	$('#rel-1-pais-select').change(function(){
		// Se for um país válido
		if($('#rel-1-pais-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// O select das unidades federativas daquele país
				url: 'select.uf.php?pais='+$('#rel-1-pais-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#rel-1-uf-select').empty().html(data);
			});

			// Configura o select das cidades para informar que deve ser selecionada a unidade federativa
			$('#rel-1-cidade-select').empty().html('<option value="0">Selecione uma unidade federativa no campo anterior</option>');
		}
	});

	// Ao alterar o select das unidades federativas na parte para o primeiro relatório
	$('#rel-1-uf-select').change(function(){
		// Se for uma unidade federativa válida
		if($('#rel-1-uf-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// O select das cidades daquela unidade federativa
				url: 'select.cidade.php?uf='+$('#rel-1-uf-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#rel-1-cidade-select').empty().html(data);
			});
		}
	});

	// Ao alterar o select dos países na parte para o segundo relatório
	$('#rel-2-pais-select').change(function(){
		// Se for um país válido
		if($('#rel-2-pais-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// O select das unidades federativas daquele país
				url: 'select.uf.php?pais='+$('#rel-2-pais-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#rel-2-uf-select').empty().html(data);
			});

			// Configura o select das cidades para informar que deve ser selecionada a unidade federativa
			$('#rel-2-cidade-select').empty().html('<option value="0">Selecione uma unidade federativa no campo anterior</option>');
		}
	});

	// Ao alterar o select das unidades federativas na parte para o segundo relatório
	$('#rel-2-uf-select').change(function(){
		// Se for uma unidade federativa válida
		if($('#rel-2-uf-select').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// O select das cidades daquela unidade federativa
				url: 'select.cidade.php?uf='+$('#rel-2-uf-select').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#rel-2-cidade-select').empty().html(data);
			});
		}
	});

	// Ao alterar o ID da escola
	$('#rel-5-escola').change(function(){
		// Se for uma entidade válida
		if($('#rel-5-escola').val() > 0){
			// Requisita via AJAX
			$.ajax({
				// De modo sincronizado
				async: false,
				// Os dados para inserção num input
				url: 'input.escola.php?id='+$('#rel-5-escola').val()
			// Com os dados requisitados
			}).done(function(data){
				// Insere no lugar apropriado
				$('#rel-5-escola-nome').val(data);
			});
		// Caso não seja válida, colocar a escola vazia
		} else $('#rel-5-escola-nome').val('Nenhuma');
	});

	// Em todos os selects de país, seleciona o Brasil
	$('#rel-1-pais-select').val(1);
	$('#rel-1-pais-select').change();
	$('#rel-2-pais-select').val(1);
	$('#rel-2-pais-select').change();

	// Em todos os selects de unidade federativa, seleciona Rio Grande do Sul
	$('#rel-1-uf-select').val(23);
	$('#rel-1-uf-select').change();
	$('#rel-2-uf-select').val(23);
	$('#rel-2-uf-select').change();

	// Em todos os selects de cidade, seleciona Rio Grande
	$('#rel-1-cidade-select').val(1);
	$('#rel-1-cidade-select').change();
	$('#rel-2-cidade-select').val(1);
	$('#rel-2-cidade-select').change();
});
