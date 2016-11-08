(function ($) {

    Drupal.behaviors.initDropzone = {
        attach: function (context, settings) {
            Dropzone.autoDiscover = false;
            $("div#dropzone-upload").dropzone({url: "/uploader/post"});
            $(".tabs-menu a").click(function (event) {
                event.preventDefault();
                $(this).parent().addClass("current");
                $(this).parent().siblings().removeClass("current");
                var tab = $(this).attr("href");
                $(".tab-content").not(tab).css("display", "none");
                $(tab).fadeIn();

            });

            $('input').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue',
                increaseArea: '20%' // optional
            });
            $('select').niceSelect();


            $("#block-artline-artline-post a.inline").colorbox({inline: true, width: "375px", height: "500px"});


            $(".post_bottom").click(function () {
                $("#block-artline-artline-post a.inline").click();
            })

            $(".post-article-click").click(function () {
                $("#block-artline-artline-post a.inline").click();
            });
            $("form#post-form-article-1").submit(function () {

                var cate = $(this).find("select#category").val();

                if ($.isNumeric(cate) == false) {
                    $(this).find(".nice-select.category").addClass('error');
                    return false;
                } else {
                    return true;
                }
            });
            $("form#post-form-article-2").submit(function () {
                var cate = $(this).find("select#category").val();
                if ($.isNumeric(cate) == false) {
                    $(this).find(".nice-select.category").addClass('error');
                    return false;
                } else {
                    return true;
                }
            });

            $(".comment-item").each(function () {
                $(this).mouseover(function () {
                    $("span.reply-form", this).toggle();
                });
            });

        }
    };

})(jQuery);