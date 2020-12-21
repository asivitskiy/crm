<?php
$connect = mysqli_connect('h010445205.mysql','h010445205_mysql','6mD:PFjS','h010445205_db');
mysqli_query($connect,'SET NAMES utf8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width; initial-scale=0.75">
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" ></script>
</head>
<body>

<? include "navbar.php"; ?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">First</th>
        <th scope="col">Last</th>
        <th scope="col">Handle</th>
    </tr>
    </thead>
    <tbody>



<?
$sql = mysqli_query($connect,"SELECT * FROM `shop1_items` ORDER BY `id` DESC");
while ($data = mysqli_fetch_array($sql)) {
/*    echo $data['item_article'];
    echo $data['item_name']."  -  ";
    echo $data['item_out_price']."  -  ";
    echo $data['item_size']." <br>"; */?>
    <tr>
        <th scope="row"><?  echo $data['item_article']; ?></th>
        <td><?  echo $data['item_name']; ?></td>
        <td><?  echo $data['item_out_price']; ?></td>
        <td><?  echo $data['item_size']; ?></td>
    </tr>

<?
}

?>

    </tbody>
</table>
</body>
</html>