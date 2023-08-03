import './bootstrap';
import './scss/app.scss';
import 'flatpickr';

require('jquery');

// this loads jquery, but does *not* set a global $ or jQuery variable
const $ = require('jquery');
// create global $ and jQuery variables
global.$ = global.jQuery = $;


