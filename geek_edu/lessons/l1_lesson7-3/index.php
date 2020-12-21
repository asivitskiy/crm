<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Уроки GKBRNS</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="inc/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row" style="background-color: #f5f5f5; height: 360px;">
        <div class="col-1"></div>
        <div class="col-10 mt-5">
            <div class="topmenu clearfix">
                <a href="#">
                    <img src="img/logo.svg" class="clearfix">
                </a>

                <ul class="topmenu-ul clearfix" style="margin-right: 0px; margin-top: 0px">
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
                <div class="second_page_header">
                    <h2 class="slider-h2">Our Products Range</h2>
                </div>
            </div>



        </div>
        <div class="col-1"></div>
    </div>
    <div class="row" style="height: 90px"></div>
    <div class="row text-center">
        <div class="col-1"></div>
        <div class="col-10 p-0" style="outline: 0px solid black">
            <div class="container-fluid">
                <div class="row row-cols-3">
                    <div class="col" style=""><img src="img/prod-image/product-5.png" style="width: 250px;" class="m-2"></div>
                    <div class="col" style=""><img src="img/prod-image/product-5.png" style="width: 250px;" class="m-2"></div>
                    <div class="col" style=""><img src="img/prod-image/product-5.png" style="width: 250px;" class="m-2"></div>
                    <div class="col" style=""><img src="img/prod-image/product-5.png" style="width: 250px;" class="m-2"></div>
                    <div class="col" style=""><img src="img/prod-image/product-5.png" style="width: 250px;" class="m-2"></div>
                    <div class="col" style=""><img src="img/prod-image/product-5.png" style="width: 250px;" class="m-2"></div>
                    <div class="col" style=""><img src="img/prod-image/product-5.png" style="width: 250px;" class="m-2"></div>
                    <div class="col" style=""><img src="img/prod-image/product-5.png" style="width: 250px;" class="m-2"></div>
                    <div class="col" style=""><img src="img/prod-image/product-5.png" style="width: 250px;" class="m-2"></div>
                    <div class="col" style=""><img src="img/prod-image/product-5.png" style="width: 250px;" class="m-2"></div>
                    <div class="col" style=""><img src="img/prod-image/product-5.png" style="width: 250px;" class="m-2"></div>
                    <div class="col" style=""><img src="img/prod-image/product-5.png" style="width: 250px;" class="m-2"></di300px;

                </div>

            </div>


        </div>
        <div class="col-1"></div>
    </div>
    </div>
</body>
</html>