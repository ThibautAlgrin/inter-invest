import Datepicker from './components/datepicker';
import Collection from './components/collection';

class Form {
    static init() {
        Form.enableDatepicker();
        Form.enableCollection();
    }

    static enableDatepicker() {
        if ($('.air-datepicker').length > 0) {
            Datepicker.init();
        }
    }

    static enableCollection() {
        if ($('.add-another-collection-widget').length > 0) {
            Collection.init();
        }
    }
}

export default Form;
