$(document).ready(function() {
	$('#l_report_stockinventory').addClass('active');

    $('#navreport').attr('aria-expanded', true);
    $('#lib-collapse').attr('aria-expanded', true);

    $('#lib-collapse').addClass('collapse in');

    $('#navreport').removeClass('arrow-right');
    $('#navreport').addClass('arrow-down');


    $('#print').click(function(){
        $('.c-report-print-div').printThis();
    });

    $('body').bind('keydown', function(e){
        if(e.ctrlKey && e.keyCode == 80){
            $('#print').click();
            return false;
        }
    });
});

