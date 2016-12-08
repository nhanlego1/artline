<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 11/23/16
 * Time: 11:33 PM
 */
global $user;
?>
<div id="admin-panel">
    <h2>Quản lý</h2>
    <ul>
        <li class="manage"><a href="/admin/posts">Quản lý bài viết</a></li>
        <li class="manage"><a href="/admin/content/comment">Quản lý bình luận</a></li>
        <li class="manage"><a href="/admin/banners">Quản lý banner</a></li>
        <li class="manage"><a href="/admin/stores">Quản lý store</a></li>
        <li class="manage"><a href="/admin/content/store">Sắp xếp store</a></li>
        <li class="manage"><a href="/admin/users">Quản lý Users</a></li>
        <li class="manage"><a href="/admin/structure/taxonomy/location">Quản lý location</a></li>
        <li class="manage"><a href="/admin/structure/taxonomy/category">Quản lý danh mục</a></li>
        <li class="manage"><a href="/admin/giffs">Quản lý quà tặng</a></li>
    </ul>
</div>
<div id="admin-panel">

    <h2>Thêm nội dung</h2>
    <ul>
        <li class="add"><a href="/node/add/article">Thêm bài viết</a></li>
        <li class="add"><a href="/node/add/banner">Thêm banner</a></li>
        <li class="add"><a href="/node/add/product">Thêm sản phẩm</a></li>
        <li class="add"><a href="/node/add/store">Thêm store</a></li>
        <li class="add"><a href="/admin/people/create">Thêm user</a></li>
        <li class="add"><a href="/admin/structure/taxonomy/category/add"> Thêm danh mục sản phẩm</a></li>
        <li class="add"><a href="/admin/structure/taxonomy/category/add"> Thêm location</a></li>
    </ul>
</div>
<div id="admin-panel">

    <h2>Cấu hình và reports </h2>
    <ul>
        <li class="user-logout"><a href="/admin/report/post">Report theo users</a></li>
        <li class="user-logout"><a href="/admin/users/post">Thống kê bài viết theo user</a></li>
        <li class="user-logout"><a href="/admin/config/content/artline">Setting Artline</a></li>
        <li class="user-logout"><a href="/admin/config/system/googleanalytics">Google Analystics</a></li>
        <li class="user-logout"><a href="/admin/config/search/metatags">Quản lý Metatag</a></li>
        <li class="user-logout"><a href="/admin/config/development/performance">Clear cache</a></li>
        <li class="user-logout"><a href="/user/logout">Đăng xuất</a></li>
    </ul>
</div>


