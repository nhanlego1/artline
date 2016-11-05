<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 10/28/16
 * Time: 8:37 AM
 */
global $user;
$account = user_load($user->uid);

if($account->picture){
    $avatar = image_style_url('avatar', $account->picture->uri);
}else{
    $avatar = base_path() . path_to_theme("theme", "phucma").'/images/default-avatar.png';
}
?>
<div class="clearfix"></div>
<div class="title-comment"><span>Bình luận</span></div>
<div class="article-comment-wrapper-<?php print $nid; ?>">
    <?php print artline_get_comment($nid); ?>
</div>


<div class="artline-comment artline-comment-<?php print $nid ?>">
    <div class="loading-comment">
        <img src="<?php print base_path().drupal_get_path('module','artline ') ?>/images/loading.gif" width="110" height="auto"/>
    </div>
    <form id="artline-comment-<?php print $nid ?>" nam="artline_cmment" method="POST" data="<?php print $nid; ?>">
        <input type="hidden"  name="node_comment" class="node-comment" value="<?php print $nid; ?>">
        <input type="hidden"  name="reply_comment" class="reply-comment" value="<?php print $pid ?>">
        <input type="hidden"  name="user_comment" class="user-comment" value="<?php print $user->uid ?>">
        <input type="hidden"  name="user_comment_avatar" class="user-comment-avatar" value="<?php print $avatar ?>">

        <?php if ($user->uid <= 0): ?>
            <input type="text"  name="name_comment" class="name-comment" placeholder="Họ và tên">
        <?php else: ?>
            <input type="hidden"  name="name_comment" class="name-comment"
                   value="<?php print isset($account->field_full_name[LANGUAGE_NONE]) ? $account->field_full_name[LANGUAGE_NONE][0]['value'] : $user->name ?>">
        <?php endif; ?>

        <div class="comment-box">
            <textarea cols="40" rows="2" name="comment_comment"  class="comment-comment" placeholder="Viết bình luận"></textarea>
            <input type="submit" name="submit_comment" class="submit-comment" value="Đăng">
        </div>

    </form>
</div>
