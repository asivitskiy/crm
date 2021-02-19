<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        .workflow_table {
            width: 1400px;
        }
        .graphic {
            width: 150px;
            height: 700px;
            display: flex;
            align-items: flex-start;
        }
        .timeline {
            height: 30px;
            width: 150px;
            box-sizing: border-box;
        }
        .graphicsContainer {
            width: 150px;
            display: flex;
            align-content: flex-start;
            flex-wrap: wrap;
        }
        .graphElement {

            margin: 2px 2px 2px 2px;
            border-radius: 3px;
            width: 65px;
            height: 30px;
            border: 1px dotted grey;
        }
    </style>
</head>
<body>
<table class="workflow_table" border="1">
    <tr>
        <td class="timeline">asdsad</td>
        <td class="timeline" colspan="3">asdsad</td>
        <td class="timeline" colspan="3">asdsad</td>
        <td class="timeline" colspan="3">asdsad</td>

    </tr>
    <tr>
        <td class="timeline">asdsad</td>
        <td class="timeline">asdsad</td>
        <td class="timeline">asdsad</td>
        <td class="timeline">asdsad</td>
        <td class="timeline">asdsad</td>
        <td class="timeline">asdsad</td>
        <td class="timeline">asdsad</td>
        <td class="timeline">asdsad</td>
        <td class="timeline">asdsad</td>
        <td class="timeline">asdsad</td>
    </tr>
    <tr>
        <td class="graphic">
            <div class="graphicsContainer">
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
                <div class="graphElement"></div>
            </div>
        </td>



    </tr>

</table>
<?
/*echo date("w",strtotime(date("Ymd")));*/

$inp = date("Ymd");
$i = 0;
function dateChecker($hz)
{   while (count($dates)<3) {
        if ((date("w", strtotime(date($hz))) <> 6) and (date("w", strtotime(date($hz))) <> 0)) {
            $dates[] = $hz;
            $hz = date('Ymd', strtotime($hz .' +1 day'));
            //если не выходной - пропустится
        } else {$hz = date('Ymd', strtotime($hz .' +1 day'));}
    }
    return $dates;
}
//получаем массив из трёх рабочих дней, включая сегодняшний
print_r(dateChecker($inp));
?>

</body>
</html>