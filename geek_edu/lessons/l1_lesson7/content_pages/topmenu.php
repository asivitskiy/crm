<div class="topmenu clearfix">
    <a href="#">
        <img  alt="gkbrns" src="img/logo.svg">
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
        <li class="topmenu-li <? if ($_GET['page'] == 'contacts') {echo 'topmenu-li-active';} ?>">
            <a class="topmenu-a " href="?page=contacts">CONTACT</a>
        </li>
        <li class="topmenu-li">

            <img alt="gkbrns" src="img/search.svg" style="width: 23px; margin-top: 3px; border-bottom: 0px;">

        </li>
    </ul>
</div>