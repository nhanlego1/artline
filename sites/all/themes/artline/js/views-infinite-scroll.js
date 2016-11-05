(function ($) {
  // "use strict";

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

    $(".plugin").pinto({
      itemWidth: 415,
      gapX: 5,
      gapY: 30,
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
