import $ from 'jquery';
import HomeApp from './js/Components/HomeApp';
import HomeAppGap from './js/Components/HomeAppGap';

import './styles/home.scss';

$(function () {

    $('#car').on('change', (e) => {
        window.location.href = `/${e.target.value}`;
    });

    let $wrapper = $('#primaryChart');
    if ($wrapper.length === 1) {
        new HomeApp($wrapper);
    }

    $wrapper = $('#secondaryChart');
    if ($wrapper.length === 1) {
        new HomeAppGap($wrapper);
    }

});
