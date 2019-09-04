$(document).ready(function($){
    $.ajax({
        url: "/weekly_retention",
        context: document.body
    }).done(function(result) {
        if(result.err == false) {
            $('#weekly_cohort').highcharts(JSON.parse(result.data));
        }
    });
});