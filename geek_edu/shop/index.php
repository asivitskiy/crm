<?php
//6mD:PFjS
//h010445205_mysql
//h010445205.mysql
//h010445205_db
$connect = mysqli_connect('h010445205.mysql','h010445205_mysql','6mD:PFjS','h010445205_db');
mysqli_query($connect,'SET NAMES utf8');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width; initial-scale=1">
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" ></script>
  <!--  <script src="md5.js" ></script>-->
    <style>

        .topsearch {
            float: left;
            width: 200px!important;
        }
        .form-inline {
            padding-left: 0px!important;
        }

    </style>


</head>
<body style="width: 960px; margin: 0 auto;">

<? include "navbar.php"; ?>

<div class="container1">
    <!--        ФОРМА ПРИЁМКИ-->
    <div class="row mt-2">


        <div class="col-10">

            <form class="  col-6" action="add_item_shop.php" method="post">
            <div class="form-row">
                <div class="col-12">
                    <font color="red"> <b><?
                            if (isset($_GET['last'])) {
                                echo "ДОБАВЛЕНО: ";
                            $last_article = $_GET['last'];
                            $sql = mysqli_query($connect,"SELECT * FROM `shop1_items` WHERE `item_article` = '$last_article' LIMIT 1");
                            while ($data = mysqli_fetch_array($sql)) {
                                echo $data['item_name'].'<br>';
                                echo "арт. - ".$data['item_article'].'  /  ';
                                echo "цена. - ".$data['item_input_price'];
                            }

                            }
                            ?></b></font><br>
                    <label for="exampleInputEmail1">Артикул</label>
                    <input type="text" class="form-control" id="article" name="item_article" placeholder="арт." value="<? echo rand(10000000, 99999999); ?>"><!--<div id="md5-screen">123123</div>-->
                    <!--<small id="emailHelp" class="form-text text-muted">Любой непвторяющийся код с этикетки</small>-->
                </div>
                <div class="col-1">
                    <!--<br><div id="md5-screen"></div>-->
                </div>
                <div class="col-12">
                    <label for="exampleInputPassword1">Название</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="item_name" placeholder="Название вещи">
                </div>
            </div>
            <div class="form-row mt-4">
                <div class="col-6">
                    <label for="inputState">Группа товаров</label>
                    <select id="inputState" name="group_id" class="form-control">
                                <option></option>
                                <?
                                $sql = mysqli_query($connect,"SELECT * FROM `item_group` ORDER BY `ccc`");
                                while ($data = mysqli_fetch_array($sql)) {
                                    echo '<option value='.$data["id"].'>';
                                    echo $data['group_name'].' / +'.$data['group_priceup'].'<br>';
                                    echo '%</option>';
                                }

                                ?>
                    </select>
                </div>
                <div class="col-6">
                    <label for="base-summ">Входная цена</label>
                    <input class="form-control" type="text" id="base-summ" name="item_input_price">
                </div>
            </div>

                <div class="form-row mt-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="c-xs" value="option1" name ="c-xs">
                        <label class="form-check-label" for="inlineCheckbox1">XS</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="c-s" value="option2" name ="c-s">
                        <label class="form-check-label" for="inlineCheckbox2">S</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="c-m" value="option3" name ="c-m">
                        <label class="form-check-label" for="inlineCheckbox3">M</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="c-l" value="option3" name ="c-l">
                        <label class="form-check-label" for="inlineCheckbox3">L</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="c-xl" value="option3" name ="c-xl">
                        <label class="form-check-label" for="inlineCheckbox3">XL</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="c-xxl" value="option3" name ="c-xxl">
                        <label class="form-check-label" for="inlineCheckbox3">XXL</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="c-over" value="option3" name ="c-over">
                        <label class="form-check-label" for="inlineCheckbox3">over</label>
                    </div>

                </div>




                <!--        <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>-->
                <button type="submit" class="btn btn-primary mt-5">Добавить</button>
        </form>

        </div>


    </div>
</div>
<script>
    $("#article").keyup(function(){

        var textinput = $('#article').val();
        var md5str = $.md5(textinput);
        /*$('#log').append('<br />Handler for .keyup() called - ' + textinput);*/
        var md5cut = md5str.substr(-2, 2).toUpperCase();

        $("#md5-screen").html(md5cut);




    });
</script>
</body>
</html>