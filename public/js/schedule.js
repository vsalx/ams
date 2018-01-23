$(document).ready(function($){
    calendarInit();
});

function calendarInit() {
    $('#schedule #date').datepicker({
        inline: false,
        minDate: 0,
        firstDay:1,
        dateFormat: 'yy-mm-dd',
        numberOfMonths:1
    });
}