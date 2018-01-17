var url = "http://localhost:8000";
var schedules = [];

$(document).ready(function($){
    calendarInit();
});

function calendarInit()
{
    $.get(url+"/int/schedule/" + 2, function(data) {
        $.each(data, function(index, value) {
            schedules.push(value);
        });

        getHours(new Date());
        //My function to intialize the datepicker
        $('#booking-calendar').datepicker({
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
 * Populates the daytimes id with dates available
 */
function getHours(date)
{
    var dateSelected = moment(date).startOf('d');
    //calculate the hours and after that remove already taken
    var schedule = $.grep(schedules, function(s){return moment(s.work_date).isSame(dateSelected)});
    var hours = [];
    $.get(url+"/int/appointment/2/"+date, function(data) {
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
        $('#dayTimes').empty();
        $.each(hours, function(i, v){
            $("#dayTimes").append('<a>' + v + '</a><br>');
        });
    });
}