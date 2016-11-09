<div class="container-fluid">
    <div class="row-fluid">

        <div class="col-md-3 col-xs-3 mb-30 "id="borda">

            <h4 class="form-signin-heading"><?php echo $this->lang->line('firstDate') . ":"; ?></h4>
            <input id="firstdate" type="date" class="form-control" placeholder="<?php echo $this->lang->line('firstDate'); ?>" required name="date">
            <h4 class="form-signin-heading"><?php echo $this->lang->line('endDate') . ":"; ?></h4>
            <input id="enddate" type="date" class="form-control" placeholder="<?php echo $this->lang->line('endDate'); ?>" required name="date">
            <br>
            <button id="click_me" type="button">Click Me!</button>
        </div>
        <div class="col-md-12 col-xs-12" id="borda">
            <div class="col-md-6 col-xs-6">

                <table id="tabelaseventos" class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th style="width: 140px;"><?php echo $this->lang->line('Data'); ?></th>
                            <th><?php echo $this->lang->line('tensao'); ?></th>
                            <th><?php echo $this->lang->line('corrente'); ?></th>

                        </tr>
                    </thead>
                    <tbody id="tbodyloco"></tbody>

                </table>

            </div>

            <div class="col-md-6 col-xs-6" id="tabelaDireita">
                <div class="col-md-12 col-xs-12" id="borda">

                    <label class="radio-inline"><input id="grafico_Corrente" type="radio" name="optradiort"><?php echo $this->lang->line('graficoCorrente'); ?></label>
                    <label class="radio-inline"><input id="grafico_Tensao" type="radio" name="optradiort"><?php echo $this->lang->line('graficoTensao'); ?></label>

                </div>
                <div class="col-md-12 col-xs-12" id="borda">

                    <div class="checkbox">
                        <label>
                            <input id="attAut" type="checkbox"> <?php echo $this->lang->line('attAut'); ?>
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            valor no grafico: <input id="valoresNoGrafico" type="number"  value ="15" style="width: 60px;">
                        </label>
                    </div>

                </div>

                <div class="col-md-12 col-xs-12" id="borda">
                    <div class="col-md-6 col-xs-6">
                        <div class="checkbox">
                            <label><input id="agruparValores" type="checkbox" value="">Agrupar Valores</label>
                        </div>
                        <div class="radio">
                            <label><input id="radioMedia" type="radio" name="optradio">Media</label>
                        </div>
                        <div class="radio">
                            <label><input id="radioMaior" type="radio" name="optradio">Maior</label>
                        </div>
                        <div class="radio">
                            <label><input id="radioMenor" type="radio" name="optradio">Menor</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-6 well">
                        <div class="checkbox">
                            <label>
                                Periodo: <input id="periodo" type="number"  value ="5" name="che" style="width: 60px;">
                            </label>
                        </div>
                        <div class="radio">
                            <label><input id="radioMinuto" type="radio" name="optradio2">Minuto</label>
                        </div>
                        <div class="radio">
                            <label><input id="radioHora" type="radio" name="optradio2">Hora</label>
                        </div>
                        <div class="radio">
                            <label><input id="radioDia" type="radio" name="optradio2">Dia</label>
                        </div>
                        <button id="attbutton" type="button"  name="che">atualizar!</button>

                    </div>


                </div>

            </div>
        </div>
        <div class="col-md-12 col-xs-12" id="borda">
            <div class="col-md-5 col-xs-5">
                <div id="grafico">
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    &nbsp;
                </div>
            </div>


        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        var dataImp;
        var dataagroup;
        var valnografico = 15;
        var tipodografico;
        var table = $('table').DataTable();
        var agrupador;//  tipo de agrupamento maior menor ou media
        var tipodata;// tipo de data escolhida
        var dtinicio;
        var dtfim;
        $('#click_me').click(function () {
            dtinicio = $('#firstdate').val();
            dtfim = $('#enddate').val();

            //get é um ajax  simplificado, mais simples. onde recebe os dados no data
          $.get('http://localhost/tccgiovani/index.php/monitoramentoPeriodico/getData', {inicio: dtinicio, fim: dtfim}, function (data) {
                dataImp = data;
                $('#tbodyloco').closest('tr').remove();
                //preenche a tabela com os dados
                var html = '';
                table.clear();
                $.each(data.dado, function (key, value) {

                    var potencia = (value.TENSAO_RMS * value.CORRENTE_RMS);
                    var tensaorms = value.TENSAO_RMS;
                    var correnterms = value.CORRENTE_RMS;
                    var fi = value.FI;

                    table.row.add([
                        value.DATAHORA,
                        parseFloat(tensaorms).toFixed(2) + 'kWh',
                        parseFloat(correnterms).toFixed(2) + 'A'


                    ]).draw(false);

                });

            }, 'JSON');

        });

 $('#valoresNoGrafico').change(function () {
          valnografico =  $('#valoresNoGrafico').val();
          console.log(valnografico);
        });
        
        
        
        $('#grafico_Corrente').change(function () {
            if ($("#grafico_Corrente").is(":checked") == true && $("#agruparValores").is(":checked") == true) {
                geraGraficoCorrente(dataagroup);
            }else{
                geraGraficoCorrente(dataImp);
            }


        });


        $('#grafico_Tensao').change(function () {
            if ($("#grafico_Tensao").is(":checked") == true && $("#agruparValores").is(":checked") == true) {
                geraGraficoTensao(dataagroup);
            }else{
                geraGraficoTensao(dataImp);
            }



        });




        $('#attbutton').click(function () {
            console.log("foi 1");
            if ($("#agruparValores").is(":checked") == true) {
                console.log("foi 11");
                if ($("#radioMedia").is(":checked") == true)
                    agrupador = 'MEDIA';
                else
                if ($("#radioMaior").is(":checked") == true)
                    agrupador = 'MAIOR';
                else
                if ($("#radioMenor").is(":checked") == true)
                    agrupador = 'MENOR';
                if ($("#radioMinuto").is(":checked") == true)
                    tipodata = 'MINUTO';
                else
                if ($("#radioHora").is(":checked") == true)
                    tipodata = 'HORA';
                else
                if ($("#radioDia").is(":checked") == true)
                    tipodata = 'DIA';
                var periodo = $('#periodo').val();
                console.log('chegou');
                var aux = {
                    inicio: dtinicio,
                    fim: dtfim,
                    agrupador: agrupador,
                    tipodata: tipodata,
                    periodo: periodo,
                    dados: dataImp
                }

                 console.log(aux);
                $.get('/tccgiovani/index.php/monitoramentoPeriodico/calcula', aux, function (data) {
                    console.log("foi 2");
                   dataagroup=data;
                    if ($("#grafico_Tensao").is(":checked") == true) {
                        geraGraficoTensao(data);
                    }
                    if ($("#grafico_Corrente").is(":checked") == true) {
                        geraGraficoCorrente(data);
                    }

                }, 'JSON');

            } else {
                alert("selecione a opção Agrupar Valores!");
            }
        });













        function geraGraficoTensao(data2) {

            //grafico
            var options = {
                chart: {
                    renderTo: 'grafico',
                    type: 'line',
                    marginBottom: 25
                },
                title: {
                    text: 'Grafico de Tensao',
                    x: -20 //center
                },
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
                },
                series: []
            }



            //var da series
            var series = {
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

            $.each(data2.dado, function () {
                if(aux !== valnografico){
                series.data.push(parseFloat(this.TENSAO_RMS));
                axix.categories.push(this.DATAHORA);
                aux++;
            }
            });


            //plot do grafico de tensao
            options.xAxis.categories = axix['categories'];
            options.series[0] = series;
            chart = new Highcharts.Chart(options);

        }



        function geraGraficoCorrente(data2) {


            //grafico
            var options = {
                chart: {
                    renderTo: 'grafico',
                    type: 'line',
                    marginBottom: 25
                },
                title: {
                    text: 'Grafico de Corrente',
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
                        text: 'A'
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                },
                legend: {
                    enabled: false
                },
                series: []
            }



            //var da series
            var series = {
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
            var aux = 0;
            $.each(data2.dado, function () {
                if(aux !== valnografico){
                series.data.push(parseFloat(this.CORRENTE_RMS));
                axix.categories.push(this.DATAHORA);
                aux++;
            }
            });


            //plot do grafico de tensao
            options.xAxis.categories = axix['categories'];
            options.series[0] = series;
            chart = new Highcharts.Chart(options);

        }

    
    
    
    
    
    
        $('#attAut').change(function () {
            if ($("#attAut").is(":checked") == true) {
                console.log("ATT AUTOMATICAMENTO");
                 jQuery("[name = optradio]").attr('disabled',true);
                 jQuery("[name = optradio2]").attr('disabled',true);
                 jQuery("[name = che]").attr('disabled',true);
                 myvar = setInterval(gerarplot, 5000);
                 
                 
                  
            }else{
                  jQuery("[name = optradio]").attr('disabled',false);
                 jQuery("[name = optradio2]").attr('disabled',false);
                 jQuery("[name = che]").attr('disabled',false);               
                clearInterval(myvar);
            }
        });
       function gerarplot(){
          
          
           var options = {
                chart: {
                    renderTo: 'grafico',
                    type: 'line',
                    marginBottom: 25
                },
                title: {
                    text: 'Grafico de Corrente',
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
                        text: 'A'
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                },
                legend: {
                    enabled: false
                },
                series: []
            }



            //var da series
            var series = {
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

             $.get('/tccgiovani/index.php/monitoramentoPeriodico/attAutomatica', function (data) {
                     $.each(data.grafico, function (key, value) {
                     var potencia = (value.TENSAO_RMS * value.CORRENTE_RMS);
                    var tensaorms = value.TENSAO_RMS;
                    var correnterms = value.CORRENTE_RMS;
                    

                    table.row.add([
                        value.DATAHORA,
                        parseFloat(tensaorms).toFixed(2) + 'V',
                        parseFloat(correnterms).toFixed(2) + 'A'


                    ]).draw(false);
                });
//          
//            $.each(data2.dado, function () {
//
//                series.data.push(parseFloat(this.CORRENTE_RMS));
//                axix.categories.push(this.DATAHORA);
//            });
//
//
//            //plot do grafico de tensao
//            options.xAxis.categories = axix['categories'];
//            options.series[0] = series;
//            chart = new Highcharts.Chart(options);
//          
//           chart.series[0].addPoint();
                   
        }, 'JSON');
       }



    });

</script>