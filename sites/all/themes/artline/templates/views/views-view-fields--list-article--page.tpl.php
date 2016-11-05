<?php
/**
 * Created by PhpStorm.
 * User: nhan
 * Date: 10/27/16
 * Time: 4:57 PM
 */
?>
<div class="news">
    <img src="images/x.png">
    <p class="name">name</p>
    <span><img src="images/ic.png" class="icon-link"></span>
</div>
<div class="slide">
    <div id="1" class="carousel slide" data-ride="carousel" data-interval="false">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#1" data-slide-to="0" class="active"><img src="images/mix.png" alt=""></li>
            <li data-target="#1" data-slide-to="1"><img src="images/mix.png" alt=""></li>
            <li data-target="#1" data-slide-to="2"><img src="images/mix.png" alt=""></li>
            <li data-target="#1" data-slide-to="3"><img src="images/mix.png" alt=""></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="images/slide.png" alt="">
            </div>
            <div class="item">
                <img src="images/slide.png" alt="">
            </div>
            <div class="item">
                <img src="images/slide.png" alt="">
            </div>
            <div class="item">
                <img src="images/slide.png" alt="">
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#1" role="button" data-slide="prev">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#1" role="button" data-slide="next">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
            <span class="sr-only">Next</span>
        </a>
    </div>
