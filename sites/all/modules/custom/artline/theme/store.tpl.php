<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 10/31/16
 * Time: 5:37 PM
 */
$current_tid = $tid;
?>


<div class="store-wrapper">
    <div class="location">
        <select id="location-selector">
            <option>Chọn khu vực bạn gần nhất</option>
            <?php foreach (get_location() as $tid => $name): ?>
                <option value="<?php print $tid ?>"><?php print $name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="clearfix"></div>

    <ul class="store">
        <?php if ($nodes): ?>
            <?php foreach ($nodes as $node): ?>
                <?php if ($col1 = artline_load_collection($node)): ?>
                    <?php foreach ($col1 as $colect1): $colect1 = reset($colect1); ?>
                        <?php if ($colect1->field_category[LANGUAGE_NONE][0]['tid'] == $current_tid): ?>
                            <li class=" location
                    <?php foreach ($node->field_location[LANGUAGE_NONE] as $location): ?>
                    location-<?php print $location['tid'] ?>

                    <?php endforeach; ?>
                    ">
                                <div class="name-store"><a href="javascript:;">> <?php print $node->title; ?></a></div>
                                <span class="detail-store">
                            <p><?php print $node->body[LANGUAGE_NONE][0]['value'] ?></p>
                            <p><?php print l($colect1->field_link_title[LANGUAGE_NONE][0]['value'], $colect1->field_link[LANGUAGE_NONE]['0']['value'], array('attributes' => array('target' => '_blank'))) ?></p>
                        </span>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Không có cửa hàng nào bán sản phẩm này.</p>
        <?php endif; ?>
        <?php if ($tqs = get_store_toanquoc()): ?>
            <h2>Bán trên toàn quốc</h2>
            <?php foreach ($tqs as $ts): ?>

                <?php if ($col = artline_load_collection($ts)): ?>
                    <?php foreach ($col as $collect): $collect = reset($collect); ?>
                        <?php if ($collect->field_category[LANGUAGE_NONE][0]['tid'] == $current_tid): ?>

                            <li>
                                <div class="name-store"><a href="javascript:;">> <?php print $ts->title; ?></a></div>
                                <span class="detail-store">
                            <p><?php print $ts->body[LANGUAGE_NONE][0]['value'] ?></p>
                            <p><?php print l($collect->field_link_title[LANGUAGE_NONE][0]['value'], $collect->field_link[LANGUAGE_NONE]['0']['value'], array('attributes' => array('target' => '_blank'))) ?></p>
                        </span>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>


</div>

<script>
    jQuery(document).ready(function () {
        //Examples of how to assign the Colorbox event to elements
        jQuery(".name-store a").each(function () {

            jQuery(this).click(function () {
                //jQuery(".detail-store").hide();
                jQuery(this).parent().next().toggle();
                return false;
            });
        });

        jQuery('select#location-selector').niceSelect();

        jQuery("#location-selector").change(function () {
            jQuery("ul.store .location").hide();
            var tid_ = jQuery(this).val();
            jQuery("ul.store li.location-" + tid_).show();
        });
    });
</script>

