<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 10/28/16
 * Time: 3:47 PM
 */
global $user;
$account2 = user_load($user->uid);
if($account2->picture){
    $avatar = image_style_url('avatar', $account2->picture->uri);
}else{
    $avatar = base_path() . path_to_theme("theme", "phucma").'/images/default-avatar.png';
}
?>
<?php if ($comments): ?>
    <div class="comment-page-wrapper article-comment-<?php print $class.'-'. $nid ?>">
        <?php foreach ($comments as $comment): ?>
            <div class="article-comment-<?php print $comment->nid ?>">
                <?php $account = user_load($comment->uid); ?>
                <div class="comment-item">
                    <div class="avatar-comment">
                        <?php if ($account->picture): ?>
                            <?php print theme('image_style', array('path' => $account->picture->uri, 'style_name' => 'avatar')); ?>
                        <?php else: ?>
                            <img
                                src="<?php print base_path() . drupal_get_path('theme', 'phucma'); ?>/images/default-avatar.png">
                        <?php endif; ?>
                    </div>
                    <div class="comment-content">
                        <?php print $comment->comment_body[LANGUAGE_NONE][0]['value']; ?>
                    </div>
                    <div class="clearfix"></div>
                    <span class="reply-form" data="<?php print $comment->cid; ?>">Trả lời</span>
                    <div class="clearfix"></div>
                    <div class="artline-comment-reply artline-comment-reply-<?php print $comment->cid ?>">
                        <div class="loading-comment">
                            <img
                                src="<?php print base_path() . drupal_get_path('module', 'artline ') ?>/images/loading.gif"
                                width="110" height="auto"/>
                        </div>
                        <form id="artline-comment-<?php print $comment->cid ?>" nam="artline_cmment_reply" method="POST"
                              data="<?php print $comment->cid; ?>">
                            <input type="hidden" name="node_comment" class="node-comment-reply"
                                   value="<?php print $comment->nid; ?>"/>
                            <input type="hidden" name="reply_comment" class="reply-comment-reply"
                                   value="<?php print $comment->cid ?>"/>
                            <input type="hidden" name="user_comment" class="user-comment-reply"
                                   value="<?php print $user->uid ?>"/>
                            <input type="hidden"  name="user_comment_avatar" class="user-comment-avatar-reply" value="<?php print $avatar ?>"/>


                            <?php if ($user->uid <= 0): ?>
                                <input type="text" name="name_comment" class="name-comment-reply"
                                       placeholder="Họ và tên"/>
                            <?php else: ?>
                                <input type="hidden" name="name_comment" class="name-comment"
                                       value="<?php print isset($account2->field_full_name[LANGUAGE_NONE]) ? $account2->field_full_name[LANGUAGE_NONE][0]['value'] : $user->name ?>"/>
                            <?php endif; ?>

                            <div class="comment-box">
                            <textarea cols="40" rows="1" name="comment_comment" class="comment-comment-reply"
                                      placeholder="Trả lời"></textarea>
                                <input type="submit" name="submit_comment" class="submit-comment-reply" value="Đăng"/>
                            </div>

                        </form>
                    </div>

                    <div class="clearfix"></div>
                    <div class="reply-comment-child reply-comment-child-<?php print $comment->cid ?>">
                        <?php print artline_get_comment($comment->nid, $comment->cid) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>