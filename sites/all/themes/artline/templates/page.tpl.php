<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>
<header>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span><img src="<?php print base_path().drupal_get_path('theme','artline') ?>/images/x.png"></span>
                </button>
                <span class="hide-menu"><i class="fa fa-bars" aria-hidden="true"></i></span>
                <?php if ($logo): ?>
                    <a navbar-brand href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"
                       id="logo">
                        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>"/>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <?php print render($page['header']); ?>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

</header><!-- end header -->

<div id="content">
    <div class="container">
        <div class="row change">
            <div class="col-md-12">
                <?php if ($page['highlighted']): ?>
                    <div class="banner">
                        <?php print render($page['highlighted']); ?>
                    </div>
                <?php endif; ?>

                <div class="main">
                    <div class="wrap-main">
                        <div class="row plugin">
                            <?php print $messages; ?>
                            <?php if ($tabs): ?>
                                <div class="tabs"><?php print render($tabs); ?></div>
                            <?php endif; ?>
                            <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
                            <?php print render($page['content']); ?>
                            <?php print $feed_icons; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($page['sidebar_first']): ?>
        <div class="hooks">
            <div class="left-bar">
                <?php print render($page['sidebar_first']); ?>
            </div>
        </div>
    <?php endif; ?>
</div><!-- end .content -->

<footer>
    <div class="container">
        <div class="row change">
            <?php print render($page['footer']); ?>
            <div class="col-md-4">
                <div class="social-icon">
                    <a href="#" title="Linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                    <a href="#" title="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="#" title="youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a><br />
                    <a href="#" title="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    <a href="#" title="Linkedin"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                    <a href="#" title="Linkedin"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="col-md-8">
                <div class="info">
                    <h4>Cong ty TNHH thuong mai phuc ma</h4>
                    <p class="address">220/38 Xô Viết Nghệ Tĩnh, P.21, Q.Bình Thạnh, Tp. Hồ Chí Minh.<br />
                        (84).08.3514 0805 - Fax: (84).08.3899 0677<br />
                        Hotline: 0908.179.625 (Mr.Dũng).<br />
                        vphcm@phucma.com.vn - info@phucma.com.vn.
                    </p>
                    <p class="copyright">2016 © artline. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer><!-- end footer -->

