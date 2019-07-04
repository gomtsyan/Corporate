@if($data)


        <li id="li-comment-{{ $data['id'] }}" class="comment even borGreen">
            <div id="comment-{{ $data['id'] }}" class="comment-container">
                <div class="comment-author vcard">
                    <img alt="" src="{{ asset(config('settings.theme')) }}/images/avatar/unknow.png" class="avatar" height="75" width="75" />
                    <cite class="fn">{{ $data['name'] }}</cite>
                </div>
                <!-- .comment-author .vcard -->
                <div class="comment-meta commentmetadata">
                    <div class="intro">
                        <div class="commentDate">

                        </div>
                        <div class="commentNumber">#&nbsp;</div>
                    </div>
                    <div class="comment-body">
                        <p>{{ $data['text'] }}</p>
                    </div>
                    <div class="reply group">
                        <a class="comment-reply-link" href="#respond" onclick="return addComment.moveForm(&quot;comment-{{ $data['id'] }}&quot;, &quot;{{ $data['id'] }}&quot;, &quot;respond&quot;, &quot;{{ $data['article_id'] }}&quot;)">Reply</a>
                    </div>
                    <!-- .reply -->
                </div>
                <!-- .comment-meta .commentmetadata -->
            </div>
            <!-- #comment-##  -->

        </li>

@endif