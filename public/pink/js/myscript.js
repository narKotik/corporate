jQuery('document').ready(function ($) {
    function updateCountsOfComments() {
        $('ol.commentlist li').each(function (i) {
            $(this).find('div.commentNumber').text('#' + (i + 1))
        });
    }

    function clearForm() {
        $('#comment_post_ID').val('');
        $('#comment_parent').val('');
        $('#name').val('');
        $('#email').val('');
        $('#text').val('');
        $('#cancel-comment-reply-link').click();
    }

    function findArticleUserId() {
        return $('#user').data('userId');
    }

    updateCountsOfComments();

    $('#commentform');
    $('#submit').on('click', function (e) {
        e.preventDefault();

        var comParent = $('#commentform');

        $('.wrap_result').fadeIn(500, function () {
            var data = comParent.serializeArray();
            $.ajax({
                'url': comParent.attr('action'),
                'data': data,
                'type': 'post',
                'datatype': 'json',
                'success': function (response) {
                    if (response.success) {
                        $('.wrap_result')
                            .text('Сохранено!')
                            .fadeOut(1500, function () {
                                var userArticleId = findArticleUserId();
                                var userId = response.data['user_id'];

                                if (userArticleId == userId){
                                    response.html = response.html.replace('comment even', 'comment bypostauthor odd');
                                }

                                if (response.data.parent_id > 0) {

                                    comParent.parents('div#respond')
                                        .prev()
                                        .after('<ul class="children">' + response.html + '</ul>');
                                } else {
                                    if ($('ol.commentlist').length) {
                                        $('ol.commentlist').append(response.html);
                                    } else {
                                        $('#respond').before('<ol class="commentlist group">' + response.html + '</ol>');
                                    }
                                }

                                updateCountsOfComments();
                                clearForm();

                                //'comment even' + 'bypostauthor odd'
                            });
                    } else if (response.error) {
                        $('.wrap_result')
                            .css('color','red')
                            .css('height', response.error.length*20 + 'px')
                            .html('Ошибка ' + response.error.join('<br>'));
                        $('.wrap_result').delay(response.error.length*1000).fadeOut(500);
                    }

                },
                'error': function () {
                    $('.wrap_result')
                        .css('color','red')
                        .text('Ошибка, попробуйте позже!');
                    $('.wrap_result').delay(2000).fadeOut(500);
                },
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }).css('color', 'green').text('Сохранение комментария');
    });

});
