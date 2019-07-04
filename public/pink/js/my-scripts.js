jQuery(document).ready(function($) {

    $('.commentlist li').each(function(i) {

        $(this).find('div.commentNumber').text('#' + (i + 1));

    });

    $('#commentform').on('click', '#submit', function(e) {

        e.preventDefault();

        var form = $('#commentform');
        var comParent = $(this);

        $('.wrap_result').css('color', 'green')
                         .text('Saving...')
                         .fadeIn(500, function () {

                             var formData = form.serializeArray();

                             $.ajax({
                                 url : form.attr('action'),
                                 data : formData,
                                 headers: {
                                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                 },
                                 type: 'post',
                                 datatype: 'JSON',
                                 success: function (html) {
                                    if(html.error){

                                        $('.wrap_result').css('color','red').append('<br /><strong>Error:</strong>'+ html.error.join('<br />'));
                                        $('.wrap_result').delay(2000).fadeOut(500);

                                    }else if(html.success){

                                        $('.wrap_result').append('<br /><strong>Saved!</strong>')
                                            .delay(2000)
                                            .fadeOut(500, function() {
                                                if(html.data.parent_id > 0){
                                                    comParent.parents('div#respond').prev().after('<ul class="children">'+ html.comment +'</ul>')
                                                }else{
                                                    if($('#comments').has( 'ol.commentlist').length > 0){
                                                        $('ol.commentlist').append(html.comment);
                                                    }else{

                                                        $('#respond').before('<ol class="commentlist group">'+ html.comment +'</ol>');
                                                    }
                                                }

                                                $('#cancel-comment-reply-link').click();
                                            });

                                    }
                                 },
                                 error: function () {
                                     $('.wrap_result').css('color','red').append('<br /><strong>Error</strong>');
                                     $('.wrap_result').delay(2000).fadeOut(500, function() {
                                         $('#cancel-comment-reply-link').click();
                                     });
                                 }
                             });

                         });


    })


});