$(function () {
    $(document).ready(function () {
        CountDownTimer();
    });
});

CountDownTimer = () => {
    const due = $("#input_due").val();

    var end = new Date(due);
    var _second = 1000;
    var _minute = _second * 60;
    var _hour = _minute * 60;
    var _day = _hour * 24;
    var timer;
    function showRemaining() {
        const now = new Date();
        var distance = end - now;
        console.log(distance);
        if (distance <= 0) {
            clearInterval(timer);
            $("#countdown").text("Batas waktu telah habis!");
        } else {
            var hours = Math.floor((distance % _day) / _hour);
            var minutes = Math.floor((distance % _hour) / _minute);
            var seconds = Math.floor((distance % _minute) / _second);
            const countdown = hours + " : " + minutes + " : " + seconds;
            $("#countdown").text(countdown);
        }
    }

    timer = setInterval(showRemaining, 1000);
};
