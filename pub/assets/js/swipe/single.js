$('#addComment').on('click', function(e){
    const swipeId = $('.swipe').data('id')
    const comment = $('#comment').val();

    $.ajax({
        url: '/swipe/comment/create',
        method: 'POST',
        data: {
            swipeId: swipeId,
            comment: comment
        }
    }).done(function(response){

    })
});
