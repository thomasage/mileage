import $ from 'jquery';

import '../scss/app.scss';

$(function () {

    $('tr[data-url]').on('click', (e) => {
        window.location.href = $(e.currentTarget).data('url');
    });

});
