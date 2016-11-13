
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-10 col-xs-10 col-md-offset-1 " id="borda">
            <h2><?php echo $this->lang->line('consumodia'); ?></h2>
            <div class="col-md-3 col-xs-3" id="borda">

                <h4 class="form-signin-heading"><?php echo $this->lang->line('firstDate') . ":"; ?></h4>
                <input id="firstdate" type="date_day" class="form-control" placeholder="<?php echo $this->lang->line('firstDate'); ?>" required name="date">
                <h4 class="form-signin-heading"><?php echo $this->lang->line('endDate') . ":"; ?></h4>
                <input id="enddate" type="date_day" class="form-control" placeholder="<?php echo $this->lang->line('endDate'); ?>" required name="date">
                <br>
                <button id="click_me" type="button">Buscar!</button>


            </div>
            
            <div class="col-md-12 col-xs-12">
                
                <div class="col-md-8 col-xs-8">
                      <h2>Graficos</h2>
                    <div class="col-md-6 col-xs-6">
                        <div id="graficotensao" style="width:100%"></div>
                        &nbsp;
                        <p>OBS: Mude a pagina para  atualizar o grafico</p>
                    </div>
                    <div class="col-md-6 col-xs-6">
                        <div id="graficocorrente" style="width:100%"></div>

                    </div>
                    <br>
                    
                </div>



                <div class="col-md-4 col-xs-4">
                    <h2> Detalhes do consumo</h2>

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
                        <th class="col1"><?php echo $this->lang->line('Data'); ?></th>
                        <th class="col2"><?php echo $this->lang->line('Corrente'); ?></th>
                        <th class="col3"><?php echo $this->lang->line('tensao'); ?></th>
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

            //get é um ajax  simplificado, mais simples. onde recebe os dados no data
            $.get('http://localhost/tccgiovani/index.php/consumoPorDia/getData', {inicio: dtinicio, fim: dtfim}, function (data) {
              

                //preenche a tabela com os dados


                table.clear();
                $.each(data.dado, function (key, value) {
                    table.row.add([
                        value.DIA,
                        value.KW + ' kWh',
                        value.DELTA_T + ' V'

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
                            text: 'Volts'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }]
                    },legend: {
            enabled: false
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
                    tooltip: {
                        formatter: function () {
                            return '<b>' + this.series.name + '</b><br/>' +
                                    this.x + ': ' + this.y;
                        }
                    },
                    legend: {
            enabled: false
        },
                    series: []
                }

                //var de tensao
                var seriest = {
                    name: 'Tensão',
                    data: [],
                    color: 'red'
                }
                var axix = {
                    type: 'datetime',
                    dateTimeLabelFormats: {
                        day: '%e of %b'
                    },
                    categories: []
                }

                //vars de consumo
                var seriesc = {
                    name: 'Consumo',
                    data: [],
                    color: 'red'
                }


                //percorre os valores vindo do php e armazena  no series.data
                // separa a data e pedaços e pega  somente o dia /mes...
                var i = 0;
                $.each(data.dado, function (key, value) {
                    if (i < 10) {
                        seriest.data.push(parseFloat(value.DELTA_T));
                        seriesc.data.push(parseFloat(value.KW));
                        var dia = value.DIA.split('-');
                        dia = dia[2] + '/' + dia[1];
                        alert(dia);
                        axix.categories.push(dia);
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
                $('#maiorconsumov').html(data.dados.maiorcorrente);
                $('#maiortensaov').html(data.dados.maiortensao);
                $('#menortensaov').html(data.dados.menortensao);
                $('#maiortensao').html(data.dados.maiortensao);
                $('#menortensao').html(data.dados.menortensao);


            }, 'JSON');
        });
        
        
        
          $(document).on('click', '.paginate_button', function () {

           
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
                        text: 'Volts'
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                },
                
                legend: {
                    enabled: false
//                    layout: 'vertical',
//                    align: 'right',
//                    verticalAlign: 'top',
//                      x: -37,
//                       y: 25,
//                    borderWidth: 0
                },
                series: []
            }


                //var da series
                var seriest = {
                    data: [],
                    color: 'blue'
                }
                var axix = {
                    categories: [],
                    type: 'datetime',
                    dateTimeLabelFormats: {
                        month: '%b \'%y'
                    }

                }
                var aux = 0;

                //0 e data, 1 e consumo  e 2 e tensao
                $('#tbodyloco tr').each(function () {
                    dados = table.row(this).data();
                    var t = dados[2].split(" ");
                    //console.log(t[0]);
                    seriest.data.push(parseFloat(t[0]));
                    axix.categories.push(dados[0]);
                });
                optionst.xAxis.categories = axix['categories'];
                optionst.series[0] = seriest;
                chart = new Highcharts.Chart(optionst);
                
           
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
                    enabled: false
//                    layout: 'vertical',
//                    align: 'right',
//                    verticalAlign: 'top',
//                      x: -37,
//                       y: 25,
//                    borderWidth: 0
                },
                series: []
            }



                //var da series
                var seriesc = {
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


                $('#tbodyloco tr').each(function () {
                    dados = table.row(this).data();
                    var t = dados[1].split(" ");
                    //console.log(t[0]);
                    seriesc.data.push(parseFloat(t[0]));
                    axix.categories.push(dados[0]);
                });
                optionsc.xAxis.categories = axix['categories'];
                optionsc.series[0] = seriesc;
                chart = new Highcharts.Chart(optionsc);


            



        });
        
        
    });




</script>
