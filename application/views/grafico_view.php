
<body>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="col-md-10 col-xs-10 col-md-offset-1 " id="borda">


                <div class="col-md-5 col-xs-5">
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
                        <tr><td><?php echo $this->lang->line('tensao'); ?></td>
                            <td id="tensaorms">oi</td></tr>
                        <tr><td><?php echo $this->lang->line('corrente'); ?></td>
                            <td id="correnterms">oi</td></tr>
                        <tr><td><?php echo $this->lang->line('fatorp'); ?></td>
                            <td id="potencia">oi</td></tr>

                    </table>
                    <input type="number" id="delay" value ="5" onchange="attdelay()"/>
                   
                     </div>
                 <div class="col-md-5 col-xs-5"> 
                
                <div class="col-md-10 col-xs-5">
                    <div  id="tensaoteste" style="width: '100%'"></div>
                </div>
                <div class="col-md-10 col-xs-5">
                    <div  id="correnteteste"></div>
                </div>
                     </div>
                <div class="col-md-5 col-xs-5">
                    <div  id="barratensao"></div>
                </div>
                <div class="col-md-5 col-xs-5">
                    <div  id="barracorrente"></div>
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
    window.onload=function(){
        atualizar();
    };
    
    
    function attdelay(){
      tempo = document.getElementById('delay').value; 
      clearInterval(myvar);
      
      myvar = setInterval(atualizar,1000*tempo);
      
    
    }
    
 myvar =setInterval(atualizar,5000);
var y=0;
    function atualizar() {

      console.log(y);
      y++;
        //definindo intervalo de tempo para reload da funçao

        //setInterval(function () {
            
        
            //get é um ajax  simplificado, mais simples. onde recebe os dados no data
            $.get('http://localhost/teste/index.php/grafico/atualizagrafico', function (data) {
                //a series e a linha  nova que vai ta no highcrarts, onde eu guardo os valores vindo do php   dentro do series.data     
             
                    
                
                //preenchiment da tabela data.rgrafico.grafico[0].TENSAO_RMS;

                document.getElementById('data').innerHTML = data.rgrafico.grafico[0].DATAHORA;
                document.getElementById('tensaorms').innerHTML = data.rgrafico.grafico[0].TENSAO_RMS;
                document.getElementById('correnterms').innerHTML = data.rgrafico.grafico[0].CORRENTE_RMS;
                var potencia = data.rgrafico.grafico[0].TENSAO_RMS * data.rgrafico.grafico[0].CORRENTE_RMS;
                document.getElementById('potencia').innerHTML = potencia;
               
                var series = {
                    name: 'tensao',
                    data: [],
                    color: 'red'
                }
                //percorre os valores vindo do php e armazena  no series.data
                $.each(data.rgrafico.tensao, function (key, value) {
                    series.data.push(parseFloat(value));
                });

                //console.log(series);
                //alert(1);
                //  alert(data);

                var chart = $('#tensaoteste').highcharts();
                if (chart.series.length) {
                    chart.series[0].remove();
                }
                //insere
                chart.addSeries(series);

                var series = {
                    name: 'valor',
                    data: [],
                    color: 'blue'
                }


                $.each(data.rgrafico.corrente, function (key, value) {
                    series.data.push(parseFloat(value));
                });

                // console.log(seriesc);
                

                var charts = $('#correnteteste').highcharts();
                if (charts.series.length) {
                    charts.series[0].remove();
                }

                //insere
                charts.addSeries(series);

                
                //harmonica barra
                 var seriesht = {
                    name: 'valor',
                    data: [],
                    color: 'blue'
                }
                $.each(data.harmonicat, function (key, value) {
                    seriesht.data.push(parseFloat(value));
                    
                });

                var chart = $('#barratensao').highcharts();
                if (chart.series.length) {
                    chart.series[0].remove();
                    
                }
                //insere
                chart.addSeries(seriesht);

              
              //harmonica barra
                 var serieshc = {
                    name: 'valor',
                    data: [],
                    color: 'blue'
                }
                $.each(data.harmonicac, function (key, value) {
                    serieshc.data.push(parseFloat(value));
                    
                });

                var chart = $('#barracorrente').highcharts();
                if (chart.series.length) {
                    chart.series[0].remove();
                    
                }
                insere
                chart.addSeries(serieshc);


        

            }, 'JSON');
        //}, 5000);





    };

    
    
     


</script>