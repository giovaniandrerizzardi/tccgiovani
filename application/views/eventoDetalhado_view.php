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
                <div class="col-md-6 col-xs-5">
                    <h2> Sumario</h2>
                    <ul class="list-group">   
                        <?php
                        foreach ($tipoevento as $dados) {
                            ?>


                            <li class="list-group-item"><?php echo $dados->DESCRICAO; ?>: <a id="<?php echo $dados->DESCRICAO; ?>"></a></li>


                        <?php };
                        ?>

                </div>
                <div class="col-md-6 col-xs-5">
                    <h2>Total</h2>

                    <ul class="list-group">
                        <li class="list-group-item">Tensao: <a id="totaltensao"></a></li>
                        <li class="list-group-item">Corrente: <a id="totalcorrente"></a></li>
                        <li class="list-group-item">Maior Tensao: <a id="maiortensao"></a></li>
                        <li class="list-group-item">Maior Corrente: <a id="maiorcorrente"></a></li>
                        <li class="list-group-item">Menor Tensao: <a id="menortensao"></a></li>
                        <li class="list-group-item">Menor Corrente: <a id="menorcorrente"></a></li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-md-12 col-xs-12" id="borda">
            <div class="col-md-5 col-xs-5">
                <div id="grafico">

                </div>
            </div>
            <div class="col-md-5 col-xs-5">
                <section class="container">
                    <div>
                        <select id="leftValues" size="10" multiple></select>
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
                        <div>
                            <input type="text" id="txtRight" />
                        </div>
                    </div>
                </section>

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

                    var data = new Date(value.DATAHORA);
                    var dia = data.getDate();
                    if (dia.toString().length == 1)
                        dia = "0" + dia;
                    var mes = data.getMonth() + 1;
                    if (mes.toString().length == 1)
                        mes = "0" + mes;
                    var ano = data.getFullYear();
                    var data_final = dia + "/" + mes + "/" + ano;

                    var hora = 0;
                    var minuto = 0;
                    var segundo = 0;

                    hora = data.getHours();
                    if (data.getHours() < 10)
                        hora = '0' + data.getHours();


                    minuto = data.getMinutes();
                    if (data.getMinutes() < 10)
                        minuto = '0' + data.getMinutes();

                    segundo = data.getSeconds();
                    if (data.getSeconds() < 10)
                        segundo = '0' + data.getSeconds();



                    data_final += ' - ' + hora + ':' + minuto + ':' + segundo;
                    //variavel global do arquivo inicializações.js
                    table.row.add([
                        data_final,
                        value.DESCRICAO,
                        parseFloat(tensaorms).toFixed(2) + 'kWh',
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
                yAxix:1,
                name:'tensao'
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

            if(tipodescircao === 'VOLT'){
                console.log('aki1');
                series.yAxix = 1;
                series.name='tensao';
            }else {
                console.log('aki2');
                series.yAxix = 2;
                series.color = 'blue';
                series.name='corrente'
            }

            //plot do grafico de tensao
            options.xAxis.categories = axix['categories'];
            options.series[0] = series;
           
            chart = new Highcharts.Chart(options);

        }

        function excluirGrafico() {
            alert(tipodografico);
        }


    });

</script>