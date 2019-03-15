$(document).on('click', '[data-cart-edit]', function(e) {
    let form = $(this).closest('tr').find('form');
    form.submit();
});

$(document).on('click', '[data-cart-delete]', function(e) {
    let form = $(this).closest('tr').find('form');
    form.find('input[name=amount]').val(0);
    form.submit();
});

$(document).on('change', '[data-address-selector]', function(e) {
    let address = $(this).find('option:selected').data('address');
    let selector = $(this).data('address-selector');
    console.log(address);
    if(!address) {
        $('input[name^="' + selector + '"]').val('');
    }
    $.each(address, function(index, value) {
        $(':input[name="' + selector + '[' + index + ']"]').val(new String(value ? value : '').trim());
    });
});