var url = "http://localhost:8000";
var schedules = [];
var dentistId;

$(document).ready(function($){
    calendarInit();
});

function calendarInit()
{
    dentistId = $('#dentist span').attr('id');
    $.get(url+"/int/schedule/" + dentistId, function(data) {
        $.each(data, function(index, value) {
            schedules.push(value);
        });

        getHours(new Date());
        $('#selected-date').val(moment().format('YYYY-MM-DD'));
        //My function to intialize the datepicker
        $('#appointment-calendar').datepicker({
            inline: true,
            minDate: 0,
            firstDay:1,
            dateFormat: 'yy-mm-dd',
            beforeShowDay: highlightDays,
            onSelect: getHours,
        });
    });
}

/**
 * Highlights the days available for booking
 * @param  {datepicker date} date
 * @return {boolean, css}
 */
function highlightDays(date)
{
    date = moment(date).format('YYYY-MM-DD');
    for(var i = 0; i < schedules.length; i++) {
        work_date = moment(schedules[i].work_date).format('YYYY-MM-DD');
        if(work_date == date) {
            return[true, 'available'];
        }
    }
    return false;
}

/**
 * Gets times available for the day selected
 * Populates the day-times id with dates available
 */
function getHours(date)
{
    var dateSelected = moment(date).startOf('d');
    $('#selected-date').val(dateSelected.format('YYYY-MM-DD'));
    //calculate the hours and after that remove already taken
    var schedule = $.grep(schedules, function(s){return moment(s.work_date).isSame(dateSelected)});
    var hours = [];
    $.get(url+"/int/appointment/"+dentistId+"/"+moment(date).format('YYYY-MM-DD'), function(data) {
        var reservedHours = [];
        $.each(data, function(index, value) {
            reservedHours.push(moment(value.appointment_date + 'T' + value.appointment_time));
        });
        $.each(schedule, function(index,value){
            //calculate available hours
            var startTime = moment(value.work_date + 'T' + value.start_time);
            //if it's current date we should set the hours to book from 90 minutes ahead
            if(startTime.isBefore(moment())) {
                startTime = moment().add(90, 'm').startOf('hour');
            }
            var endTime = moment(value.work_date + 'T' + value.end_time);
            for(var i = startTime; i.isBefore(endTime); i = i.add(30, 'm')){
                isTaken = false;
                    $.each(reservedHours, function(index, value){
                    if(value.isSame(i)) {
                        isTaken = true;
                        return;
                    }
                });
                if(!isTaken) {
                    hours.push(moment(i).format('HH:mm'));
                }
            }
        });
        document.getElementById('daySelect').innerHTML = "Свободни часове за " + dateSelected.format("DD.MM.YYYY");
        $('#day-times').empty();
        $.each(hours, function(i, v){
            $("#day-times").append('<a id="'+ v +'" onclick="selectTime(this.id)">' + v + '</a><br>');
        });
    });
}

function selectTime(timeId){
    $('#selected-time').val(timeId);
}