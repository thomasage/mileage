import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

import $ from 'jquery';
import 'bootstrap';

$(function () {

    $('tr[data-url]').on('click', (e) => {
        window.location.href = $(e.currentTarget).data('url');
    });

});
