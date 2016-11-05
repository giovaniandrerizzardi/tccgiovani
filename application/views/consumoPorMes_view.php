
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-10 col-xs-10 col-md-offset-1 " id="borda">

            <div class="col-md-3 col-xs-3" id="borda">

                <h4 class="form-signin-heading"><?php echo $this->lang->line('firstDate') . ":"; ?></h4>
                <input id="firstdate" type="date_month" class="form-control" placeholder="<?php echo $this->lang->line('firstDate'); ?>" required name="date">
                <h4 class="form-signin-heading"><?php echo $this->lang->line('endDate') . ":"; ?></h4>
                <input id="enddate" type="date_month" class="form-control" placeholder="<?php echo $this->lang->line('endDate'); ?>" required name="date">
                <br>
                  <button id="click_me" type="button">Click Me!</button>


            </div>
            <div class="col-md-12 col-xs-12">
            <div class="col-md-8 col-xs-8" id="borda">
                <div class="col-md-6 col-xs-6">
                    <div id="graficotensao" style="width:100%"></div>

                </div>
                <div class="col-md-6 col-xs-6">
                    <div id="graficocorrente" style="width:100%"></div>

                </div>
                <br>
                <p>OBS: So serao mostrados os primeiros 10 meses no grafico.</p>
            </div>
                    
                
            
            <div class="col-md-4 col-xs-4">
                <title> Detalhes do consumo</title>

                <ul class="list-group">
                    <li class="list-group-item">Maior consumo: <a id="maiorconsumo"></a></li>
                    <li class="list-group-item">Menor consumo: <a id="menorconsumo"></a></li>
                    <li class="list-group-item">Variaçao de consumo: <a id="menorconsumov"></a> - <a id="maiorconsumov"></a> </li>
                    <li class="list-group-item">Variaçao de Tensao: <a id="menortensaov"></a> - <a id="maiortensaov"></a></li>
                    <li class="list-group-item">Maior Tensao: <a id="maiortensao"></a></li>
                </ul>
                
            </div>
                
                </div>

            <table id="tabelaseventos" class="table table-bordered table-condensed table-striped">
            <thead>
            <tr>
               
                <th class="col1" ><?php echo $this->lang->line('Data'); ?></th>
                <th class="col2" ><?php echo $this->lang->line('Corrente'); ?></th>
                <th class="col3" ><?php echo $this->lang->line('tensao'); ?></th>
            </tr>
            </thead>
              <tbody id="tbodyloco"></tbody>
            </table>
            
            

            
            
        </div>
    </div>
</div>
<script type="text/javascript">

$(document).ready(function () {
   var table = $('table').DataTable(); 
   $('#click_me').click(function () {
        var dtinicio = $('#firstdate').val();
        var dtfim = $('#enddate').val();
       //definindo o inicio do mes 
        dtinicio +='-01';
        dtfim +='-01'
        console.log(dtinicio);
        console.log(dtfim);

        //get é um ajax  simplificado, mais simples. onde recebe os dados no data
        $.get('http://localhost/teste/index.php/consumoPorMes/getData', {inicio: dtinicio, fim: dtfim}, function (data) {
            

            //preenche a tabela com os dados
            //console.log(data.dado);
            
            table.clear();
                $.each(data.dado, function (key, value) {
                  
                    table.row.add([
                        value.MES,
                        value.KW,
                        value.DETLA_T

                    ]).draw(false);                   
                   
                });



            //grafico
            var optionst = {
                chart: {
                    renderTo: 'graficotensao',
                    type: 'line',
                    marginBottom: 25
                },
                title: {
                    text: 'Tensao',
                    x: -20 //center
                },
//                subtitle: {
//                    text: 'data',
//                    x: -20
//                },
                xAxis: {
                    type: 'datetime',
           
                    categories: []
                },
                yAxis: {
                    title: {
                        text: 'Amperes'
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                },
                
                legend: {
                    layout: 'vertical',
//                    align: 'right',
                    verticalAlign: 'top',
                      x: -37,
                       y: 25,
//                    borderWidth: 0
                },
                series: []
            }


            //grafico corrente

            var optionsc = {
                chart: {
                    renderTo: 'graficocorrente',
                    type: 'line',
                    marginBottom: 25
                },
                title: {
                    text: 'Consumo',
                    x: -20 //center
                },
                subtitle: {
                    text: '',
                    x: -20
                },
                xAxis: {
                     type: 'datetime',
            dateTimeLabelFormats: {
                day: '%e of %b'
            },
                    categories: []
                },
                yAxis: {
                    title: {
                        text: 'Amperes'
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                },
//                tooltip: {
//                    formatter: function () {
//                        return '<b>' + this.series.name + '</b><br/>' +
//                                this.x + ': ' + this.y;
//                    }
//                },
                legend: {
                    layout: 'vertical',
//                    align: 'right',
                    verticalAlign: 'top',
                      x: -37,
                       y: 25,
//                    borderWidth: 0
                },
                series: []
            }

            //var de tensao
            var seriest = {
                
                data: [],
                color: 'red'
            }
            var axix = {
                categories: [],
                 type: 'datetime',
            dateTimeLabelFormats: {
          month: '%b \'%y'
        }
                
            }
  
            //vars de consumo
            var seriesc = {
                
                data: [],
                color: 'red'
            }


            //percorre os valores vindo do php e armazena  no series.data
            // separa a data e pedaços e pega  somente o dia /mes...
            var i = 0;
            $.each(data.dado, function (key, value) {
                if(i<10){
                seriest.data.push(parseFloat(value.DETLA_T));
                seriesc.data.push(parseFloat(value.KW));
               
           
            var mes = value.MES.split('-');
                mes = mes[1];
               
                axix.categories.push(value.MES);
                console.log(value);
                i++;
            }
            });

            //console.log(series);
            //alert(1);
            //  alert(data);

//                var chart = $('#consumodiatensao').highcharts();
//                if (chart.series.length) {
//                    chart.series[0].remove();
//                }

            //plot do grafico de tensao
            optionst.xAxis.categories = axix['categories'];
            optionst.series[0] = seriest;
            chart = new Highcharts.Chart(optionst);
            //plot do grafico de consumo
            optionsc.xAxis.categories = axix['categories'];
            optionsc.series[0] = seriesc;
            chart = new Highcharts.Chart(optionsc);

//                   chart.addAxis(axix,false);
//                chart.addSeries(series);



              // preenchendo os detalhes do consumo
                $('#maiorconsumo').html(data.dados.maiorcorrente);
                 $('#menorconsumo').html(data.dados.menorcorrente);
                $('#menorconsumov').html(data.dados.menorcorrente);
                $('#maiorconsumov').html(data.dados.maiorcorrente);
                $('#maiortensaov').html(data.dados.maiortensao);
                $('#menortensaov').html(data.dados.menortensao);
                $('#maiortensao').html(data.dados.maiortensao);
                $('#menortensao').html(data.dados.menortensao);

        }, 'JSON');
        });
    });




</script>
