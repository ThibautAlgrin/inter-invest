class Version {
  static init() {
    $('#version').change((e) => {
      $(e.currentTarget).parents('form').submit();
    });
  }
}

export default Version;
