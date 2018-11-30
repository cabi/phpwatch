$(window).bind('keydown', function (event) {
    if (event.ctrlKey || event.metaKey) {
        switch (String.fromCharCode(event.which).toLowerCase()) {
            case 's':
                var $save = $('[data-command=\'save\']');
                if ($save.length === 1) {
                    event.preventDefault();
                    $save.trigger('click');
                }
                break;
            case 'n':
                var $new = $('[data-command=\'new\']');
                if ($new.length === 1) {
                    event.preventDefault();
                    $new.trigger('click');
                }
                break;
        }
    }

    var $escape = $('[data-command=\'escape\']');
    if (event.keyCode === 27 && $escape.length) {
        event.preventDefault();
        $escape.trigger('click');
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
    var stackedBar = new britecharts.stackedBar();
    stackedBar
        .width(1110)
        .height(400)
        .grid('horizontal');
    // .isAnimated(true);

    // danger, warning, secondary, info, success, light
    stackedBar.colorSchema(['#f5c6cb', '#ffeeba', '#d6d8db', '#bee5eb', '#c3e6cb', '#fdfdfe']);

    var dataset = [];
    $.getJSON(dataUri, function (data) {
        dataset = data;
        barContainer.datum(dataset).call(stackedBar);
        $('#' + selectorId + ' svg').addClass('figure-img img-fluid');
    });

}