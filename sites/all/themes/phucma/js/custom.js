(function ($) {
    var timerScrollfront, timerScrolltaxonomy, timerScrolluser;

    Drupal.behaviors.initArtline = {
        attach: function (context, settings) {
            $('.hooks').hide();
            var hooks = $('.hooks');
            var hookWidth = hooks.outerWidth();
            var winWidth = $(window).outerWidth();
            if (winWidth > 767) {
                // $('.change').css({'left': '120px'});
                $('.hide-menu').click(function () {
                    hooks.toggle();
                    if (hooks.hasClass('hides')) {
                        $('.hides').css({'left': -hookWidth});
                        $('.change').css({'left': '0'});
                    } else {
                        hooks.css({'left': 0});
                        var rowWidth = $('.change').outerWidth();
                        //   $('.change').css({'left': '120px'});
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
                                // $('.change').css({'left': '120px'});
                            }
                        });
                    } else {
                        $('.hides').css({'left': -304});
                        hooks.addClass('hides');
                        $('.change').css({'left': '0px'});
                    }
                });
            });
            //initial js
            _loadinitjs();


        }


    };

    Drupal.behaviors.ArtlineLoadmorePagerFront = {
        attach: function (context, settings) {
            var isWorking = false;
            $(window).on('scroll', function () {
                clearTimeout(timerScrollfront);

                timerScrollfront = setTimeout(function () {
                    if ($(".front footer .container").length > 0) {
                        $(".loading-view").show();
                        if (!isWorking) {
                            if ($(window).scrollTop() > $(".front footer .container").offset().top - 800) {
                                isWorking = true;
                                var number_li = $("#view-content-ajax li.post-item").length;
                                var num = number_li / 9;
                                var data_ = $(".loading-view").attr('data');
                                $.post('/posts/list/pager', {page_num: num})
                                    .done(function (data) {
                                        if (data != 'ko') {
                                            $(".loading-view").hide();
                                            $("#view-content-ajax").append(data);
                                            _loadinitjs();

                                        } else {
                                            $(".loading-view").remove();
                                        }
                                        isWorking = false;
                                    })
                                    .fail(function () {
                                        //alert( "error" );
                                    });
                            }
                        }
                    }
                }, 500);
            });
        }
    };

    Drupal.behaviors.ArtlineLoadmorePagerTaxonomy = {
        attach: function (context, settings) {
            var isWorking = false;
            $(window).on('scroll', function () {
                clearTimeout(timerScrolltaxonomy);

                timerScrolltaxonomy = setTimeout(function () {


                        if (!isWorking) {
                            if ($(window).scrollTop() > $(".page-taxonomy footer .container").offset().top - 800) {
                                $(".loading-view").show();
                                isWorking = true;
                                var number_li = $("#view-content-ajax li.post-item").length;
                                var num = number_li / 9;
                                var data_ = $(".loading-view").attr('data');
                                $.post('/posts/category/pager', {page_num: num, tid: data_})
                                    .done(function (data) {

                                        if (data != 'ko') {
                                            $(".loading-view").hide();
                                            $("#view-content-ajax").append(data);
                                            _loadinitjs();

                                        } else {
                                            $(".loading-view").remove();
                                        }
                                        isWorking = false;
                                    })
                                    .fail(function () {
                                        //alert( "error" );
                                    });
                            }
                        }

                }, 500);
            });
        }
    };

    Drupal.behaviors.ArtlineLoadmorePagerUser = {
        attach: function (context, settings) {
            var isWorking = false;
            $(window).on('scroll', function () {
                clearTimeout(timerScrolluser);

                timerScrolluser = setTimeout(function () {
                    if ($(".page-my-posts footer .container").length > 0) {
                        $(".loading-view").show();
                        if (!isWorking) {
                            if ($(window).scrollTop() > $(".page-my-posts footer .container").offset().top - 800) {
                                isWorking = true;
                                var number_li = $("#view-content-ajax li.post-item").length;
                                var num = number_li / 9;
                                var data_ = $(".loading-view").attr('data');
                                $.post('/posts/my/pager', {page_num: num})
                                    .done(function (data) {
                                        if (data != 'ko') {
                                            $(".loading-view").hide();
                                            $("#view-content-ajax").append(data);
                                            _loadinitjs();

                                        } else {
                                            $(".loading-view").remove();
                                        }
                                        isWorking = false;
                                    })
                                    .fail(function () {
                                        //alert( "error" );
                                    });
                            }
                        }
                    }
                }, 500);
            });
        }
    };


    function _loadinitjs() {

        $(".reply-comment-child span.reply-form").hide();
        $(".readmore-article").each(function () {
            $(this).click(function () {
                if ($(this).attr('data') != '') {
                    location.href = $(this).attr('data');
                }

            });
        });
        $(".more .like-article").each(function () {
            $(this).click(function () {


                var uid = $(this).attr('data-uid');
                var nid = $(this).attr('data-nid');
                var class_ = '.article-' + nid;
                if (uid == 0) {
                    $("#block-artline-artline-post a.inline").click();
                } else {

                    //end alert
                    $.ajax({
                        type: "POST",
                        url: '/artline/like/' + uid + '/' + nid,
                        data: nid,
                        success: function (data) {

                        }
                    });

                    $(this).removeClass('like-article');
                    $(this).find(".fa-heart-o").removeClass('fa-heart-o');
                    $(this).find(".fa").addClass('fa-heart pink');
                    $.get(
                        "/artline/get/like/" + nid,
                        {},
                        function (data) {
                            $(class_).find(".count-like").remove();
                            $(class_).html('<i class="fa fa-heart pink" aria-hidden="true"></i><i class="count-like">' + data + '</i>');
                        }
                    );
                        _updateXu(uid);

                }

            });
        });

        //post comment
        $(".artline-comment form").each(function () {
            $(this).submit(function () {

                //end alert
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

                if(comment_.length < 5){
                    $(class_ + " .comment-comment").addClass('error');
                    return false;
                }
                $(class_ + " .comment-comment").val('');
                $(class_ + " .name-comment").val('');
                $(class_ + " .submit-comment").attr('disabled', 'disabled');
                $(class_ + " .loading-comment").show();
                var avatar_ = $(class_ + " .user-comment-avatar").val();
                var classApen_ = '.article-comment-parent-' + nid_;
                    _updateXu(uid_);
                var PostComment;
                clearTimeout(PostComment);
                PostComment = setTimeout(function () {
                    $.post("/artline/post/comment", {
                        nid: nid_,
                        uid: uid_,
                        cid: pid_,
                        name: name_,
                        comment: comment_
                    })
                        .done(function (data) {
                            $(class_ + " .comment-comment").val('');
                            $(class_ + " .comment-comment").removeClass('error');
                            $(class_ + " .name-comment").removeClass('error');
                            $(class_ + " .submit-comment").removeAttr('disabled');
                            $(class_ + " .loading-comment").hide();
                            var timeComment;
                            clearTimeout(timeComment);
                            timeComment = setTimeout(function () {
                                if ($(classApen_).length > 0) {
                                    $(classApen_).append('<div class="comment-item"><div class="avatar-comment"><img typeof="foaf:Image" src="' + avatar_ + '" width="40" height="40" alt="" /><span class="name-comment-user">' + name_ + '</span></div><div class="comment-content">' + comment_ + '</div><div class="clearfix"></div><span class="reply-form" data="58" style="display: none;">Trả lời</span><div class="clearfix"></div><div class="reply-comment-child"></div></div>');
                                } else {
                                    var classApendN_ = '.article-comment-wrapper-' + nid_;
                                    $(classApendN_).append('<div class="comment-page-wrapper"><div class="comment-item"><div class="avatar-comment"><img typeof="foaf:Image" src="' + avatar_ + '" width="40" height="40" alt="" /><span class="name-comment-user">' + name_ + '</span></div><div class="comment-content">' + data + '</div><div class="clearfix"></div><span class="reply-form" data="58" style="display: none;">Trả lời</span><div class="clearfix"></div><div class="reply-comment-child"></div></div></div>');
                                }

                            }, 500);

                        })
                        .fail(function () {
                            //alert( "error" );
                        });
                }, 1000);

                return false;
            });
        });


        //post comment
        $(".artline-comment-reply form").each(function () {
            $(this).submit(function () {

                //end alert
                var cid_ = $(this).attr('data');
                var class_ = '.artline-comment-reply-' + cid_;
                var uid_ = $(class_ + " .user-comment-reply").val();
                var nid_ = $(class_ + " .node-comment-reply").val();
                var name_ = $(class_ + " .name-comment").val();
                var comment_ = $(class_ + " .comment-comment-reply").val();
                if (comment_ == '') {
                    $(class_ + " .comment-comment-reply").addClass('error');
                    return false;
                }
                if(comment_.length < 5){
                    $(class_ + " .comment-comment-reply").addClass('error');
                    return false;
                }
                $(class_ + " .comment-comment-reply").val('');
                $(class_ + " .name-comment-reply").val('');
                $(class_ + " .submit-comment-reply").attr('disabled', 'disabled');
                $(class_ + " .loading-comment").show();
                var avatar_ = $(class_ + " .user-comment-avatar-reply").val();
                var classApen_ = '.reply-comment-child-' + cid_;
                    _updateXu(uid_);

                var PostComment;
                clearTimeout(PostComment);
                PostComment = setTimeout(function () {
                    $.post("/artline/post/comment", {
                        nid: nid_,
                        uid: uid_,
                        cid: cid_,
                        name: name_,
                        comment: comment_
                    })
                        .done(function (data) {
                            $(class_ + " .comment-comment-reply").val('');
                            $(class_ + " .comment-comment-reply").removeClass('error');
                            $(class_ + " .name-comment-reply").removeClass('error');
                            $(class_ + " .submit-comment-reply").removeAttr('disabled');
                            $(class_ + " .loading-comment").hide();
                            var clearReplyComment;
                            clearTimeout(clearReplyComment);
                            clearReplyComment = setTimeout(function () {
                                if ($(classApen_ + " .comment-page-wrapper").length > 0) {
                                    $(classApen_ + " .comment-page-wrapper").append('<div class="article-comment-' + nid_ + '"><div class="comment-item"><div class="avatar-comment"><img typeof="foaf:Image" src="' + avatar_ + '" width="40" height="40" alt="" /><span class="name-comment-user">' + name_ + '</span></div><div class="comment-content">' + comment_ + '</div><div class="clearfix"></div><span class="reply-form" data="58" style="display: none;">Trả lời</span><div class="clearfix"></div><div class="reply-comment-child"></div></div></div>');
                                } else {
                                    var classApendN_ = '.reply-comment-child-' + cid_;
                                    $(classApendN_).append('<div class="comment-page-wrapper"><div class="article-comment-' + nid_ + '"><div class="comment-item"><div class="avatar-comment"><img typeof="foaf:Image" src="' + avatar_ + '" width="40" height="40" alt="" /><span class="name-comment-user">' + name_ + '</span></div><div class="comment-content">' + data + '</div><div class="clearfix"></div><span class="reply-form" data="58" style="display: none;">Trả lời</span><div class="clearfix"></div><div class="reply-comment-child"></div></div></div></div>');
                                }

                            }, 500);

                        })
                        .fail(function () {
                            //alert( "error" );
                        });
                }, 1000);

                return false;
            });
        });


        //add show hide comment
        $(".more span.comment").each(function () {
            var nid_ = $(this).attr('data');
            $(this).click(function () {
                $(".post .article-comment").hide();
                var class_ = '.post-comment-' + nid_;
                $(class_).show();

            });
        });

        //show hide reply
        $(".comment-item span.reply-form").each(function () {
            $(this).click(function () {
                var class_ = '.artline-comment-reply-' + $(this).attr('data');
                $(".artline-comment-reply").hide();
                $(class_).show();
                $(".close-form-" + $(this).attr('data')).removeClass('hidden');

            });
        });

        $(".close-form").each(function () {
            $(this).click(function () {
                $(".artline-comment-reply").hide();
                $(this).addClass('hidden');
            });
        });

        //store
        $(".more span.store").each(function () {
            var nid_ = $(this).attr('data');
            var class_ = '.ctools-use-modal-' + nid_;
            $(this).click(function () {
                $(class_).click();
            });
        });

        //store
        $(".xu a").each(function () {
            var nid_ = $(this).attr('data');
            var class_ = '.xu-ctools-use-modal-' + nid_;
            $(this).click(function () {
                $(class_).click();
                return false;
            });

        });

        //share
        $("span.share-post").each(function () {
            var nid_ = $(this).attr('data');
            var id_ = '#share-button-' + nid_;
            //$(id_).addClass('hidden');
            $(this).click(function () {
                //  $(".artline-share-social-"+nid_).clone().appendTo(id_);
                // $(".share-item").hide();
                $(id_).removeClass('hidden');
            });
            $(this).mouseleave(function () {
                setTimeout(function () {
                    $(id_).addClass('hidden');
                }, 3000)
            });
            $(id_).hover(function () {
                $(id_).removeClass('hidden');
            });
            $(id_).mouseleave(function () {
                setTimeout(function () {
                    $(id_).addClass('hidden');
                }, 3000)
            });
        });


        //share link
        $("span.share-link-button").each(function () {
            var nid_ = $(this).attr('data');
            var id_ = "#share-link-" + nid_;
            $(this).click(function () {
                $(id_).removeClass('hidden');
                $(id_).select();
            });
            $(this).mouseleave(function () {
                setTimeout(function () {
                    $(id_).addClass('hidden');
                }, 2000)
            });
            $(id_).hover(function () {
                $(id_).removeClass('hidden');
                $(id_).select();
            });
            $(id_).mouseleave(function () {
                setTimeout(function () {
                    $(id_).addClass('hidden');
                }, 2000)
            });
        });

        $(".action-link .delete-post").each(function () {
            var nid_ = $(this).attr('data');
            $(this).click(function (event) {
                event.preventDefault();
                $(".post-" + nid_ + ' .loading-post-post').show();

                setTimeout(function () {
                    $.post("/artline/delete/post", {nid: nid_})
                        .done(function (data) {
                            if (data == 'ok') {

                            }
                        })
                        .fail(function () {
                            //alert( "error" );
                        });
                }, 1000);
                setTimeout(function () {
                    $(".post-" + nid_ + ' .loading-post-post').hide();
                    $(".post-" + nid_).remove();

                }, 2000);
            });

        });

        $(".action-link .public-post").each(function () {
            var nid_ = $(this).attr('data');
            $(this).click(function (event) {
                event.preventDefault();
                $(".post-" + nid_ + ' .loading-post-post').show();

                setTimeout(function () {
                    $.post("/artline/public/post", {nid: nid_})
                        .done(function (data) {
                            if (data == 'ok') {

                            }
                        })
                        .fail(function () {
                            //alert( "error" );
                        });
                }, 1000);
                setTimeout(function () {
                    $(".post-" + nid_ + ' .loading-post-post').hide();
                    $(".public-" + nid_).html('Khoá bài viết');
                    $(".public-" + nid_).removeClass('public-post');

                    $(".public-" + nid_).addClass('unpublic-post');
                    $(".public-" + nid_).addClass('unpublic-' + nid_);
                    $(".public-" + nid_).removeClass('public-' + nid_);

                }, 2000);
            });

        });
        $(".action-link .unpublic-post").each(function () {
            var nid_ = $(this).attr('data');
            $(this).click(function (event) {
                event.preventDefault();
                $(".post-" + nid_ + ' .loading-post-post').show();

                setTimeout(function () {
                    $.post("/artline/unpublic/post", {nid: nid_})
                        .done(function (data) {
                            if (data == 'ok') {

                            }
                        })
                        .fail(function () {
                            //alert( "error" );
                        });
                }, 1000);
                setTimeout(function () {
                    $(".post-" + nid_ + ' .loading-post-post').hide();
                    $(".unpublic-" + nid_).html('Xuất bản');
                    $(".unpublic-" + nid_).removeClass('unpublic-post');

                    $(".unpublic-" + nid_).addClass('public-post');
                    $(".unpublic-" + nid_).addClass('public-' + nid_);
                    $(".unpublic-" + nid_).removeClass('unpublic-' + nid_);


                }, 2000);
            });

        });

        //edit article
        $(".action-link .edit-post").each(function () {
            var nid_ = $(this).attr('data');
            $(this).click(function (event) {
                event.preventDefault();
                //$(".post-"+nid_+' .loading-post-post').show();
                setTimeout(function () {
                    //   $(".post-"+nid_+' .loading-post-post').hide();
                    $(".content-desc-" + nid_).hide();
                    $("#post-edit-" + nid_).show();
                }, 300);
            });
        });

        //update action post
        $("form.post-edit-article").each(function () {
            var nid_ = $(this).attr('data');
            $(this).submit(function () {
                $(".post-" + nid_ + ' .loading-post-post').show();

                var value_ = $("#edit-post-" + nid_).val();
                setTimeout(function () {
                    $.post("/artline/edit/post", {nid: nid_, value: value_})
                        .done(function (data) {
                            setTimeout(function () {
                                $(".content-desc-" + nid_).html(data);
                                $(".content-desc-" + nid_).show();
                                $("form.post-edit-article").hide();
                                $(".post-" + nid_ + ' .loading-post-post').hide();

                            }, 2000);
                        })
                        .fail(function () {
                            //alert( "error" );
                        });
                }, 1000);


                return false;
            });
        });

        $(".comment-login a").each(function () {
            $(this).click(function (event) {
                event.preventDefault();
                $("a.inline.cboxElement").click();
            })
        });

        if ($(".node-type-article").length > 0) {
            $(".node-type-article .hooks").addClass('hidden');
            $(".node-type-article .banner").addClass('hidden');
            $(".node-type-article footer").addClass('hidden');
            $(".node-type-article .node-detail").addClass('node-overview');
            $(".node-type-article").addClass('article-overview');
        }
        $(".close-node img").click(function () {
            $(".node-type-article .node-detail").removeClass('node-overview');
            $(".node-type-article .hooks").removeClass('hidden');
            $(".node-type-article .banner").removeClass('hidden');
            $(".node-type-article footer").removeClass('hidden');
            $(".node-type-article").removeClass('article-overview');
            $(this).parent().addClass('hidden');
        });

        $(".node-detail .share-post").each(function () {
            $(this).click(function () {
                $(".share-item").each(function () {
                    $(this).removeClass('hidden');
                })
            });
            $(this).mouseleave(function () {
                setTimeout(function () {
                    $(".share-item").each(function () {
                        $(this).addClass('hidden');
                    })
                }, 3000);
            });

        });

//close comment
        $(".close-comment").each(function () {
            var nid = $(this).attr('data');
            $(this).click(function () {
                $(this).parent().parent().hide();
            });
        });

//hide control
        $(".carousel-inner").each(function () {
            var nid_ = $(this).attr('data');
            if ($(".item", this).length == 1) {
                $(".carousel-control-" + nid_).hide();
                $(".carousel-indicators-" + nid_).remove();

                $("#" + nid_ + ".slide").attr("style", "margin-bottom:13px!important");
                $("#" + nid_ + ".slide").parent().attr("style", "margin-bottom:13px!important");
            }
        });

        //share social get point
        // $(".share-item a").each(function () {
        //     var _nid = $(this).attr('data');
        //     var _uid = $(this).attr('data-uid');
        //     $(this).click(function () {
        //         if (_uid > 0) {
        //             $.post("/posts/share/social", {nid: _nid, uid: _uid})
        //                 .done(function (data) {
        //                         _updateXu(_uid);
        //                 })
        //                 .fail(function () {
        //                     //alert( "error" );
        //                 });
        //         } else {
        //             $.post("/posts/share/social", {nid: _nid, uid: _uid})
        //                 .done(function (data) {
        //
        //                 })
        //                 .fail(function () {
        //                     //alert( "error" );
        //                 });
        //         }
        //
        //
        //     });
        // });

        //form update product
        $("a.product-post").each(function () {
            var nid_ = $(this).attr('data');
            $(this).click(function (event) {
                event.preventDefault();
                $(".product-ctools-use-modal-" + nid_).click();
            });
        });




    }

    //update xu
    function _updateXu(uid) {
        $.post("/xu/update/action", {uid: uid})
            .done(function (data) {
                $(".xu-point").text(data);
                $(".xu-point-alert").show();
                var timeoutAlert;
                clearTimeout(timeoutAlert);
                timeoutAlert = setTimeout(function(){
                    $(".xu-point-alert").hide();
                },2000);
            })
            .fail(function () {
                //alert( "error" );
            });
    }


    function beeConner(e) {
        var offsets = $(".xu-point").offset();
        var top = offsets.top;
        var left = offsets.left;

        e.animate({top: (top - 40) + 'px', left: left + 'px'}, 1000);
        var clear;
        clearTimeout(clear);
        clear = setTimeout(function () {
            e.css({"top": "-50%"});
        }, 2000);
    }


})
(jQuery);

