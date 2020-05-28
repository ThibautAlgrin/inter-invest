import 'bootstrap';
import Form from './form';
import Version from './components/version';

const $ = require('jquery');
global.jQuery = $;
global.$ = $;

require('../images/logo.png');

if ($('form').length) {
    Form.init();
}

if ($('#version').length) {
    Version.init();
}
