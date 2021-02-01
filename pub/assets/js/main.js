$('.delete').on('click', function(e){
    e.preventDefault();
    $(this).closest('.actions').find('.deleteForm').submit();
});
