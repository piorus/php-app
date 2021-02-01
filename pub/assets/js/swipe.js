$('#addComment').on('click', function(e){
    const swipeId = $('.swipe').data('id')
    const comment = $('#comment').val();

    const $button = $(this);
    const $form = $button.closest('form');

    if(!$form[0].checkValidity()) {
        return;
    }

    $button.attr('disabled', true);
    $button.html('Adding...')
    $button.html('<span class="spinner-border spinner-border-sm " role="status" aria-hidden="true"></span>');

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
        $button.attr('disabled', false);
        $button.html('Add Comment');
        $form.removeClass('was-validated');
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