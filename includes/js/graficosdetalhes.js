
   var optionsTF=  {
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
                text: 'Amperes'
            }
        },

         xAxis: {
           type:'double',
            categories:[0.0000,0.0003,0.0005,0.0008,0.0010,0.0013,0.0016,0.0018,0.0021,0.0023,0.0026,0.0029,0.0031,0.0034,0.0036,0.0039,0.0042,0.0044,0.0047,0.0049,0.0052,0.0055,0.0057,0.0060,0.0063,0.0065,0.0068,0.0070,0.0073,0.0076,0.0078,0.0081,0.0083,0.0086,0.0089,0.0091,0.0094,0.0096,0.0099,0.0102,0.0104,0.0107,0.0109,0.0112,0.0115,0.0117,0.0120,0.0122,0.0125,0.0128,0.0130,0.0133,0.0135,0.0138,0.0141,0.0143,0.0146,0.0148,0.0151,0.0154,0.0156,0.0159,0.0161,0.0164],
           title:{
               text: 'Tempo/ms',
           },
             },
             
       series:[]

        
    };
    
       var optionsCF=  {
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
           type:'double',
            categories:[0.0000,0.0003,0.0005,0.0008,0.0010,0.0013,0.0016,0.0018,0.0021,0.0023,0.0026,0.0029,0.0031,0.0034,0.0036,0.0039,0.0042,0.0044,0.0047,0.0049,0.0052,0.0055,0.0057,0.0060,0.0063,0.0065,0.0068,0.0070,0.0073,0.0076,0.0078,0.0081,0.0083,0.0086,0.0089,0.0091,0.0094,0.0096,0.0099,0.0102,0.0104,0.0107,0.0109,0.0112,0.0115,0.0117,0.0120,0.0122,0.0125,0.0128,0.0130,0.0133,0.0135,0.0138,0.0141,0.0143,0.0146,0.0148,0.0151,0.0154,0.0156,0.0159,0.0161,0.0164],
           title:{
               text: 'Tempo/ms',
           },
             },
             
       series:[]

        
    };

    
 var optionsTC=  {
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
			categories: ['0','60', '120', '180', '240', '300', '360', '420', '480', '540', '600', '660', '720'],
			labels:{
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
        series:[]
    };
    
    var optionsCC=  {
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
			labels:{
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
        series:[]
    };
    
    
    // ULTIMO EVENTO - FIM
    
    
    
    

    
