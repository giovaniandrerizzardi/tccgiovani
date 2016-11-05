// Função que oculta e mostra input pesquisar
$(document).ready(function(){
	$("#txtColuna1").hide();$("#txtColuna2").hide();$("#txtColuna3").hide();$("#txtColuna4").hide();$("#txtColuna5").hide();$("#txtColuna6").hide();$("#txtColuna7").hide();$("#txtColuna8").hide();$("#txtColuna9").hide();$("#txtColuna10").hide();$("#txtColuna11").hide();
	$("#fechar1").hide();$("#fechar2").hide();$("#fechar3").hide();$("#fechar4").hide();$("#fechar5").hide();$("#fechar6").hide();$("#fechar7").hide();$("#fechar8").hide();$("#fechar9").hide();$("#fechar10").hide();$("#fechar11").hide();
   $("#mostrar1").click(function(evento){
         $("#txtColuna1").show();
		 $("#fechar1").show();
   });
   $("#mostrar2").click(function(evento){
		 $("#txtColuna2").show();
		 $("#fechar2").show();
   });
   $("#mostrar3").click(function(evento){
		 $("#txtColuna3").show();
		 $("#fechar3").show();
   });
   $("#mostrar4").click(function(evento){
		 $("#txtColuna4").show();
		 $("#fechar4").show();
   });
   $("#mostrar5").click(function(evento){
		 $("#txtColuna5").show();
		 $("#fechar5").show();
   });
   $("#mostrar6").click(function(evento){
		 $("#txtColuna6").show();
		 $("#fechar6").show();
   });
   $("#mostrar7").click(function(evento){
		 $("#txtColuna7").show();
		 $("#fechar7").show();
   });
   $("#mostrar8").click(function(evento){
		 $("#txtColuna8").show();
		 $("#fechar8").show();
   });
   $("#mostrar9").click(function(evento){
		 $("#txtColuna9").show();
		 $("#fechar9").show();
   });
   $("#mostrar10").click(function(evento){
		 $("#txtColuna10").show();
		 $("#fechar10").show();
   });
   $("#mostrar11").click(function(evento){
		 $("#txtColuna11").show();
		 $("#fechar11").show();
   });
	$("#fechar1").click(function(evento){
         $("#txtColuna1").hide();
		 $("#fechar1").hide();
   });
   $("#fechar2").click(function(evento){
         $("#txtColuna2").hide();
		 $("#fechar2").hide();
   });
   $("#fechar3").click(function(evento){
         $("#txtColuna3").hide();
		 $("#fechar3").hide();
   });
   $("#fechar4").click(function(evento){
		 $("#txtColuna4").hide();
		 $("#fechar4").hide();   
		 
   });
   $("#fechar5").click(function(evento){
         $("#txtColuna5").hide();
		 $("#fechar5").hide();
   });
   $("#fechar6").click(function(evento){
         $("#txtColuna6").hide();
		 $("#fechar6").hide();
   });
   $("#fechar7").click(function(evento){
         $("#txtColuna7").hide();
		 $("#fechar7").hide();
   });
   $("#fechar8").click(function(evento){
         $("#txtColuna8").hide();
		 $("#fechar8").hide();
   });
   $("#fechar9").click(function(evento){
         $("#txtColuna9").hide();
		 $("#fechar9").hide();
   });
   $("#fechar10").click(function(evento){
         $("#txtColuna10").hide();
		 $("#fechar10").hide();
   });
   $("#fechar11").click(function(evento){
         $("#txtColuna11").hide();
		 $("#fechar11").hide();
   });
});


//função oculta os filtros
$(document).ready(function() {
	$("#filtro1").hide();$("#filtro2").hide();$("#filtro3").hide();$("#filtro4").hide();$("#filtro5").hide();$("#filtro6").hide();$("#filtro7").hide();$("#filtro8").hide();	$("#filtro9").hide();$("#filtro10").hide();$("#filtro11").hide();
});

// Função pesquisar por coluna
$(function(){
	$("#myTable input").keyup(function(){		
		
		var cla = $(this).attr('class'); //pega a classe do input text
		switch (cla) {  // mostra o filtro da classe conforme o case
    case '2': 
        $("#filtro2").show();
        break;
    case '3': 
        $("#filtro3").show();
        break;
    case '4': 
        $("#filtro4").show();
        break;      
    case '5': 
        $("#filtro5").show();
        break;
	case '6': 
        $("#filtro6").show();
        break;
	case '7': 
        $("#filtro7").show();
        break;
	case '8': 
        $("#filtro8").show();
        break;
	case '9': 
        $("#filtro9").show();
        break;
	case '10': 
        $("#filtro10").show();
        break;
	case '11': 
        $("#filtro11").show();
        break;	
	}	

		var id = $(this).attr('id');
		if($("#txtColuna2").val()==""){
			if(id == "txtColuna2"){
				$("#filtro2").hide();
			}
		}
		if($("#txtColuna3").val()==""){
			if(id == "txtColuna3"){
				$("#filtro3").hide();
			}
		}
		if($("#txtColuna4").val()==""){
			if(id == "txtColuna4"){
				$("#filtro4").hide();
			}
		}
		if($("#txtColuna5").val()==""){
			if(id == "txtColuna5"){
				$("#filtro5").hide();
			}
		}
		if($("#txtColuna6").val()==""){
			if(id == "txtColuna6"){
				$("#filtro6").hide();
			}
		}
		if($("#txtColuna7").val()==""){
			if(id == "txtColuna7"){
				$("#filtro7").hide();
			}
		}
		if($("#txtColuna8").val()==""){
			if(id == "txtColuna8"){
				$("#filtro8").hide();
			}
		}
		if($("#txtColuna9").val()==""){
			if(id == "txtColuna9"){
				$("#filtro9").hide();
			}
		}
		if($("#txtColuna10").val()==""){
			if(id == "txtColuna10"){
				$("#filtro10").hide();
			}
		}
		if($("#txtColuna11").val()==""){
			if(id == "txtColuna11"){
				$("#filtro11").hide();
			}
		}
		
		var index = $(this).parent().index();
		var nth = "#myTable td:nth-child("+(index+1).toString()+")";
		var valor = $(this).val().toUpperCase();
		$("#myTable tbody tr").show();
		$(nth).each(function(){
			if($(this).text().toUpperCase().indexOf(valor) < 0){
				$(this).parent().hide();
			}
		});
	});
	
	$("#myTable input").blur(function(){
		$(this).val("");
	});	
});

// Função pesquisar toda tabela
$(function(){
	$(".input-search").keyup(function(){
		$("#filtro1").show();
		
		var id = $(this).attr('id');
		if($("#txtColuna1").val()==""){
			if(id == "txtColuna1"){
				$("#filtro1").hide();
			}
		}
		//pega o css da tabela 
		var tabela = $(this).attr('alt');
		if( $(this).val() != ""){
			$("."+tabela+" tbody>tr").hide();
			$("."+tabela+" td:contains-ci('" + $(this).val() + "')").parent("tr").show();
		} else{
			$("."+tabela+" tbody>tr").show();
		}
	});	
});
$.extend($.expr[":"], {
	"contains-ci": function(elem, i, match, array) {
		return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
	}
});	

//função atualiza a página para o painel de controle
var intervalo = setInterval(function() {
	$('#atualiza').load('paineldecontrole.php #atualiza'); }, 1000);