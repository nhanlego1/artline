<?php
/**
 * @file
 * Template file for the theming Popup announcement overlay
 *
 * Available variables:
 * - $announcement_text: A string containing the announcement text.
 */
?>
<div style="display:none" id="popup-announcement-overlay"></div>
<div style="display:none" id="popup-announcement-wrap">
  <div id="popup-announcement">
    <?php print variable_get('popup_info','<h2>Welcome to butvietnhatban.vn</h2>'); ?>
  </div>
  <div id="popup-announcement-close"></div>
</div>
