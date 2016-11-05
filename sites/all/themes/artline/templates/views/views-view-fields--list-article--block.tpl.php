<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 10/27/16
 * Time: 4:57 PM
 */
//dsm($fields);
global $user;
$account = user_load($fields['uid']->raw);
$node = node_load($fields['nid']->raw);
if ($account->picture) {
    $avatar = theme('image_style', array('path' => $account->picture->uri, 'style_name' => 'avatar'));
} else {
    $avatar = '<img src="' . base_path() . path_to_theme("theme", "artline") . '/images/default-avatar.png">';
}
?>

<div class="col-md-6 col-xs-12 product pinto">
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
            <span><img src="<?php print base_path() . drupal_get_path('theme', 'artline') ?>/images/ic.png"
                       class="icon-link"></span>
        </div>
        <?php if (isset($node->field_category[LANGUAGE_NONE])): ?>
            <div class="category-article">
                <?php print $fields['field_category']->content; ?>
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
                                <?php print theme('image_style', array('path' => $image['uri'], 'style_name' => 'small')) ?>
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
        <?php if ($fields['field_video']->content): ?>
            <div class="video-article">
                <?php print $fields['field_video']->content; ?>
            </div>
        <?php endif; ?>
        <?php if ($fields['field_description']): ?>
            <div class="description">
                <?php print $fields['field_description']->content; ?>
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


            <span><i class="fa fa-share-alt" aria-hidden="true"></i></span>
            <span class="comment" data="<?php print $node->nid ?>"><svg viewBox="1 0 22 22" height="100%" width="100%"><path
                        d="M21.99 4c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2 h14l4 4-.01-18zM18 14H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"></path></svg>
            <i class="count-comment"><?php print $node->comment_count; ?></i>
            </span>
            <span class="readmore-article" data="<?php if (isset($node->field_category[LANGUAGE_NONE])) {
                print url('taxonomy/term/' . $node->field_category[LANGUAGE_NONE][0]['tid']);
            } ?>">read more <i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
            <span><i class="fa fa-shopping-cart" aria-hidden="true"></i>Buy now</span>
        </div>
        <div class="article-comment post-comment-<?php print $node->nid ?>" style="display: none;">
            <?php print artline_conment_form($node->nid, $pid = 0) ?>
        </div>
    </div>
</div>
