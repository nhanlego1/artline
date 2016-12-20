<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 10/27/16
 * Time: 4:19 PM
 */
$class = '';
$class_child = '';
global $user;
?>
<ul class="list-item">
    <?php if($user->uid > 0): ?>
        <li class="user my-post active"><a href="<?php print url('my/posts') ?>">Bài viết của tôi</a></li>
    <?php endif;?>
    <li class="<?php if(drupal_is_front_page()):?> active <?php endif; ?>" ><a href="<?php print url('<front>') ?>">Trang chủ</a></li>
    <li class="<?php if($_GET['q']=='node/404'):?> active <?php endif; ?>" ><a href="<?php print url('node/404') ?>">Nội quy và cách tính điểm</a></li>
    <?php foreach ($terms as $term): ?>


    <?php if (!taxonomy_get_parents($term->tid)): ?>
    <?php
    if ($_GET['q'] == 'taxonomy/term/' . $term->tid) {
        $class = 'active';
    } else {
        $class = '';
    }
    ?>
    <li class="<?php print $class ?>"><a
            href="<?php print url('taxonomy/term/' . $term->tid) ?>"><?php print $term->name ?></a>
        <?php if (taxonomy_get_children($term->tid)): ?>
            <ul>
                <?php $children = taxonomy_get_children($term->tid); ?>
                <?php foreach ($children as $child): ?>
                    <?php
                    if ($_GET['q'] == 'taxonomy/term/' . $child->tid) {
                        $class_child = 'active';
                    } else {
                        $class_child = '';
                    }
                    ?>
                    <li class="<?php print $class_child ?>"><a
                            href="<?php print url('taxonomy/term/' . $child->tid) ?>"><i
                                class="fa fa-angle-double-right" aria-hidden="true"></i> <?php print $child->name ?>
                        </a></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php endif; ?>
        <?php endforeach; ?>

</ul>
<div class="clearfix"></div>
<!--<div class="sidebar-bottom">-->
<!--    <div class="logo-chungnhan">--><?php //$file = file_load(variable_get('logo_cndk'));?><!-- --><?php //if($file): ?><!-- --><?php //print theme('image_style',array('path'=>$file->uri,'style_name'=>'cndk')); ?><!----><?php //endif; ?><!--</div>-->
<!--    <div class="fb-page" data-width="225px" data-href="--><?php //print variable_get('facebook_fanpage'); ?><!--" data-small-header="true" data-adapt-container-width="false" data-hide-cover="false" data-show-facepile="true"></div>-->
<!---->
<!--</div>-->
