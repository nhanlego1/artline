<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 10/27/16
 * Time: 4:57 PM
 */
//dsm($fields);
global $user;
$account = user_load($node->uid);

if ($account->picture) {
    $avatar = theme('image_style', array('path' => $account->picture->uri, 'style_name' => 'avatar'));
} else {
    $avatar = '<img src="' . base_path() . path_to_theme("theme", "phucma") . '/images/default-avatar.png">';
}

?>

<div class="col-md-6 col-xs-12 product node-detail node-overview post-<?php print $node->nid ?>">
    <div class="close-node"><img
            src="<?php print base_path() . drupal_get_path('module', 'artline ') ?>/images/close-node.png"
            width="30" height="auto"/></div>
    <div class="loading-post-post">
        <img
            src="<?php print base_path() . drupal_get_path('module', 'artline ') ?>/images/loading.gif"
            width="150" height="auto"/>
    </div>
    <div class="post">
        <div class="news">
            <?php print $avatar ?>
            <p class="name">
                <?php if (isset($account->field_full_name[LANGUAGE_NONE])): ?>
                    <?php print $account->field_full_name[LANGUAGE_NONE][0]['value'] ?>
                <?php else: ?>
                    <?php print $account->name ?>
                <?php endif; ?>
            </p>
            <span class="datetime"><?php print format_date($node->created, 'custom', 'd/m/Y H:i:s') ?></span>
            <span class="share-link-button" data="<?php print $node->nid ?>"><img
                    src="<?php print base_path() . drupal_get_path('theme', 'phucma') ?>/images/ic.png"
                    class="icon-link"></span>
            <input type="text" class="share-link hidden" id="share-link-<?php print $node->nid ?>"
                   value="<?php print artline_share_url_encode($node->nid) ?>"/>
        </div>
        <?php if (isset($node->field_category[LANGUAGE_NONE])): ?>
            <div class="category-article">
                <?php print render($content['field_category']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($node->field_image[LANGUAGE_NONE])): ?>
            <div class="slide">
                <div id="<?php print $node->nid; ?>" class="carousel slide" data-ride="carousel" data-interval="false">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <?php foreach ($node->field_image[LANGUAGE_NONE] as $key => $image): ?>
                            <li data-target="#<?php print $node->nid; ?>" data-slide-to="<?php print $key ?>"
                                class="<?php if ($key == 0) {
                                    print 'active';
                                }; ?>"><?php print theme('image_style', array('path' => $image['uri'], 'style_name' => 'big')) ?></li>
                        <?php endforeach; ?>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <?php foreach ($node->field_image[LANGUAGE_NONE] as $key => $image): ?>
                            <div class="item <?php if ($key == 0) {
                                print 'active';
                            }; ?>">
                                <?php print theme('image_style', array('path' => $image['uri'], 'style_name' => 'big')) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#<?php print $node->nid; ?>" role="button" data-slide="prev">
                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#<?php print $node->nid; ?>" role="button"
                       data-slide="next">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($content['field_video'])): ?>
            <div class="video-article">
                <?php print render($content['field_video']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($content['field_description'])): ?>

            <div class="description">
                <?php if ($node->uid == $user->uid || in_array('admin', $user->roles) || in_array('administrator', $user->roles)): ?>
                    <div class="edit-content">
                    <span class="action-link action-link-<?php print $node->nid ?>">
                 <a class="edit-post edit-<?php print $node->nid ?>" data="<?php print $node->nid ?>"
                    href="<?php print url('artline/edit/' . $node->nid . '/nojs') ?>">Sửa</a> |
                 <a class="delete-post delete-<?php print $node->nid ?>" data="<?php print $node->nid ?>"
                    href="#">Xoá</a>
             </span>
                    </div>
                <?php endif; ?>
                <div
                    class="content-desc content-desc-<?php print $node->nid ?>"><?php print render($content['field_description']); ?>
                </div>
                <form data="<?php print $node->nid ?>" class="post-edit-article"
                      name="post_edit_<?php print $node->nid ?>" id="post-edit-<?php print $node->nid ?>">
                    <textarea name="post_<?php print $node->nid ?>" id="edit-post-<?php print $node->nid ?>" cols="40"
                              rows="2"
                              style="padding: 5px"><?php print strip_tags(render($content['field_description'])); ?></textarea>
                    <input type="submit" id="submit-post-<?php print $node->nid ?>" value="Cập nhật"/>
                </form>
            </div>
        <?php endif; ?>
        <div class="more">
            <span class="like-article article-<?php print $node->nid; ?>"
                  data-nid="<?php print $node->nid; ?>" data-uid="<?php print $user->uid; ?>">
                <?php if (artline_user_liked($user->uid, $node->nid)): ?>
                    <i class="fa fa-heart pink" aria-hidden="true"></i>
                <?php else: ?>
                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                <?php endif; ?>
                <i class="count-like"><?php print artline_count_like($node->nid); ?></i>
            </span>


            <span class="share-post" data="<?php print $node->nid ?>"><i class="fa fa-share-alt" aria-hidden="true"></i></span>


            <span id="comment-box-<?php print $node->nid ?>" class="comment" data="<?php print $node->nid ?>"><svg
                    viewBox="1 0 22 22" height="100%" width="100%"><path
                        d="M21.99 4c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2 h14l4 4-.01-18zM18 14H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"></path></svg>
            <i class="count-comment"><?php print $node->comment_count; ?></i>
            </span>
            <span class="readmore-article" data="<?php if (isset($node->field_category[LANGUAGE_NONE])) {
                print url('taxonomy/term/' . $node->field_category[LANGUAGE_NONE][0]['tid']);
            } ?>">xem thêm <i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
            <span class="store" data="<?php print $node->nid ?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Mua hàng</span>
            <a class="store-<?php print $node->nid ?> ctools-use-modal"
               href="<?php print url('artline/store/' . $node->nid . '/nojs') ?>" style="display: none;">Mua hàng</a>
        </div>
        <div class="share-item hidden"
             id="share-button-<?php print $node->nid ?>">
                <span class="a2a_kit a2a_kit_size_40 a2a_target addtoany_list" style="line-height: 30px;">
      <a data="<?php print $node->nid ?>" class="a2a_button_facebook" onClick="return popup(this, 'notes')" href="https://www.facebook.com/sharer/sharer.php?u=<?php print urlencode(url('node/'.$node->nid,array('absolute'=>true))) ?>&amp;src=sdkpreparse" rel="nofollow"><span class="a2a_svg a2a_s__default a2a_s_facebook"
                                                                                                                                                                                                                                                                                   style="width: 30px; line-height: 30px; height: 30px; background-size: 30px; border-radius: 6px;"></span></a>
        <a data="<?php print $node->nid ?>" class="a2a_button_twitter" onClick="return popup(this, 'notes')" href="https://twitter.com/intent/tweet?text=<?php print $node->field_description[LANGUAGE_NONE][0]['value'].' '.url('node/'.$node->nid,array('absolute'=>true)) ?>" rel="nofollow"> <span class="a2a_svg a2a_s__default a2a_s_twitter"
                                                                                                                                                                                                                                                                                                       style="width: 30px; line-height: 30px; height: 30px; background-size: 30px; border-radius: 6px;"></span></a>
    <a data="<?php print $node->nid ?>" class="a2a_button_google_plus" onClick="return popup(this, 'notes')" href="https://plus.google.com/share?url=<?php print urlencode(url('node/'.$node->nid,array('absolute'=>true))) ?>" rel="nofollow"><span class="a2a_svg a2a_s__default a2a_s_google_plus"
                                                                                                                                                                                                                                                     style="width: 30px; line-height: 30px; height: 30px; background-size: 30px; border-radius: 6px;"></span></a>
    </span>
        </div>
        <div class="article-comment post-comment-<?php print $node->nid ?>">
            <?php print artline_conment_form($node->nid, $pid = 0) ?>
        </div>

    </div>
</div>
