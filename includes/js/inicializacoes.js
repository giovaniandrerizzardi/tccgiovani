/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
   $('input[type="date"]').attr('type', 'text').bootstrapMaterialDatePicker({format : 'YYYY-MM-DD HH:mm:ss'});
   $('input[type="date_day"]').attr('type', 'text').bootstrapMaterialDatePicker({format : 'YYYY-MM-DD', time: false});
    $('input[type="date_month"]').attr('type', 'text').bootstrapMaterialDatePicker({format : 'YYYY-MM', time: false});

    
    //   var table = $('table').DataTable();;
   
   
//   var refreshId = setInterval(function(){ 
//        $('.dtp').addClass('hidden');
//        if ($('.dtp').hasClass('hidden')) {
//            clearInterval(refreshId);
//        }
//   }, 1);
});


