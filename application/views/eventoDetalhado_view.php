<div class="container-fluid">
    <div class="row-fluid">

        <div class="col-md-7 col-xs-7 mb-30" id="borda">
            <div class="inline" > 
                <h4 class="form-signin-heading pull-left"><?php echo $this->lang->line('firstDate') . ":"; ?></h4>
                <input id="firstdate" type="date" class="form-control pull-left" placeholder="<?php echo $this->lang->line('firstDate'); ?>" required name="date">
                <h4 class="form-signin-heading pull-left" style="margin-left:50px"><?php echo $this->lang->line('endDate') . ":"; ?></h4>
                <input id="enddate" type="date" class="form-control pull-left" placeholder="<?php echo $this->lang->line('endDate'); ?>" required name="date">
            </div> 
            <button id="click_me" type="button" style="width:80px; height: 30px; margin-left:50px">Buscar!</button>


        </div>
        <div class="col-md-12 col-xs-12" id="borda">
            <div class="col-md-6 col-xs-6">
                <h2><?php echo $this->lang->line('tabela'); ?></h2>
                <table id="tabelaseventos" class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th style="width: 140px;"><?php echo $this->lang->line('Data'); ?></th>
                            <th><?php echo $this->lang->line('tipoevento'); ?></th>
                            <th><?php echo $this->lang->line('tensao'); ?></th>
                            <th><?php echo $this->lang->line('corrente'); ?></th>
                            <th><?php echo $this->lang->line('fatorpotencia'); ?></th>
                            <th><?php echo $this->lang->line('potencia'); ?></th>

                        </tr>
                    </thead>
                    <tbody id="tbodyloco"></tbody>
