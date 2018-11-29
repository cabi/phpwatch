$(window).bind('keydown', function (event) {
    if (event.ctrlKey || event.metaKey) {
        switch (String.fromCharCode(event.which).toLowerCase()) {
            case 's':
                if ($('[data-command=\'save\']').length === 1) {
                    event.preventDefault();
                    $('[data-command=\'save\']').trigger('click');
                }
                break;
            case 'n':
                if ($('[data-command=\'new\']').length === 1) {
                    event.preventDefault();
                    $('[data-command=\'new\']').trigger('click');
                }
                break;
        }
    }

    if (event.keyCode === 27 && $('[data-command=\'escape\']').length) {
        event.preventDefault();
        $('[data-command=\'escape\']').trigger('click');
    }
});

$(function () {
    $('.chart').each(function (i, item) {
        var id = $(item).attr('id');
        var dataUri = $(item).attr('data-chart-uri');
        buildBarChart(id, dataUri);
    });
});

function buildBarChart(selectorId, dataUri) {
    var barContainer = d3.select('#' + selectorId);
    var barChart = new britecharts.bar();
    barChart
        .width(1110)
        .height(400)
        .labelsNumberFormat('.0%')
        .enableLabels(true)
        .isAnimated(true);


    var dataset = [];
    d3.json(dataUri).then(function (data) {
        dataset = data;
        barContainer.datum(dataset).call(barChart);
    });

}