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
        $('.comments').append(response.html);
        $('#comment').val('');
    })
});

$('.deleteComment').on('click', function(e){
   e.preventDefault();

    const comment = $(this).closest('.comment');

    $.ajax({
        url: '/swipe/comment/delete',
        method: 'POST',
        data: {
            commentId: comment.data('id'),
        }
    }).done(function(response){
        if(response.success) {
            comment.remove();
        }
    })
});