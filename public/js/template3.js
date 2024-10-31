jQuery( document ).ready(function() {
    jQuery('[data-time]').each(function() {
        var $this = jQuery(this), finalDate = jQuery(this).data('time');
        var target_date = new Date().getTime() + (1000*finalDate); // set the countdown date
        var days, hours, minutes, seconds; // variables for time units

        getCountdown();

        setInterval(function () { getCountdown(); }, 1000);

        function getCountdown(){

            // find the amount of "seconds" between now and target
            var current_date = new Date().getTime();
            if((target_date - current_date) > 0){
                var seconds_left = (target_date - current_date) / 1000;

                days = pad( parseInt(seconds_left / 86400) );
                seconds_left = seconds_left % 86400;
                     
                hours = pad( parseInt(seconds_left / 3600) );
                seconds_left = seconds_left % 3600;
                      
                minutes = pad( parseInt(seconds_left / 60) );
                seconds = pad( parseInt( seconds_left % 60 ) );

                // format countdown string + set tag value
                $this.find(".tiles").html("<span>" + days + "</span><span>" + hours + "</span><span>" + minutes + "</span><span>" + seconds + "</span>");
            }else{
                window.location.reload();
            }
        }

        function pad(n) {
            return (n < 10 ? '0' : '') + n;
        }
    });
});