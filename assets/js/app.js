import '../css/app.scss';

const $ = require('jquery');

require('bootstrap');
require("bootstrap-datepicker");

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();

    $('.js-datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
});