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
            <a class="ajax cboxElement ctools-use-modal-<?php print $node->nid ?>"
               href="<?php print url('artline/store/' . $node->nid); ?>">Store <?php $node->nid ?></a>
            <a class="ajax cboxElement product-ctools-use-modal-<?php print $node->nid ?>"
               href="<?php print url('artline/product/' . $node->nid); ?>">product <?php $node->nid ?></a>
            <a class="ajax cboxElement xu-ctools-use-modal-<?php print $node->nid ?>"
               href="<?php print url('artline/xu/' . $node->nid); ?>">Store <?php $node->nid ?></a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


