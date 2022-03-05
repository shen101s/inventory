$(document).ready(function() {
	'use strict';

    $('#l_barcodelist').addClass('active');


    $('#print').click(function(){
        $('#barcode_div').printThis();
    });


    $('body').bind('keydown', function(e){
        if(e.ctrlKey && e.keyCode == 80){
            $('#print').click();
            return false;
        }
    });

});

