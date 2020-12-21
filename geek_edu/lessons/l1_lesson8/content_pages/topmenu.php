<div class="topmenu clearfix">
    <a href="#">
        <img  alt="gkbrns" src="img/logo.svg">
    </a>

    <ul class="topmenu-ul clearfix">
        <li class="topmenu-li <? if (($_GET['page'] == 'mainpage') or (!isset($_GET['page']))) {echo 'topmenu-li-active';} ?>">
            <a class="" href="?page=mainpage">HOME</a>
        </li>
        <li class="topmenu-li <? if ($_GET['page'] == 'products') {echo 'topmenu-li-active';} ?>">
            <a class="" href="?page=products">PRODUCTS</a>
        </li>
        <li class="topmenu-li <? if ($_GET['page'] == 'prod-description') {echo 'topmenu-li-active';} ?>">
            <a class="" href="?page=prod-description">Информация о продукте</a>
        </li>
        <li class="topmenu-li">
            <a class="">SHOWROOM</a>
        </li>
        <li class="topmenu-li <? if ($_GET['page'] == 'contacts') {echo 'topmenu-li-active';} ?>">
            <a class="" href="?page=contacts">CONTACT</a>
        </li>
        <li class="topmenu-li">

            <img alt="gkbrns" src="img/search.svg" style="width: 23px; margin-top: 3px; border-bottom: 0px;">

        </li>
    </ul>
</div>