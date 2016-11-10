<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 11/9/16
 * Time: 9:29 PM
 */
?>

<?php if($nodes): ?>
  <?php foreach($nodes as $node): ?>
 <?php print _post_list_detail($node); ?>
        <?php endforeach; ?>
<?php endif; ?>

