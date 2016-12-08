<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 12/6/16
 * Time: 11:14 AM
 */
?>

<div class="product-wrapper">
    <div class="image-product col-md-6">
        <?php print theme('image_style', array('path' => $product->field_product_image[LANGUAGE_NONE][0]['uri'], 'style_name' => 'medium')) ?>
    </div>
    <div class="info-product col-md-6">
        <div class="product-name">
            <?php print $product->title; ?>
        </div>
        <?php if (isset($product->field_price[LANGUAGE_NONE])) : ?>
            <div class="product-price">
                <?php print number_format($product->field_price[LANGUAGE_NONE][0]['value']) ?>đ
            </div>
        <?php endif; ?>
        <?php if (isset($product->field_xu[LANGUAGE_NONE])) : ?>
            <div class="pointer">
                <?php print $product->field_xu[LANGUAGE_NONE][0]['value'] ?> điểm
            </div>
        <?php endif; ?>
    </div>
    <div class="clearfix"></div>
    <div class="notice-alert col-md-12">
        <?php if(isset($product->	field_notice_color[LANGUAGE_NONE])): ?>
          <p><strong>***Chú ý:</strong> <?php print $product->	field_notice_color[LANGUAGE_NONE][0]['value'] ?></p>
        <?php endif; ?>
    </div>
    <div class="clearfix"></div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('select').niceSelect();

        jQuery('#artline-product-gif-change #edit-address-info').change(function(){
            if(jQuery(this).val() == 1){
                jQuery('#artline-product-gif-change .form-item-name').show();
                jQuery('#artline-product-gif-change .form-item-address').show();
                jQuery('#artline-product-gif-change .form-item-telephone').show();
            }else{
                jQuery('#artline-product-gif-change .form-item-name').hide();
                jQuery('#artline-product-gif-change .form-item-address').hide();
                jQuery('#artline-product-gif-change .form-item-telephone').hide();
            }
        });
    });
</script>
