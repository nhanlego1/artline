<?php

/**
 * @file
 * Bartik's theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template normally located in the
 * modules/system directory.
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
 * - $hide_site_name: TRUE if the site name has been toggled off on the theme
 *   settings page. If hidden, the "element-invisible" class is added to make
 *   the site name visually hidden, but still accessible.
 * - $hide_site_slogan: TRUE if the site slogan has been toggled off on the
 *   theme settings page. If hidden, the "element-invisible" class is added to
 *   make the site slogan visually hidden, but still accessible.
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
 * - $page['header']: Items for the header region.
 * - $page['featured']: Items for the featured region.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['triptych_first']: Items for the first triptych.
 * - $page['triptych_middle']: Items for the middle triptych.
 * - $page['triptych_last']: Items for the last triptych.
 * - $page['footer_firstcolumn']: Items for the first footer column.
 * - $page['footer_secondcolumn']: Items for the second footer column.
 * - $page['footer_thirdcolumn']: Items for the third footer column.
 * - $page['footer_fourthcolumn']: Items for the fourth footer column.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see bartik_process_page()
 * @see html.tpl.php
 */

global $user;
?>

<div id="wrapper">
    <div id="page">

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
                            <?php print artline_get_avatar();?>
                        </button>
                        <span class="hide-menu"><i class="fa fa-bars" aria-hidden="true"></i></span>
                        <?php if ($logo): ?>
                            <a class="navbar-brand" href="<?php print $front_page; ?>"
                               title="<?php print t('Home'); ?>"
                               rel="home"
                               id="logo">Artline.vn
                                <!--                                <img src="-->
                                <?php //print $logo; ?><!--" alt="-->
                                <?php //print t('Home'); ?><!--"/>-->
                            </a>
                        <?php endif; ?>

                        <?php if ($site_name || $site_slogan): ?>
                            <div id="name-and-slogan"<?php if ($hide_site_name && $hide_site_slogan) {
                                print ' class="element-invisible"';
                            } ?>>

                                <?php if ($site_name): ?>
                                    <?php if ($title): ?>
                                        <div id="site-name"<?php if ($hide_site_name) {
                                            print ' class="element-invisible"';
                                        } ?>>
                                            <strong>
                                                <a href="<?php print $front_page; ?>"
                                                   title="<?php print t('Home'); ?>"
                                                   rel="home"><span><?php print $site_name; ?></span></a>
                                            </strong>
                                        </div>
                                    <?php else: /* Use h1 when the content title is empty */ ?>
                                        <h1 id="site-name"<?php if ($hide_site_name) {
                                            print ' class="element-invisible"';
                                        } ?>>
                                            <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>"
                                               rel="home"><span><?php print $site_name; ?></span></a>
                                        </h1>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if ($site_slogan): ?>
                                    <div id="site-slogan"<?php if ($hide_site_slogan) {
                                        print ' class="element-invisible"';
                                    } ?>>
                                        <?php print $site_slogan; ?>
                                    </div>
                                <?php endif; ?>

                            </div> <!-- /#name-and-slogan -->
                        <?php endif; ?>

                        <?php if ($user->uid > 0): ?>
                            <div class="info-point">
                                <span class="xu-point-alert"><img
                                        src="<?php print base_path() . drupal_get_path('theme', 'phucma') ?>/images/action.gif"/>
                                </span>
                                <span class="xu-point">
                                    <?php print _user_get_xu($user->uid) ?>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <form class="navbar-form navbar-left" name="search_google" action="/artline/search"
                              method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="keyword" placeholder="Search">
                            </div>
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"
                                                                             aria-hidden="true"></i></button>
                        </form>
                        <?php print render($page['header']); ?>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>

        </header><!-- end header -->


        <?php if ($page['featured']): ?>
            <div id="featured">
                <div class="section clearfix">
                    <?php print render($page['featured']); ?>
                </div>
            </div> <!-- /.section, /#featured -->
        <?php endif; ?>

        <div id="main-wrapper" class="clearfix">
            <div id="main" class="clearfix">

                <div id="content">
                    <div class="container">
                        <div class="row change">
                            <div class="col-md-12">
                                <?php if ($page['highlighted']): ?>
                                    <div class="banner">
                                        <?php print render($page['highlighted']); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($messages): ?>
                                    <div id="messages">
                                        <div class="section clearfix">
                                            <?php print $messages; ?>
                                        </div>
                                    </div> <!-- /.section, /#messages -->
                                <?php endif; ?>
                                <?php print render($title_prefix); ?>
                                <?php print render($title_suffix); ?>
                                <?php print render($page['help']); ?>
                                <?php if ($action_links): ?>
                                    <ul class="action-links">
                                        <?php print render($action_links); ?>
                                    </ul>
                                <?php endif; ?>
                                <div class="main">
                                    <div class="wrap-main">
                                        <div class="row plugin">
                                            <?php print render($page['content']); ?>
                                        </div>

                                    </div>
                                </div>
                                <?php print $feed_icons; ?>

                            </div>
                        </div> <!-- /.section, /#content -->
                    </div>
                    <?php if ($page['sidebar_first']): ?>
                        <div class="hooks">
                            <div class="left-bar">
                                <?php print render($page['sidebar_first']); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>


            </div>
        </div> <!-- /#main, /#main-wrapper -->

        <?php if ($page['triptych_first'] || $page['triptych_middle'] || $page['triptych_last']): ?>
            <div id="triptych-wrapper">
                <div id="triptych" class="clearfix">
                    <?php print render($page['triptych_first']); ?>
                    <?php print render($page['triptych_middle']); ?>
                    <?php print render($page['triptych_last']); ?>
                </div>
            </div> <!-- /#triptych, /#triptych-wrapper -->
        <?php endif; ?>

        <footer>
            <div class="container">
                <div class="row change">
                    <?php print render($page['footer']); ?>

                </div>
            </div>
        </footer><!-- end footer --> <!-- /.section, /#footer-wrapper -->

    </div>
</div> <!-- /#page, /#page-wrapper -->
<div id="ctools-store"></div>
