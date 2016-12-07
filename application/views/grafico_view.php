
<body>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="col-md-10 col-xs-10 col-md-offset-1 " id="borda">


                <div class="modal fade  danger" id="MyModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header alert-warning">

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                                <h2 class="modal-title"><?php echo $this->lang->line('alerta'); ?>!</h2>

                            </div>
                            <div class="modal-body">

                                <p>    <?php echo $this->lang->line('date'); ?>: <a id="mdata"></a></p>
                                <p>    <?php echo $this->lang->line('tipo'); ?>: <a id="mtipoevt"></a></p>
                                <p>    <?php echo $this->lang->line('tensao'); ?>: <a id="mtensaorms"> V</a></p>
                                <p>    <?php echo $this->lang->line('corrente'); ?>: <a id="mcorrenterms"> A</a></p>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>

                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->






                <div class="col-md-3 col-xs-3">
                    <table id="myTable" class="table table-striped table-bordered sortable">
                        <caption><h2><?php echo $this->lang->line('ultevt'); ?></h2></caption>
                        <thead>

                            <tr class="col4">
                                <td><?php echo $this->lang->line('caracteristica'); ?></td>
                                <td><?php echo $this->lang->line('valor'); ?></td>
                            </tr>

                        </thead>


                        <tr><td><?php echo $this->lang->line('date'); ?></td>
                            <td id="data">oi</td></tr>
                        <tr><td><?php echo $this->lang->line('tipo'); ?></td>
                            <td id="tipoevt">oi</td></tr>
                        <tr><td><?php echo $this->lang->line('tensao'); ?></td>
                            <td id="tensaorms">oi</td></tr>
                        <tr><td><?php echo $this->lang->line('corrente'); ?></td>
                            <td id="correnterms">oi</td></tr>
                        <tr><td><?php echo $this->lang->line('fatorp'); ?></td>
                            <td id="fatorp">oi</td></tr>
                        <tr><td><?php echo $this->lang->line('potencia'); ?></td>
                            <td id="potencia">oi</td></tr>
                                
                    </table>
                    <?php echo $this->lang->line('att'); ?><input type="number" id="delay" value ="5" onchange="attdelay()"/>

                </div>
                <div class="col-md-9 col-xs-9"> 
                    <div class="col-md-12 col-xs-12">
                        <div class="col-md-6 col-xs-6" id="borda2">
                            <div  id="tensaoteste" style="width: '100%'"></div>
                        </div>
                        <div class="col-md-6 col-xs-6" id="borda2">
                            <div  id="correnteteste"></div>
                        </div>
                    </div>

                    <div class="col-md-12 col-xs-12">
                        <div class="col-md-6 col-xs-6" id="borda2">
                            <div  id="barratensao"></div>
                        </div>
                        <div class="col-md-6 col-xs-6"id="borda2">
                            <div  id="barracorrente"></div>
                        </div>
                    </div>

                </div>





            </div>
        </div>
    </div>
</body>

