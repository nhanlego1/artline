(function ($) {

    Drupal.behaviors.initArtline = {
        attach: function (context, settings) {

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

            function givePosition( position ){
                $('html, body').scrollTop(position,100);
            }

            function givePositionScroll( position ){
                $('html, body').animate({scrollTop: position}, 500);
            }

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
            $(".comment-item").each(function(){
                $(this).mouseover(function(){
                    $("span.reply-form",this).show();
                    $(".reply-comment-child span.reply-form").hide();
                });
                $(this).mouseleave(function(){
                    $("span.reply-form",this).hide();
                    $(".reply-comment-child span.reply-form").hide();
                });
            });

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
                            url: '/artline/like/'+uid+'/'+nid,
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
            $(".artline-comment form").each(function() {
                $(this).submit(function () {
                    var nid_ = $(this).attr('data');
                    var class_ = '.artline-comment-' + nid_;
                    var uid_ = $(class_ + " .user-comment").val();
                    var pid_ = $(class_ + " .reply-comment").val();
                    var name_ = $(class_ + " .name-comment").val();
                    var comment_ = $(class_ + " .comment-comment").val();
                    if (name_ == '') {
                        $(class_ + " .name-comment").addClass('error');
                        return false;
                    }
                    if (comment_ == '') {
                        $(class_ + " .comment-comment").addClass('error');
                        return false;
                    }
                    $(class_ + " .comment-comment").val('');
                    $(class_ + " .name-comment").val('');
                    $(class_ + " .submit-comment").attr('disabled', 'disabled');
                    $(class_ + " .loading-comment").show();
                    var avatar_ = $(class_ + " .user-comment-avatar").val();
                    var classApen_ = '.article-comment-parent-' + nid_;

                    setTimeout(function () {
                        $.post("/artline/post/comment", {nid: nid_, uid: uid_, cid: pid_, name: name_, comment: comment_})
                            .done(function (data) {
                                $(class_ + " .comment-comment").val('');
                                $(class_ + " .comment-comment").removeClass('error');
                                $(class_ + " .name-comment").removeClass('error');
                                $(class_ + " .submit-comment").removeAttr('disabled');
                                $(class_ + " .loading-comment").hide();
                                setTimeout(function () {
                                    if($(classApen_).length > 0){
                                        $(classApen_).append('<div class="comment-item"><div class="avatar-comment"><img typeof="foaf:Image" src="'+avatar_+'" width="40" height="40" alt="" /></div><div class="comment-content">'+comment_ +'</div><div class="clearfix"></div><span class="reply-form" data="58" style="display: none;">Trả lời</span><div class="clearfix"></div><div class="reply-comment-child"></div></div>');
                                    }else{
                                        var classApendN_ = '.article-comment-wrapper-'+nid_;
                                        $(classApendN_).append('<div class="comment-page-wrapper"><div class="comment-item"><div class="avatar-comment"><img typeof="foaf:Image" src="'+avatar_+'" width="40" height="40" alt="" /></div><div class="comment-content">'+data +'</div><div class="clearfix"></div><span class="reply-form" data="58" style="display: none;">Trả lời</span><div class="clearfix"></div><div class="reply-comment-child"></div></div></div>');
                                    }

                                }, 2000);
                            })
                            .fail(function () {
                                //alert( "error" );
                            });
                    }, 1000);

                    setTimeout(function () {
                        $(".plugin").pinto({
                            itemWidth: 415,
                            gapX: 5,
                            gapY: 30,
                        });
                        $('html, body').animate({
                            scrollTop: $("#comment-box-" + nid_).offset().top
                        }, 'fast');
                    },3000);
                    return false;
                });
            });


            //post comment
            $(".artline-comment-reply form").each(function(){
                $(this).submit(function(){
                    var cid_ = $(this).attr('data');
                    var class_ = '.artline-comment-reply-'+cid_;
                    var uid_ = $(class_+" .user-comment-reply").val();
                    var nid_ = $(class_+" .node-comment-reply").val();
                    var name_ = $(class_+" .name-comment-reply").val();
                    var comment_ = $(class_+" .comment-comment-reply").val();
                    if(comment_ == ''){
                        $(class_+" .comment-comment-reply").addClass('error');
                        return false;
                    }
                    $(class_+" .comment-comment-reply").val('');
                    $(class_+" .name-comment-reply").val('');
                    $(class_+" .submit-comment-reply").attr('disabled','disabled');
                    $(class_+" .loading-comment").show();
                    var avatar_ = $(class_ + " .user-comment-avatar-reply").val();
                    var classApen_ = '.reply-comment-child-' + cid_;

                    setTimeout(function(){
                        $.post( "/artline/post/comment",{ nid: nid_, uid: uid_, cid:cid_, name:name_, comment:comment_ })
                            .done(function(data) {
                                    $(class_+" .comment-comment-reply").val('');
                                    $(class_+" .comment-comment-reply").removeClass('error');
                                    $(class_+" .name-comment-reply").removeClass('error');
                                    $(class_+" .submit-comment-reply").removeAttr('disabled');
                                    $(class_+" .loading-comment").hide();
                                setTimeout(function () {
                                    if($(classApen_ +" .comment-page-wrapper").length > 0){
                                        $(classApen_ +" .comment-page-wrapper").append('<div class="article-comment-'+nid_+'"><div class="comment-item"><div class="avatar-comment"><img typeof="foaf:Image" src="'+avatar_+'" width="40" height="40" alt="" /></div><div class="comment-content">'+comment_ +'</div><div class="clearfix"></div><span class="reply-form" data="58" style="display: none;">Trả lời</span><div class="clearfix"></div><div class="reply-comment-child"></div></div></div>');
                                    }else{
                                        var classApendN_ = '.reply-comment-child-'+cid_;
                                        $(classApendN_).append('<div class="comment-page-wrapper"><div class="article-comment-'+nid_+'"><div class="comment-item"><div class="avatar-comment"><img typeof="foaf:Image" src="'+avatar_+'" width="40" height="40" alt="" /></div><div class="comment-content">'+data +'</div><div class="clearfix"></div><span class="reply-form" data="58" style="display: none;">Trả lời</span><div class="clearfix"></div><div class="reply-comment-child"></div></div></div></div>');
                                    }

                                }, 2000);
                            })
                            .fail(function() {
                                //alert( "error" );
                            });
                    }, 1000);

                    setTimeout(function () {
                        $(".plugin").pinto({
                            itemWidth: 415,
                            gapX: 5,
                            gapY: 30,
                        });
                        $('html, body').animate({
                            scrollTop: $("#comment-box-" + nid_).offset().top
                        }, 'fast');
                    },3000);

                    return false;
                });
            });



            //add show hide comment
            $(".more span.comment").each(function(){
                var nid_ = $(this).attr('data');
                $(this).click(function(){
                    $(".post .article-comment").hide();
                    var class_ = '.post-comment-'+nid_;
                    $(class_).show();
                    $(".plugin").pinto({
                        itemWidth: 415,
                        gapX: 5,
                        gapY: 30,
                    });
                    $('html, body').animate({
                        scrollTop: $("#comment-box-"+nid_).offset().top
                    }, 'fast');
                });
            });

            //show hide reply
            $(".comment-item span.reply-form").each(function(){
                $(this).click(function(){
                    var class_ = '.artline-comment-reply-'+$(this).attr('data');
                    $(".artline-comment-reply").hide();
                    $(class_).show();

                });
            });

            //store
            $(".more span.store").each(function(){
                var nid_ = $(this).attr('data');
                var class_ = '.store-'+nid_;
                $(this).click(function(){
                    $(class_).click();
                });
            });

            //share
            $("span.share-post").each(function(){
                var nid_ = $(this).attr('data');
                var id_ = '#share-button-'+nid_;
               $(id_).addClass('hidden');
                $(this).click(function(){
                   // $(".share-item").hide();
                    $(id_).removeClass('hidden');
                });
                $(this).mouseleave(function(){
                    setTimeout(function(){
                        $(id_).addClass('hidden');
                    },3000)
                });
                $(id_).hover(function(){
                    $(id_).removeClass('hidden');
                });
                $(id_).mouseleave(function(){
                    setTimeout(function(){
                        $(id_).addClass('hidden');
                    },3000)
                });
            });

            //share link
            $("span.share-link-button").each(function(){
                var nid_ = $(this).attr('data');
                var id_ = "#share-link-"+nid_;
                $(this).click(function(){
                    $(id_).removeClass('hidden');
                    $(id_).select();
                });
                $(this).mouseleave(function(){
                    setTimeout(function(){
                        $(id_).addClass('hidden');
                    },2000)
                });
                $(id_).hover(function(){
                    $(id_).removeClass('hidden');
                    $(id_).select();
                });
                $(id_).mouseleave(function(){
                    setTimeout(function(){
                        $(id_).addClass('hidden');
                    },2000)
                });
            });


        }
    };

    Drupal.behaviors.Artlineupdate= {
        attach: function (context, settings) {
            //// Load the IFrame Player API code asynchronously.
            $(".action-link .delete-post").each(function(){
                var nid_ = $(this).attr('data');
                $(this).click(function(event){
                    event.preventDefault();
                    $(".post-"+nid_+' .loading-post-post').show();

                    setTimeout(function(){
                        $.post( "/artline/delete/post",{ nid: nid_})
                            .done(function(data) {
                                if(data =='ok'){

                                }
                            })
                            .fail(function() {
                                //alert( "error" );
                            });
                    }, 1000);
                    setTimeout(function () {
                        $(".post-"+nid_+' .loading-post-post').hide();
                        $(".post-"+nid_).remove();
                        $(".plugin").pinto({
                            itemWidth: 415,
                            gapX: 5,
                            gapY: 30,
                        });
                    },2000);
                });

            });

            //edit article
            $(".action-link .edit-post").each(function(){
                var nid_ = $(this).attr('data');
                $(this).click(function(event){
                    event.preventDefault();
                    //$(".post-"+nid_+' .loading-post-post').show();
                    setTimeout(function(){
                     //   $(".post-"+nid_+' .loading-post-post').hide();
                       $(".content-desc-"+nid_).hide();
                        $("#post-edit-"+nid_).show();
                    }, 300);
                });
            });

            //update action post
            $("form.post-edit-article").each(function(){
               var nid_ = $(this).attr('data');
               $(this).submit(function(){
                   $(".post-"+nid_+' .loading-post-post').show();

                   var value_ = $("#edit-post-"+nid_).val();
                   setTimeout(function(){
                       $.post( "/artline/edit/post",{ nid: nid_, value:value_})
                           .done(function(data) {
                               setTimeout(function () {
                                   $(".content-desc-"+nid_+" .field-content").html(data);
                                   $(".content-desc-"+nid_).show();
                                   $("form.post-edit-article").hide();
                                   $(".post-"+nid_+' .loading-post-post').hide();
                                   $(".plugin").pinto({
                                       itemWidth: 415,
                                       gapX: 5,
                                       gapY: 30,
                                   });
                               },2000);
                           })
                           .fail(function() {
                               //alert( "error" );
                           });
                   }, 1000);


                  return false;
               }) ;
            });
        }
    };

    Drupal.behaviors.ArtlineLoadmorePager= {
        attach: function (context, settings) {

            $(".plugin").pinto({
                itemWidth: 415,
                gapX: 5,
                gapY: 30,
            });

            $(window).scroll(function() {
                if( $(window).scrollTop() > $("footer .container").offset().top - 800 ) {
                    if($("ul.pager-show-more li.pager-show-more-next a").length > 0){
                        $(".loading-view").show()
                        setTimeout(function(){
                            $("ul.pager-show-more li.pager-show-more-next a").click();
                            $(".loading-view").hide()

                        },2000);
                    }
                }
            });
            $(".comment-login a").each(function(){
                $(this).click(function(event){
                    event.preventDefault();
                    $("a.inline.cboxElement").click();
                })
            });
        }
    };


})(jQuery);

