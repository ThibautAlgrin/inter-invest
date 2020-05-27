import 'bootstrap';
import Form from './form';

const $ = require('jquery');
global.jQuery = $;
global.$ = $;

if ($('form').length) {
    Form.init();
}
