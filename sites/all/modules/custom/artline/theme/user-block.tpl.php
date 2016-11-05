<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 10/30/16
 * Time: 11:12 PM
 */
if($user->uid > 0){
    $account = user_load($user->uid);
}

?>
<ul class="nav navbar-nav navbar-right">
    <?php if($user->uid > 0): ?>
        <li><a href="<?php print url('user/'.$user->uid.'/edit') ?>">Hi <?php isset($account->field_full_name[LANGUAGE_NONE]) ? print $account->field_full_name[LANGUAGE_NONE][0]['value'] : print $user->name ?></a></li>
        <li><a href="<?php print url('user/logout') ?>">Đăng xuất</a></li>
    <?php else: ?>
        <li><a href="<?php print url('user/register') ?>">Đăng ký</a></li>
        <li><a href="<?php print url('user/login'); ?>">Đăng nhập</a></li>
    <?php endif; ?>
    <?php if($user->uid > 0): ?>
        <?php if($account->picture): ?>
    <li><span><img src="<?php print image_style_url('avatar',$account->picture->uri) ?>"></span></li>
            <?php else: ?>
            <li><span><img src="<?php print base_path().drupal_get_path('theme','phucma') ?>/images/default-avatar.png"></span></li>
            <?php endif; ?>
    <?php else: ?>
        <li><span><img src="<?php print base_path().drupal_get_path('theme','phucma') ?>/images/default-avatar.png"></span></li>
    <?php endif; ?>
</ul>
