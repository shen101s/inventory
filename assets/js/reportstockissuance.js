$(document).ready(function() {
	$('#l_report_stockissuance').addClass('active');

    $('#navreport').attr('aria-expanded', true);
    $('#lib-collapse').attr('aria-expanded', true);

    $('#lib-collapse').addClass('collapse in');

    $('#navreport').removeClass('arrow-right');
    $('#navreport').addClass('arrow-down');

    $('#trandate_s').datepicker({ format: 'M dd, yyyy' });
    $('#trandate_e').datepicker({ format: 'M dd, yyyy' });

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

