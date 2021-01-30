$('.submit').on('click', function(e){
    e.preventDefault();
    $(this).closest('form').submit();
});
