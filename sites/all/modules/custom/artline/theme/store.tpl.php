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
        <select id="location-selector" class="chosen-select--">
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
                <?php if ($col1 = artline_load_collection($node)): $col1 = reset($col1); ?>
                    <?php if($col1->field_category[LANGUAGE_NONE][0]['tid']==$current_tid): ?>
                    <li class=" location location-<?php print $node->field_location[LANGUAGE_NONE][0]['tid'] ?>">
                        <div class="name-store"><a href="javascript:;">> <?php print $node->title; ?></a></div>
                        <span class="detail-store">
                            <p><?php print $node->body[LANGUAGE_NONE][0]['value'] ?></p>
                            <p><?php print l($col1->field_link_title[LANGUAGE_NONE][0]['value'], $col1->field_link[LANGUAGE_NONE]['0']['value'], array('attributes'=>array('target'=>'_blank'))) ?></p>
                        </span>
                    </li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Không có cửa hàng nào bán sản phẩm này.</p>
        <?php endif; ?>
        <?php if ($tqs = get_store_toanquoc()):?>
            <h2>Bán trên toàn quốc</h2>
            <?php foreach ($tqs as $ts): ?>
                <?php if ($col = artline_load_collection($ts)): $col = reset($col);?>

                    <?php if($col->field_category[LANGUAGE_NONE][0]['tid']==$current_tid): ?>

                    <li>
                        <div class="name-store"><a href="javascript:;">> <?php print $ts->title; ?></a></div>
                        <span class="detail-store">
                            <p><?php print $ts->body[LANGUAGE_NONE][0]['value'] ?></p>
                            <p><?php print l($col->field_link_title[LANGUAGE_NONE][0]['value'], $col->field_link[LANGUAGE_NONE]['0']['value'],array('attributes'=>array('target'=>'_blank'))) ?></p>
                        </span>
                    </li>
                    <?php endif; ?>
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

<!--<script type="text/javascript">-->
<!--    var config = {-->
<!--        '.chosen-select'           : {},-->
<!--        '.chosen-select-deselect'  : {allow_single_deselect:true},-->
<!--        '.chosen-select-no-single' : {disable_search_threshold:10},-->
<!--        '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},-->
<!--        '.chosen-select-width'     : {width:"95%"}-->
<!--    }-->
<!--    for (var selector in config) {-->
<!--        jQuery(selector).chosen(config[selector]);-->
<!--    }-->
<!--</script>-->
