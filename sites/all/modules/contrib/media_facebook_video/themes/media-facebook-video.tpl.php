<?php

/**
 * @file
 * video player embed.
 */

/**
 * Template file for theme('media_facebook_video').
 */
?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=1519883851593966";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

<!--<div class="--><?php //print $classes; ?><!-- media-facebook---><?php //print $id; ?><!--">-->
<!--  <div class="fb-video" data-allowfullscreen="true" data-href="--><?php //print $url; ?><!--">-->
<!--  <div class="fb-xfbml-parse-ignore">-->
<!--</div>-->

<div class="fb-video" data-href="<?php print $url; ?>" data-show-text="false"></div>