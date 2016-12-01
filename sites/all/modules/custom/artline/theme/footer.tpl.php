<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 11/7/16
 * Time: 8:17 PM
 */
?>
<?php if (arg(0) == 'taxonomy' && is_numeric(arg(2)) && arg(3)==null || arg(0)=='article' && arg(1)=='user' || drupal_is_front_page()): ?>
    <div class="loading-view"  data="<?php if(arg(0)=='taxonomy'){ print arg(2);}else{print 0;}  ?>" ><img
        src="<?php print base_path() . drupal_get_path('module', 'artline') ?>/images/ajax-loader.gif"/></div>
</div>
<?php endif; ?>
<div class="footer-content">
    <div class="col-md-4">
        <div class="social-icon">
            <a href="<?php print variable_get('facebook_link'); ?>" title="facebook"><i class="fa fa-facebook"
                                                                                        aria-hidden="true"></i></a>
            <a href="<?php print variable_get('youtube_link'); ?>" title="youtube"><i class="fa fa-youtube"
                                                                                      aria-hidden="true"></i></a><br/>
        </div>
    </div>
    <div class="col-md-8">
        <div class="info">
            <?php if (variable_get('company_name')): ?>
                <h4><?php print variable_get('company_name'); ?></h4>
            <?php endif; ?>
            <?php if (variable_get('address')): ?>
                <p class="address"><?php print variable_get('address'); ?></p>
            <?php endif; ?>
            <?php if (variable_get('phone')): ?>
                <p>ĐT: <?php print variable_get('phone'); ?> - Fax: <?php print variable_get('fax'); ?></p>
            <?php endif; ?>
            <?php if (variable_get('hotline')): ?>
                <p> Hotline: <?php print variable_get('hotline'); ?></p>
            <?php endif; ?>
            <?php if (variable_get('email_company')): ?>
                <p><?php print variable_get('email_company'); ?> </p>
            <?php endif; ?>
            <p class="copyright">2016 © Artline All rights reserved.</p>
        </div>
    </div>
</div>
