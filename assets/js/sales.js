//# - ID
//. = class

var MONTHS = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
];

function months(config) {
    var cfg = config || {};
    var count = cfg.count || 12;
    var section = cfg.section;
    var values = [];
    var i, value;

    for (i = 0; i < count; ++i) {
        value = MONTHS[Math.ceil(i) % 12];
        values.push(value.substring(0, section));
    }

    return values;
}

function graphMonth(month) {
    var split_string = month.split("-");
    month = split_string[1];
    var year = split_string[0];
    var response_string;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            response_string = this.responseText;
        }
    };
    xhttp.open("POST", "analytics-process.php", false);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("month=" + month + "&year=" + year);

    return response_string;
}

function graphYear(year) {
    var response_string;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            response_string = this.responseText;
        }
    };
    xhttp.open("POST", "analytics-process.php", false);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("year=" + year);

    return response_string;
}

const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
                label: 'Total Revenue ($)',
                data: [],
                fill: false,
                borderColor: 'rgb(68, 114, 196)',
                tension: 0.1
            }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

$(document).ready(function () {

    $(document).on('change', '#month-year-selector', function () {
        if ($(this).val() == "month") {
            $('#month-div').removeAttr('hidden');
            $('#submit-div').removeAttr('hidden');
            $('#year-div').attr('hidden', 'true');
        }
        if ($(this).val() == "year") {
            $('#year-div').removeAttr('hidden');
            $('#submit-div').removeAttr('hidden');
            $('#month-div').attr('hidden', 'true');
        }
    });

    $(document).on('click', '#submit-button', function () {
        var attr = $('#month-div').attr('hidden');
        var return_string, return_array;

        // if month-div hidden attribute does not exist,
        // month-div is showing, and vice-versa
        if (typeof attr === 'undefined' || attr === false) {
            return_string = graphMonth($('#month-selected').val());
            return_array = return_string.split(",");

            var number_of_days = return_array.length;
            var days_array = [];
            for (let i = 0; i < number_of_days; i++) {
                days_array.push(i + 1);
            }
            
            myChart.data.labels = days_array;
            myChart.data.datasets[0].data = return_array;
            myChart.update();
                        
        } else {
            return_string = graphYear($('#year-selected').val());
            return_array = return_string.split(",");
            
            myChart.data.labels = months({count: 12});
            myChart.data.datasets[0].data = return_array;
            myChart.update();
        }
    });

});
