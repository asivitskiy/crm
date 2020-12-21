<div class="topmenu clearfix">
    <a href="#">
        <img src="img/logo.svg">
    </a>

    <ul class="topmenu-ul clearfix">
        <li class="topmenu-li <? if (($_GET['page'] == 'mainpage') or (!isset($_GET['page']))) {echo 'topmenu-li-active';} ?>">
            <a class="topmenu-a" href="?page=mainpage">HOME</a>
        </li>
        <li class="topmenu-li <? if ($_GET['page'] == 'products') {echo 'topmenu-li-active';} ?>">
            <a class="topmenu-a" href="?page=products">PRODUCTS</a>
        </li>
        <li class="topmenu-li">
            <a class="topmenu-a">HISTORY</a>
        </li>
        <li class="topmenu-li">
            <a class="topmenu-a">SHOWROOM</a>
        </li>
        <li class="topmenu-li">
            <a class="topmenu-a">CONTACT</a>
        </li>
        <li class="topmenu-li">
            <!--<a class="topmenu-a">-->
            <img src="img/search.svg" style="width: 23px; border-bottom: 0px;">
            </a>
        </li>
    </ul>
</div>