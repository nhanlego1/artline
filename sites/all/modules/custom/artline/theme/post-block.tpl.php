<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 10/27/16
 * Time: 4:39 PM
 */
global $user;
if(isset($user->picture) && $user->picture > 0){
    $file = file_load($user->picture);
    $avatar = theme('image_style',array('path'=>$file->uri,'style_name'=>'avatar'));
}else{
    $avatar = '<img src="'.base_path() . path_to_theme("theme", "phucma").'/images/default-avatar.png">';
}
?>
<?php if($user->uid > 0): ?>
        <div class="post-form col-md-12 col-xs-12 pinto ">
            <div class="news post-article-click">
                <?php print $avatar ?>
                <input type="text" disabled="disabled" name="news" style="background: #fff;" placeholder="Bạn đang nghĩ gì?">
                <span><i class="fa fa-camera" aria-hidden="true"></i></span>
            </div>
        </div>
<?php endif; ?>

