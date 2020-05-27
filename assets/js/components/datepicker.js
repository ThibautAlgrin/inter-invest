require('air-datepicker');
require('air-datepicker/dist/js/i18n/datepicker.fr');

class Datepicker {
  static init() {
    let date = $('.air-datepicker');

    if (date.length > 0) {
      $.each(date, (key, item) => {
        let options = Object.assign($(item).data(), { language: 'fr' });

        if (options.min !== undefined) {
          options.minDate = new Date(options.min);
          delete options.min;
        }

        if (options.max !== undefined) {
          options.maxDate = new Date(options.max);
          delete options.max;
        }

        $(item).datepicker(options);
      });
    }
  }
}

export default Datepicker;
