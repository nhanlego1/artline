<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 11/5/16
 * Time: 10:08 PM
 */
global $user;
?>
<?php if(in_array('admin',$user->roles) || in_array('administrator',$user->roles)): ?>
  <div class="admin-dashboard-back">
      <a href="/admin/dashboard"><< Back to dashboard</a>
  </div>
<?php endif; ?>
