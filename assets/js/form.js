import Chosen from './components/chosen';
import Datepicker from './components/datepicker';
import Collection from './components/collection';

class Form {
    static init() {
        Form.enableSelect();
        Form.enableDatepicker();
        Form.enableCollection();
    }

    static enableSelect() {
        if ($('.chosen-no-search').length > 0) {
            Chosen.init();
        }
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
