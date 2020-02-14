import {REFERRALS_CONFIG} from "./config";

window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
} catch (e) {
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.baseURL = REFERRALS_CONFIG.API_URL;


window.logI = function (t) {
    console.log("%c Info message: " + t, "color:#fff; background-color: #6097D0; border-radius: 4px; padding: 4px;line-height: 14px;font-size:12px")
};
window.logE = function (t) {
    console.log("%c Error message: " + t, "color:#fff; background-color: tomato; border-radius: 4px; padding: 4px;line-height: 14px;font-size:12px")
};
window.logW = function (t) {
    console.log("%c Warning message: " + t, "color: black; background-color: #ffdb9a; border-radius: 4px; padding: 4px;line-height: 14px;font-size:12px")
};




// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
