require('chosen-js/chosen.jquery');

class Chosen {
  static init() {
    $('.chosen-no-search').chosen({ disable_search: true });
  }
}

export default Chosen;
