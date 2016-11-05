<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 10/31/16
 * Time: 5:37 PM
 */
?>

<div class="store-wrapper">
    <div class="location">
      <select id="location-selector">
          <option>Chọn khu vực bạn gần nhất</option>
       <?php foreach(get_location() as $tid => $name): ?>
          <option value="<?php print $tid ?>"><?php print $name ?></option>
       <?php endforeach; ?>
      </select>
    </div>
    <div class="clearfix"></div>
    <?php if($nodes): ?>
    <ul class="store">
        <?php foreach($nodes as $node): ?>
         <li class="location-<?php print $node->field_location[LANGUAGE_NONE][0]['tid'] ?>">
             <div class="name-store"><a href="javascript:;">> <?php print $node->title; ?></a></div>
             <span class="detail-store"><?php print $node->body[LANGUAGE_NONE][0]['value'] ?></span>
         </li>
        <?php endforeach; ?>
    </ul>
    <?php else: ?>
    <p>Không có cửa hàng nào bán sản phẩm này.</p>
    <?php endif; ?>


</div>

<script>
    jQuery(document).ready(function(){
        //Examples of how to assign the Colorbox event to elements
        jQuery(".name-store a").each(function(){

            jQuery(this).click(function(){
                //jQuery(".detail-store").hide();
                jQuery(this).parent().next().toggle();
                return false;
            }) ;
        });

        jQuery('select#location-selector').niceSelect();

        jQuery("#location-selector").change(function(){
            jQuery("ul.store li").hide();
           var tid_ = jQuery(this).val();
            jQuery("ul.store li.location-"+tid_).show();
        });
    });
</script>