<script type="text/javascript">
//    var waiting = (document.getElementById('delay').value) * 1000;
//    function checadelay(){
//       
//        waiting = document.getElementById('delay').value;
//        waiting = waiting * 1000;
//        atualizar();
//    };
//
    var tempo = 5;
    var myvar;
    window.onload = function () {
        atualizar();
    };

    function attdelay() {
        tempo = document.getElementById('delay').value;
        clearInterval(myvar);

        myvar = setInterval(atualizar, 1000 * tempo);


    }

    myvar = setInterval(atualizar, 5000);
    var y = 0;
    var datatest = 0;
    function atualizar() {

        console.log(y);
        y++;
        //definindo intervalo de tempo para reload da funçao

        //setInterval(function () {


        //get é um ajax  simplificado, mais simples. onde recebe os dados no data
        $.get('http://localhost/tccgiovani/index.php/grafico/atualizagrafico', function (data) {

            //a series e a linha  nova que vai ta no highcrarts, onde eu guardo os valores vindo do php   dentro do series.data     
            if (data.rgrafico.grafico[0].DATAHORA !== datatest) {


                if (data.rgrafico.grafico[0].TIPO_EVENTO_CODIGO_EVT === "3" || data.rgrafico.grafico[0].TIPO_EVENTO_CODIGO_EVT === "4") {
                    console.log('e sim');
                    $('#mdata').html(data.rgrafico.grafico[0].DESCRICAO);
                    $('#mtipoevt').html(data.rgrafico.grafico[0].DATAHORA);
                    $('#mtensaorms').html(data.rgrafico.grafico[0].TENSAO_RMS);
                    $('#mcorrenterms').html(data.rgrafico.grafico[0].CORRENTE_RMS);
                    $('#MyModal').modal('show');
                }

                var phi = data.rgrafico.grafico[0].FI;
                var potencia = data.rgrafico.grafico[0].TENSAO_RMS * data.rgrafico.grafico[0].CORRENTE_RMS + " VA";
                $('#data').html(data.rgrafico.grafico[0].DESCRICAO);
                $('#tipoevt').html(data.rgrafico.grafico[0].DATAHORA);
                $('#tensaorms').html(data.rgrafico.grafico[0].TENSAO_RMS);
                $('#correnterms').html(data.rgrafico.grafico[0].CORRENTE_RMS);
                $('#fatorp').html(parseFloat(phi).toFixed(2));
                $('#potencia').html(potencia);

                //document.getElementById('tipoevt').innerHTML = data.rgrafico.grafico[0].DESCRICAO;
                //document.getElementById('tensaorms').innerHTML = data.rgrafico.grafico[0].TENSAO_RMS + " V";
                // document.getElementById('correnterms').innerHTML = data.rgrafico.grafico[0].CORRENTE_RMS + " A";
//                var phi = data.rgrafico.grafico[0].FI;
//                document.getElementById('fatorp').innerHTML = parseFloat(phi).toFixed(2);
//                var potencia = data.rgrafico.grafico[0].TENSAO_RMS * data.rgrafico.grafico[0].CORRENTE_RMS + " VA";
                //document.getElementById('potencia').innerHTML = potencia;

                var optionsTF = {
                    chart: {
                        renderTo: 'tensaoteste',
                        type: 'line',
                        marginBottom: 25
                    },
                    title: {
                        text: 'FO'
                    },
                    subtitle: {
                        text: 'Tensão'
                    },
                    yAxis: {
                        title: {
                            text: 'Volts'
                        }
                    },
                    xAxis: {
                        type: 'double',
                        categories: [0.0000, 0.0003, 0.0005, 0.0008, 0.0010, 0.0013, 0.0016, 0.0018, 0.0021, 0.0023, 0.0026, 0.0029, 0.0031, 0.0034, 0.0036, 0.0039, 0.0042, 0.0044, 0.0047, 0.0049, 0.0052, 0.0055, 0.0057, 0.0060, 0.0063, 0.0065, 0.0068, 0.0070, 0.0073, 0.0076, 0.0078, 0.0081, 0.0083, 0.0086, 0.0089, 0.0091, 0.0094, 0.0096, 0.0099, 0.0102, 0.0104, 0.0107, 0.0109, 0.0112, 0.0115, 0.0117, 0.0120, 0.0122, 0.0125, 0.0128, 0.0130, 0.0133, 0.0135, 0.0138, 0.0141, 0.0143, 0.0146, 0.0148, 0.0151, 0.0154, 0.0156, 0.0159, 0.0161, 0.0164],
                        title: {
                            text: 'Tempo/ms',
                        },
                    },
                    legend: {
                        enabled: false


                    },
                    series: []


                };

                var series = {
                    name: 'tensao',
                    data: [],
                    color: 'red'
                }
                //percorre os valores vindo do php e armazena  no series.data
                $.each(data.rgrafico.tensao, function (key, value) {
                    series.data.push(parseFloat(value));
                });





                optionsTF.series[0] = series;
                chart = new Highcharts.Chart(optionsTF);


                var optionsCF = {
                    chart: {
                        renderTo: 'correnteteste',
                        type: 'line',
                        marginBottom: 25
                    },
                    title: {
                        text: 'FO'
                    },
                    subtitle: {
                        text: 'Corrente'
                    },
                    yAxis: {
                        title: {
                            text: 'Amperes'
                        }
                    },
                    xAxis: {
                        type: 'double',
                        categories: [0.0000, 0.0003, 0.0005, 0.0008, 0.0010, 0.0013, 0.0016, 0.0018, 0.0021, 0.0023, 0.0026, 0.0029, 0.0031, 0.0034, 0.0036, 0.0039, 0.0042, 0.0044, 0.0047, 0.0049, 0.0052, 0.0055, 0.0057, 0.0060, 0.0063, 0.0065, 0.0068, 0.0070, 0.0073, 0.0076, 0.0078, 0.0081, 0.0083, 0.0086, 0.0089, 0.0091, 0.0094, 0.0096, 0.0099, 0.0102, 0.0104, 0.0107, 0.0109, 0.0112, 0.0115, 0.0117, 0.0120, 0.0122, 0.0125, 0.0128, 0.0130, 0.0133, 0.0135, 0.0138, 0.0141, 0.0143, 0.0146, 0.0148, 0.0151, 0.0154, 0.0156, 0.0159, 0.0161, 0.0164],
                        title: {
                            text: 'Tempo/ms',
                        },
                    },
                    legend: {
                        enabled: false
                    },
                    series: []


                };

                var series = {
                    name: 'valor',
                    data: [],
                    color: 'blue'
                }


                $.each(data.rgrafico.corrente, function (key, value) {
                    series.data.push(parseFloat(value));
                });

                // console.log(seriesc);

                optionsCF.series[0] = series;
                chart = new Highcharts.Chart(optionsCF);


                var optionsTC = {
                    chart: {
                        renderTo: 'barratensao',
                        type: 'column',
                        marginBottom: 25
                    },
                    title: {
                        text: 'Harmonicas'
                    },
                    credits: {
                        enabled: false
                    },
                    xAxis: {
                        categories: ['0', '60', '120', '180', '240', '300', '360', '420', '480', '540', '600', '660', '720'],
                        labels: {
                            rotation: -45
                        },
                        title: {
                            text: 'Frequencias (Hz)'
                        }
                    },
                    legend: {
                        y: 50,
//        enabled: false
                    },
                    yAxis: {
                        categories: null,
                        title: {
                            text: 'Módulo Normalizado (mA)'
                        }
                    },
                    tooltip: {
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    series: []
                };


                //harmonica barra
                var seriesht = {
                    name: 'valor',
                    data: [],
                    color: 'blue'
                }
                $.each(data.harmonicat, function (key, value) {
                    seriesht.data.push(parseFloat(value));

                });

                optionsTC.series[0] = seriesht;
                chart = new Highcharts.Chart(optionsTC);

                var optionsCC = {
                    chart: {
                        renderTo: 'barracorrente',
                        type: 'column',
                        marginBottom: 25
                    },
                    title: {
                        text: 'Harmonicas'
                    },
                    credits: {
                        enabled: false
                    },
                    xAxis: {
                        categories: ['60', '120', '180', '240', '300', '360', '420', '480', '540', '600', '660', '720'],
                        labels: {
                            rotation: -45
                        },
                        title: {
                            text: 'Frequencias (Hz)'
                        }
                    },
                    yAxis: {
                        categories: null,
                        title: {
                            text: 'Módulo Normalizado (mA)'
                        }
                    },
                    tooltip: {
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    series: []
                };
                //harmonica barra
                var serieshc = {
                    name: 'valor',
                    data: [],
                    color: 'blue'
                }
                $.each(data.harmonicac, function (key, value) {
                    serieshc.data.push(parseFloat(value));

                });

                optionsCC.series[0] = serieshc;
                chart = new Highcharts.Chart(optionsCC);


                datatest = data.rgrafico.grafico[0].DATAHORA;

            } else {
                console.log('iguais!');
            }

        }, 'JSON');
        //}, 5000);





    }
    ;






</script>