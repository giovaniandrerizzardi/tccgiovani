$(document).ready(function() {
	var cont = 0;
	var graficos = [];
    $('input[type="checkbox"]').click(function() {
		var classe = $(this).attr('class'); //pega a classe do checkbox clicado
		var id = $(this).attr('id'); //pega o id do checkbox clicado
		var checkado = ($("#"+id).is(':checked')); //verifica se o checkbox foi clicado true == sim, false == não
    
		if(classe == "equipamentos"){ // classe == equipamentos coluna visualizar
			if(checkado == true){ // se checkado == true mostra a div do equipamento
				var name = $(this).attr('name'); //pega o name do checkbox clicado
				$.ajax({
                	url: 'dtSource.php',					  
               		dataType: 'json',
             		scriptCharset: 'UTF-8',
               		type: "POST",
               		data: { 
                   		action: 'checkDados',
                   		idCheckbox: name
               		},                  
               		success: function( dados ) {
                  		if(dados){
                      		var chart = $('#equipamentos'+id).highcharts();
                       		chart.addSeries({
                           		name: 'Equipamento '+id,
                           		data: dados.linha
                           	});
               	}else
                	alert("Erro Ajax.");
                }
            	});
				$("#equipamento"+id).show();
			}else{ // senão oculta a div do equipamento
				$("#equipamento"+id).hide();
					for(x=1;x<5;x++){
						var chart = $('#equipamentos'+id).highcharts();
        				if (chart.series.length) {
            				chart.series[x].remove();
        				}
					}
			}
		}else{	
			if(checkado == true){ // se checkado == true monta gráfico na área de comparação
			//ajax envia os dados p/ php e no php processa e retornar valores em dados.linha e dados.barra
				if(cont<5){
					graficos[cont] = id;
					$.ajax({
                    	    url: 'dtSource.php',					  
                        	dataType: 'json',
                       	 	scriptCharset: 'UTF-8',
                        	type: "POST",
                        	data: { 
                            	action: 'checkDados',
                            	idCheckbox: id
                        	},                  
                        	success: function( dados ) {
                            	if(dados){
                                	var chart = $('#barra').highcharts();
                                	chart.addSeries({
                                    	name: 'Equipamento'+classe,
                                    	data: dados.barra
                                	});
                                	var chart = $('#linha').highcharts();
                                	chart.addSeries({
                                    	name: 'Equipamento'+classe,
                                    	data: dados.linha
                                	});
									cont=++cont;
                            }else
                                alert("Erro Ajax.");
                        }
                    }); 
				}else{
					alert("Máximo de 5 Equipamentos Atingido");
				}                       	
			}else{ // senão oculta gráfico do equipamento
				cont=--cont;	
				for(var x=0;x<graficos.length;x++){
					if(graficos[x]==id){
						var chart = $('#barra').highcharts();
        				if (chart.series.length) {
            				chart.series[x].remove();
        				}
						var chart = $('#linha').highcharts();
        				if (chart.series.length) {
            				chart.series[x].remove();
        				}
						graficos.splice(x,1);
					}
				}	
			}
		}
	});			
});