<!--                    <tbody id="tbodyTipoEvento"></tbody>
                    <tbody id="tbodyTensao"></tbody>
                    <tbody id="tbodyCorrente"></tbody>
                    <tbody id="tbodyFatorPotencia"></tbody>
                    <tbody id="tbodyPotencia"></tbody>-->
                </table>

            </div>

            <div class="col-md-6 col-xs-6">
                <div class="col-md-4 col-xs-4 col-md-offset-1">
                    <h2> <?php echo $this->lang->line('sumario'); ?></h2>
                    <ul class="list-group">   
                        <?php
                        foreach ($tipoevento as $dados) {
                            ?>


                            <li class="list-group-item"><?php echo $dados->DESCRICAO; ?>: <a id="<?php echo $dados->DESCRICAO; ?>"></a></li>


                        <?php };
                        ?>

                </div>
                <div class="col-md-3 col-xs-3">
                    <h2><?php echo $this->lang->line('total'); ?></h2>

                    <ul class="list-group">
                        <li class="list-group-item"><?php echo $this->lang->line('tensao'); ?>: <a id="totaltensao"></a></li>
                        <li class="list-group-item"><?php echo $this->lang->line('corrente'); ?>: <a id="totalcorrente"></a></li>
                        <li class="list-group-item"><?php echo $this->lang->line('maiortensao'); ?>: <a id="maiortensao"></a></li>
                        <li class="list-group-item"><?php echo $this->lang->line('maiorcorrente'); ?>: <a id="maiorcorrente"></a></li>
                        <li class="list-group-item"><?php echo $this->lang->line('menortensao'); ?>: <a id="menortensao"></a></li>
                        <li class="list-group-item"><?php echo $this->lang->line('menorcorrente'); ?>: <a id="menorcorrente"></a></li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-md-12 col-xs-12" id="borda">
            <div class="col-md-6 col-xs-6 mb-30">
                <h2><?php echo $this->lang->line('grafico'); ?></h2>
                <div class="col-md-12 col-xs-12 mb-30">
                    <div id="grafico">

                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-3 col-md-offset-1">
                 <h3><?php echo $this->lang->line('pgrafico'); ?></h3>
                <div class="col-md-9 col-xs-9" id="borda2">
                   
                    <label class="radio-inline"><input id="grafico_Corrente" type="radio" name="optradiort" checked><?php echo $this->lang->line('graficoCorrente'); ?></label>
                    <label class="radio-inline"><input id="grafico_Tensao" type="radio" name="optradiort"><?php echo $this->lang->line('graficoTensao'); ?></label>
                    &nbsp;
                    &nbsp;

                    <section class="container">



                        <div>
                            <select id="leftValues" size="2" multiple></select>
                        </div>
                        <div>
                            <input type="button" id="btnLeft" value="&lt;&lt;" />
                            <input type="button" id="btnRight" value="&gt;&gt;" />
                        </div>
                        <div>
                            <select id="rightValues" size="10" multiple>
                                <?php
                                foreach ($tipoevento as $dados) {
                                    ?>
                                    <option><?php echo $dados->DESCRICAO; ?></option>
                                <?php };
                                ?>      

                            </select>

                        </div>
                    </section>

                </div>
            </div>


        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        var data2;
        var tipodografico;
        var table = $('table').DataTable();


        $("#btnLeft").click(function () {
            if (data2 !== null) {
                var selectedItem = $("#rightValues option:selected");
                tipodografico = $("#rightValues option:selected").text();
                $("#leftValues").append(selectedItem);
                tipodografico.trim();// tira os espaçamentos   ridiculos
                console.log(tipodografico);
                geraGrafico();
            }
        });

        $("#btnRight").click(function () {
            var selectedItem = $("#leftValues option:selected");
            tipodografico = $("#leftValues option:selected").text();
            $("#rightValues").append(selectedItem);
            tipodografico.trim();
            excluirGrafico();
        });

        $("#rightValues").change(function () {
            var selectedItem = $("#rightValues option:selected");
            $("#txtRight").val(selectedItem.text());
        });



        $('#click_me').click(function () {
            var dtinicio = $('#firstdate').val();
            var dtfim = $('#enddate').val();

            //get é um ajax  simplificado, mais simples. onde recebe os dados no data
            $.get('http://localhost/tccgiovani/index.php/eventoDetalhado/getData', {inicio: dtinicio, fim: dtfim}, function (data) {
                data2 = data;
                $('#tbodyloco').closest('tr').remove();
                //preenche a tabela com os dados
                var html = '';
                table.clear();
                $.each(data.dado, function (key, value) {

                    var potencia = (value.TENSAO_RMS * value.CORRENTE_RMS);
                    var tensaorms = value.TENSAO_RMS;
                    var correnterms = value.CORRENTE_RMS;
                    var fi = value.FI;

//                    var data = new Date(value.DATAHORA);
//                    var dia = data.getDate();
//                    if (dia.toString().length == 1)
//                        dia = "0" + dia;
//                    var mes = data.getMonth() + 1;
//                    if (mes.toString().length == 1)
//                        mes = "0" + mes;
//                    var ano = data.getFullYear();
//                    var data_final = dia + "/" + mes + "/" + ano;
//
//                    var hora = 0;
//                    var minuto = 0;
//                    var segundo = 0;
//
//                    hora = data.getHours();
//                    if (data.getHours() < 10)
//                        hora = '0' + data.getHours();
//
//
//                    minuto = data.getMinutes();
//                    if (data.getMinutes() < 10)
//                        minuto = '0' + data.getMinutes();
//
//                    segundo = data.getSeconds();
//                    if (data.getSeconds() < 10)
//                        segundo = '0' + data.getSeconds();
//
//
//
//                    data_final += ' - ' + hora + ':' + minuto + ':' + segundo;
                    //variavel global do arquivo inicializações.js
                    table.row.add([
                        //data_final,
                        value.DATAHORA,
                        value.DESCRICAO,
                        parseFloat(tensaorms).toFixed(2) + ' V',
                        parseFloat(correnterms).toFixed(2) + 'A',
                        parseFloat(fi).toFixed(2),
                        potencia.toFixed(2)

                    ]).draw(false);

                });
//            $('#tbodyloco').html(html);
//            $('table').DataTable();




                $.each(data.tipos, function (key, value) {
                    var id = '#' + value.DESCRICAO;
                    $(id).html(value.quantidade);
                });

                $('#totaltensao').html(data.dados.totaltensao);
                $('#totalcorrente').html(data.dados.totalcorrente);
                $('#maiortensao').html(data.dados.maiortensao);
                $('#menortensao').html(data.dados.menortensao);
                $('#maiorcorrente').html(data.dados.maiorcorrente);
                $('#menorcorrente').html(data.dados.menorcorrente);


            }, 'JSON');

        });



        function geraGrafico() {


            //grafico
            var options = {
                chart: {
                    renderTo: 'grafico',
                    type: 'line',
                    marginBottom: 25
                },
                title: {
                    text: 'GRAFICO',
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
                yAxis: [{
                        title: {
                            text: 'VOLTS'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#00FF00'
                            }]
                    }, {
                        gridLineWidth: 0,
                        title: {
                            text: 'AMPERES'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }],
                        opposite: true
                    }],
                legend: {
                    enabled: false
                },
                series: []
            }



            //var da series
            var series = {
                data: [],
                color: 'red',
                yAxix: 1,
                name: 'tensao'
            };

            var axix = {
                categories: [],
                type: 'datetime',
                dateTimeLabelFormats: {
                    month: '%b \'%y'
                }

            };
            var tipodescircao;
            $.each(data2.dado, function () {
                // console.log(tipodografico);
                console.log(this.TENSAO_RMS);
                if (this.DESCRICAO === tipodografico) {

                    tipodescircao = this.MEDIDOR;
                    // alert(this.toString());

                    series.data.push(parseFloat(this.TENSAO_RMS));
                    axix.categories.push(this.DATAHORA);

                }

            });

            if (tipodescircao === 'VOLT') {
                console.log('aki1');
                series.yAxix = 1;
                series.name = 'tensao';
            } else {
                console.log('aki2');
                series.yAxix = 2;
                series.color = 'blue';
                series.name = 'corrente'
            }

            //plot do grafico de tensao
            options.xAxis.categories = axix['categories'];
            options.series[0] = series;

            chart = new Highcharts.Chart(options);

        }

        function excluirGrafico() {
            //grafico
            var options = {
                chart: {
                    renderTo: 'grafico',
                    type: 'line',
                    marginBottom: 25
                },
                title: {
                    text: 'GRAFICO',
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
                yAxis: [{
                        title: {
                            text: 'VOLTS'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#00FF00'
                            }]
                    }, {
                        gridLineWidth: 0,
                        title: {
                            text: 'AMPERES'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }],
                        opposite: true
                    }],
                legend: {
                    enabled: false
                },
                series: []
            }



            //var da series
            var series = {
                data: [0],
                color: 'red',
                yAxix: 1,
                name: 'tensao'
            };

            var axix = {
                categories: [0],
                type: 'datetime',
                dateTimeLabelFormats: {
                    month: '%b \'%y'
                }

            };



            //plot do grafico de tensao
            options.xAxis.categories = axix['categories'];
            options.series[0] = series;

            chart = new Highcharts.Chart(options);

        }


        $(document).on('click', '.paginate_button', function () {

            if ($("#grafico_Tensao").is(":checked") == true) {
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

                //0 e data, 1 e consumo  e 2 e tensao
                $('#tbodyloco tr').each(function () {
                    dados = table.row(this).data();
                    var t = dados[2].split(" ");
                    //console.log(t[0]);
                    series.data.push(parseFloat(t[0]));
                    axix.categories.push(dados[0]);
                });
                options.xAxis.categories = axix['categories'];
                options.series[0] = series;
                chart = new Highcharts.Chart(options);

            } else {
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


                $('#tbodyloco tr').each(function () {
                    dados = table.row(this).data();
                    var t = dados[3].split(" ");
                    //console.log(t[0]);
                    series.data.push(parseFloat(t[0]));
                    axix.categories.push(dados[0]);
                });
                options.xAxis.categories = axix['categories'];
                options.series[0] = series;
                chart = new Highcharts.Chart(options);


            }



        });
    });

</script>