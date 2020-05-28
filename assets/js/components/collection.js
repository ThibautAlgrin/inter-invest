class Collection {
    static init() {
        $('.add-another-collection-widget').click(() => {
            let list = $('#address-fields-list');
            let counter = list.data('widget-counter') || list.children().length;
            let newWidget = list.attr('data-prototype');

            newWidget = newWidget.replace(/__name__/g, counter);
            list.data('widget-counter', ++counter);
            $(newWidget).appendTo(list);
        });

        $('.remove-collection-widget').click((e) => {
            e.preventDefault();
            $(e.currentTarget).parent().parent().remove();

            return false;
        });
    }
}

export default Collection;
