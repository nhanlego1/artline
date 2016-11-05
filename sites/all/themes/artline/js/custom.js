(function ($) {

    Drupal.behaviors.initArtline = {
        attach: function (context, settings) {

           // plugin pinto
           //  $(".plugin").pinto({
           //      itemWidth: 415,
           //      gapX: 5,
           //      gapY: 30,
           //  });
            // end plugin pinto

            var hooks = $('.hooks');
            var hookWidth = hooks.outerWidth();
            var winWidth = $(window).outerWidth();
            if (winWidth > 767) {
                $('.change').css({'left': '120px'});
                $('.hide-menu').click(function () {
                    hooks.toggleClass('hides');
                    if (hooks.hasClass('hides')) {
                        $('.hides').css({'left': -hookWidth});
                        $('.change').css({'left': '0'});
                    } else {
                        hooks.css({'left': 0});
                        var rowWidth = $('.change').outerWidth();
                        $('.change').css({'left': '120px'});
                    }
                });
            }
            else {
                hooks.css({'left': -304});
                hooks.addClass('hides');
                $('.change').css({'left': '0px'});
                $('.hide-menu').click(function () {
                    hooks.toggleClass('hides');
                    if (hooks.hasClass('hides')) {
                        $('.hides').css({'left': -hookWidth});
                    } else {
                        hooks.css({'left': 0});
                    }
                });
            }

            $('.load-more').delegate('.load-btn', 'click', function () {
                $('.data').children().clone().appendTo('.plugin');
                $(".plugin").pinto({
                    itemWidth: 415,
                    gapX: 5,
                    gapY: 30,
                });
            });

            $(window).resize(function () {
                $(function () {
                    var hooks = $('.hooks');
                    var winWidth = $(window).width();
                    var hooksWidth = hooks.outerWidth();
                    if (winWidth > 767) {
                        $('.hides').css({'left': 0});
                        $('.change').css({'left': '120px'});
                        $('.hide-menu').click(function () {
                            if (hooks.hasClass('hides')) {
                                $('.hides').css({'left': -304});
                                $('.change').css({'left': '0'});
                            } else {
                                hooks.css({'left': 0});
                                $('.change').css({'left': '120px'});
                            }
                        });
                    } else {
                        $('.hides').css({'left': -304});
                        hooks.addClass('hides');
                        $('.change').css({'left': '0px'});
                    }
                });
            });

            $(".reply-comment-child span.reply-form").hide();
            $(".reply-comment-child .artline-comment-reply").hide();
            $(".post .article-comment").hide();

            $(".readmore-article").each(function(){
                $(this).click(function(){
                    if($(this).attr('data') != ''){
                        location.href = $(this).attr('data');
                    }

                }) ;
            });

            $(".more .like-article").each(function(){
                $(this).click(function(){
                    var uid = $(this).attr('data-uid');
                    var nid = $(this).attr('data-nid');
                    var class_ = '.article-'+nid;
                    if(uid == 0){
                        $("#block-artline-artline-post a.inline").click();
                    }else{
                        $.ajax({
                            type: "POST",
                            url: 'artline/like/'+uid+'/'+nid,
                            data: nid,
                            success:function (data) {
                            }
                        });

                        $(this).removeClass('like-article');
                        $(this).find(".fa-heart-o").removeClass('fa-heart-o');
                        $(this).find(".fa").addClass('fa-heart pink');
                        $.get(
                            "/artline/get/like/"+nid,
                            {},
                            function(data) {
                                $(class_).find(".count-like").remove();
                                $(class_).html('<i class="fa fa-heart pink" aria-hidden="true"></i><i class="count-like">'+data+'</i>');
                            }
                        );
                    }

                });
            });

            //post comment
            $(".artline-comment form").each(function(){
                $(this).submit(function(){
                    var nid_ = $(this).attr('data');
                    var class_ = '.artline-comment-'+nid_;
                    var uid_ = $(class_+" .user-comment").val();
                    var pid_ = $(class_+" .reply-comment").val();
                    var name_ = $(class_+" .name-comment").val();
                    var comment_ = $(class_+" .comment-comment").val();
                    if(name_ == ''){
                        $(class_+" .name-comment").addClass('error');
                        return false;
                    }
                    if(comment_ == ''){
                        $(class_+" .comment-comment").addClass('error');
                        return false;
                    }
                    $(class_+" .comment-comment").val('');
                    $(class_+" .name-comment").val('');
                    $(class_+" .submit-comment").attr('disabled','disabled');
                    $(class_+" .loading-comment").show();
                    setTimeout(function(){
                        $.post( "/artline/post/comment",{ nid: nid_, uid: uid_, cid:pid_, name:name_, comment:comment_ })
                            .done(function(data) {
                                if(data =='ok'){
                                    $(class_+" .comment-comment").val('');
                                    $(class_+" .comment-comment").removeClass('error');
                                    $(class_+" .name-comment").removeClass('error');
                                    $(class_+" .submit-comment").removeAttr('disabled');
                                    $(class_+" .loading-comment").hide();
                                }
                            })
                            .fail(function() {
                                //alert( "error" );
                            });
                    }, 2000);

                    return false;
                });

            });
        }
    };
})(jQuery);

