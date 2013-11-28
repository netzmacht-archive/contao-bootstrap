$('body').on('hidden.bs.modal', '.modal-reloadable', function ()  {
    $(this).html('');
    $(this).removeData('bs.modal');
});