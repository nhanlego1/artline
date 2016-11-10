(function ($) {
  "use strict";

  var $window = $(window);

  // The threshold for how far to the bottom you should reach before reloading.
  var scroll_threshold = 200;
  var vis_index = 0;

  /**
   * Insert a views infinite scroll view into the document after AJAX.
   *
   * @param {object} $new_view The new view coming from the server.
   */
  $.fn.infiniteScrollInsertView = function ($new_view) {
    var $existing_view = this;
    var $existing_content = $existing_view.find('.view-content').children();
    $new_view.find('.view-content').prepend($existing_content);
    $existing_view.replaceWith($new_view);
    $(document).trigger('infiniteScrollComplete', [$new_view, $existing_content]);


    //add js custom hook
    $('#view-content-ajax').NewWaterfall();

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

                },2000);
              })
              .fail(function() {
                //alert( "error" );
              });
        }, 1000);


        return false;
      }) ;
    });


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

                },2000);
              })
              .fail(function() {
                //alert( "error" );
              });
        }, 1000);


        return false;
      }) ;
    });

    $(window).scroll(function() {
      if( $(window).scrollTop() > $("footer .container").offset().top - 800 ) {

        if($("ul.pager--infinite-scroll li.pager__item a").length > 0){
            var link = $("ul.pager--infinite-scroll li.pager__item a").attr('href');
            // $.get(link, function(data, status) {
            //     $.post('/artline/raw/post', {raw: data})
            //         .done(function (data) {
            //             console.log(data);
            //         })
            //         .fail(function () {
            //             //alert( "error" );
            //         });
            // });
          $(".loading-view").show()
          setTimeout(function(){

            $(".loading-view").hide();

          },2000);
        }
      }
    });

    //add class active
    if($("#block-artline-artline-category ul li ul li.active").hasClass('active')){
      $("#block-artline-artline-category ul li ul li.active").parent().parent().addClass('active');
    }

    $(".comment-login a").each(function(){
      $(this).click(function(event){
        event.preventDefault();
        $("a.inline.cboxElement").click();
      })
    });

    if($(".node-type-article").length > 0){
      $(".node-type-article .hooks").addClass('hidden');
      $(".node-type-article .banner").addClass('hidden');
      $(".node-type-article footer").addClass('hidden');
      $(".node-type-article .node-detail").addClass('node-overview');
      $(".node-type-article").addClass('article-overview');
    }
    $(".close-node img").click(function(){
      $(".node-type-article .node-detail").removeClass('node-overview');
      $(".node-type-article .hooks").removeClass('hidden');
      $(".node-type-article .banner").removeClass('hidden');
      $(".node-type-article footer").removeClass('hidden');
      $(".node-type-article").removeClass('article-overview');
      $(this).parent().addClass('hidden');
    });

    $(".node-detail .share-post").each(function(){
      $(this).click(function(){
        $(".share-item").each(function(){
          $(this).removeClass('hidden');
        })
      });
      $(this).mouseleave(function(){
        setTimeout(function(){
          $(".share-item").each(function(){
            $(this).addClass('hidden');
          })
        },3000);
      });

    });

    //close comment
    $(".close-comment").each(function(){
      var nid = $(this).attr('data');
      $(this).click(function(){
        $(this).parent().parent().hide();
      });
    });

      $("div.post-form.pinto").each(function(e){
          if(e > 0){
              $(this).remove();
          }
      });







  };

  /**
   * Handle the automatic paging based on the scroll amount.
   */
  Drupal.behaviors.views_infinite_scroll_automatic = {
    attach : function(context, settings) {

      var settings = settings.views_infinite_scroll;
      var loadingImg = '<div class="views_infinite_scroll-ajax-loader"><img src="' + settings.img_path + '" alt="loading..."/></div>';

      $('.pager--infinite-scroll.pager--infinite-scroll-auto', context).once().each(function() {
        var $pager = $(this);
        $pager.find('.pager__item').hide();
        if ($pager.find('.pager__item a').length) {
          $pager.append(loadingImg);
        }
        $window.bind('scroll.views_infinite_scroll_' + vis_index, function() {
          if (window.innerHeight + window.pageYOffset > $pager.offset().top - scroll_threshold) {
            $pager.find('.pager__item a').click();
            $window.unbind('scroll.views_infinite_scroll_' + vis_index);
          }
        });
        vis_index++;
      });

    }
  };

})(jQuery);
