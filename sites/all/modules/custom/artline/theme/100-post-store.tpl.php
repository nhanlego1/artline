<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 11/10/16
 * Time: 11:54 PM
 */
?>
<div class="200-post-store" style="display: none;">
    <?php if ($nodes): ?>
        <?php foreach ($nodes as $node): ?>
            <a class="ajax cboxElement ctools-use-modal-<?php print $node ?>"
               href="<?php print url('artline/store/' . $node); ?>">Store <?php $node ?></a>
            <a class="ajax cboxElement product-ctools-use-modal-<?php print $node ?>"
               href="<?php print url('artline/product/' . $node); ?>">product <?php $node ?></a>
            <a class="ajax cboxElement xu-ctools-use-modal-<?php print $node ?>"
               href="<?php print url('artline/xu/' . $node); ?>">Store <?php $node ?></a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


