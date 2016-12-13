<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 10/25/16
 * Time: 10:18 AM
 */
global $user;
?>

<div class="clearfix"></div>
<div id="colorbox_inline">
    <!--check user login before action-->
    <?php if ($user->uid > 0): ?>

        <div id="tabs-container">
            <ul class="tabs-menu">
                <li class="current"><a data href="#tab-1"><i class="icon icon-photo"></i>Hình ảnh </a></li>
                <li><a href="#tab-2"><i class="icon icon-video"></i>Video </a></li>
            </ul>
            <div class="tab">
                <div id="tab-1" class="tab-content">
                    <form action="/uploader/post" method="POST" class="post-form-article" id="post-form-article-1">
                <textarea name="article" id="taid" size="500" placeholder="Bạn đang nghĩ gì?" cols="40" rows="4"
                          wrap="soft"></textarea>
                        <div class="clearfix"></div>
<!--                        <div class="category">-->
<!--                            <select name="category" id="category" class="category">-->
<!--                                <option>-- Chọn danh mục --</option>-->
<!--                                --><?php //if ($category): ?>
<!--                                    --><?php //foreach ($category as $tid => $term): ?>
<!--                                        <option value="--><?php //print $tid ?><!--">--><?php //print $term ?><!--</option>-->
<!--                                    --><?php //endforeach; ?>
<!--                                --><?php //endif; ?>
<!--                            </select>-->
<!--                        </div>-->
                        <div class="clearfix"></div>
                        <div class="dropzone dz-clickable" id="dropzone-upload"></div>
                        <div class="clearfix"></div>
<!--                        --><?php //if ($images): ?>
<!--                            --><?php //foreach ($images as $key => $image): ?>
<!--                                --><?php //if ($image->type == 'image'): ?>
<!--                                    <div class="item-galary-warpper">-->
<!--                                        --><?php //print theme('image_style', array('path' => $image->uri, 'style_name' => 'media_thumbnail')) ?>
<!--                                        <input type="checkbox" name="image[]" class="choose-gallary"-->
<!--                                               value="--><?php //print $image->fid; ?><!--">-->
<!--                                    </div>-->
<!--                                --><?php //endif; ?>
<!--                            --><?php //endforeach; ?>
<!--                        --><?php //endif; ?>
<!--                        <div class="clearfix"></div>-->
                        <input type="hidden" name="image_upload" value="1"/>
                        <input type="submit" value="Đăng bài" class="post-button"/>
                    </form>
                </div>
                <div id="tab-2" class="tab-content">
                    <form action="/uploader/post" method="POST" class="post-form-article" id="post-form-article-2">
                <textarea name="article" size="500" placeholder="Bạn đang nghĩ gì?" id="taid" cols="40" rows="4"
                          wrap="soft"></textarea>
                        <div class="clearfix"></div>
<!--                        <div class="category">-->
<!--                            <select name="category" id="category" class="category">-->
<!--                                <option>--Chọn danh mục--</option>-->
<!--                                --><?php //if ($category): ?>
<!--                                    --><?php //foreach ($category as $tid => $term): ?>
<!--                                        <option value="--><?php //print $tid ?><!--">--><?php //print $term ?><!--</option>-->
<!--                                    --><?php //endforeach; ?>
<!--                                --><?php //endif; ?>
<!--                            </select>-->
<!--                        </div>-->
                        <div class="clearfix"></div>
                        <div class="video-text">
                            <input placeholder="Nhập video url của Youtube hoặc Facebook" type="text" size="41"
                                   name="video"
                                   class="video"/>
<!--                            <span class="notice">Ex: https://www.youtube.com/watch?v=PXyXzHIZlBo</span>-->
<!--                            <span class="notice">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;https://www.facebook.com/abc/videos/1467917959903691</span>-->
                        </div>
                        <input type="hidden" name="video_upload" value="1"/>
                        <input type="submit" value="Đăng bài" class="post-button"/>
                    </form>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!--login or register-->
        <div class="login-register-wrapper">
            <div class="info-user">
                <span class="info">Vui lòng <strong>Đăng Nhập</strong> hoặc <strong>Đăng Ký</strong> để sử dụng các chức năng trên <strong>Artline.vn</strong>.</span>
                <?php
                $login_form = drupal_get_form('user_login_block');
                print render($login_form);
                ?>

            </div>
        </div>
    <?php endif; ?>
</div>
<div class="clearfix"></div>




