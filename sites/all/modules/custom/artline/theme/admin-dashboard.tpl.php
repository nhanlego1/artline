<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 11/23/16
 * Time: 11:33 PM
 */
global $user;
?>
<link type="text/css" rel="stylesheet" href="<?php print base_path().drupal_get_path('module','artline') ?>/lib/admin_panel/admin-panel.css" media="all">
<div id="admin-panel">
    <h2>Quản lý</h2>
    <ul><li class="manage"><a href="/admin/content/comment">Quản lý Comment</a></li>
        <li class="manage"><a href="/admin/posts?destination=admin/dashboard">Quản lý bài viết</a></li>
        <li class="manage"><a href="/admin/content/comment?destination=admin/dashboard">Quản lý bình luận</a></li>
        <li class="manage"><a href="/admin/banners?destination=admin/dashboard">Quản lý banner</a></li>
        <li class="manage"><a href="/admin/stores?destination=admin/dashboard">Quản lý store</a></li>
        <li class="manage"><a href="/admin/products?destination=admin/dashboard">Quản lý Product</a></li>
        <li class="manage"><a href="/admin/content/store?destination=admin/dashboard">Sắp xếp store</a></li>
        <li class="manage"><a href="/admin/users">Quản lý Users</a></li>
        <li class="manage"><a href="/admin/structure/taxonomy/location?destination=admin/dashboard">Quản lý location</a></li>
        <li class="manage"><a href="/admin/structure/taxonomy/category?destination=admin/dashboard">Quản lý danh mục</a></li>
        <li class="manage"><a href="/admin/structure/taxonomy/color?destination=admin/dashboard">Quản lý Color</a></li>
        <li class="manage"><a href="/admin/giffs?destination=admin/dashboard">Quản lý quà tặng</a></li>
    </ul>
</div>
<div id="admin-panel">

    <h2>Thêm nội dung</h2>
    <ul>
        <li class="add"><a href="/node/add/article?destination=admin/dashboard">Thêm bài viết</a></li>
        <li class="add"><a href="/node/add/banner?destination=admin/dashboard">Thêm banner</a></li>
        <li class="add"><a href="/node/add/product?destination=admin/dashboard">Thêm sản phẩm</a></li>
        <li class="add"><a href="/node/add/store?destination=admin/dashboard">Thêm store</a></li>
        <li class="add"><a href="/admin/people/create?destination=admin/dashboard">Thêm user</a></li>
        <li class="add"><a href="/admin/structure/taxonomy/category/add?destination=admin/dashboard"> Thêm danh mục sản phẩm</a></li>
        <li class="add"><a href="/admin/structure/taxonomy/color/add?destination=admin/dashboard"> Thêm Color</a></li>
        <li class="add"><a href="/admin/structure/taxonomy/category/add?destination=admin/dashboard"> Thêm location</a></li>
    </ul>
</div>
<div id="admin-panel">

    <h2>Cấu hình và reports </h2>
    <ul>
        <li class="user-logout"><a href="/node/404/edit?destination=admin/dashboard">Sua nội dung Policy</a></li>
        <li class="user-logout"><a href="/admin/report/post?destination=admin/dashboard">Report theo users</a></li>
        <li class="user-logout"><a href="/admin/config/people/accounts/fields/field_info_register?destination=admin/dashboard">Quản lý nội dung thông tin trang dăng ký</a></li>
        <li class="user-logout"><a href="/admin/structure/block/manage/popup_announcement/popup_announcement_1/configure?destination=admin/dashboard">Cấu hình popup trang chủ</a></li>
        <li class="user-logout"><a href="/admin/users/post?destination=admin/dashboard">Thống kê bài viết theo user</a></li>
        <li class="user-logout"><a href="/admin/config/content/artline?destination=admin/dashboard">Cấu hình thông tin website</a></li>
        <li class="user-logout"><a href="/admin/config/system/googleanalytics?destination=admin/dashboard">Google Analystics</a></li>
        <li class="user-logout"><a href="/admin/config/search/metatags?destination=admin/dashboard">Quản lý Metatag</a></li>
        <li class="user-logout"><a href="/admin/config/development/performance?destination=admin/dashboard">Clear cache</a></li>
        <li class="user-logout"><a href="/user/logout">Đăng xuất</a></li>
    </ul>
</div>


