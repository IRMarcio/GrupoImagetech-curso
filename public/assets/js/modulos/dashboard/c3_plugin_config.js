$(function () {

    c3.chart.internal.fn.getHorizontalAxisHeight = function (axisId) {
        var $$ = this, config = $$.config, h = 30;
        if (axisId === 'x' && !config.axis_x_show) {
            return 8;
        }
        if (axisId === 'x' && config.axis_x_height) {
            return config.axis_x_height;
        }
        if (axisId === 'y' && !config.axis_y_show) {
            return config.legend_show && !$$.isLegendRight && !$$.isLegendInset ? 10 : 1;
        }
        if (axisId === 'y2' && !config.axis_y2_show) {
            return $$.rotated_padding_top;
        }
        // Calculate x axis height when tick rotated
        if (axisId === 'x' && !config.axis_rotated && config.axis_x_tick_rotate) {
            h = 30 + $$.axis.getMaxTickWidth(axisId) * Math.cos(Math.PI * (90 - Math.abs(config.axis_x_tick_rotate)) / 180);
        }
        // Calculate y axis height when tick rotated
        if (axisId === 'y' && config.axis_rotated && config.axis_y_tick_rotate) {
            h = 30 + $$.axis.getMaxTickWidth(axisId) * Math.cos(Math.PI * (90 - Math.abs(config.axis_y_tick_rotate)) / 180);
        }
        return h + ($$.axis.getLabelPositionById(axisId).isInner ? 0 : 10) + (axisId === 'y2' ? -10 : 0);
    };

});