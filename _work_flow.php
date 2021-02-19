<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        .workflow_wrapper * {
            margin: 0;
            box-sizing: border-box;
        }
        .workflow_wrapper {
            display: flex;
            width: 1200px;
            justify-content: space-between;
        }
        .workflow__row {
            margin-top: 25px;
            border: 1px solid black;
            width: 100%;
            display: flex;
            flex-wrap: nowrap;
        }

        .workflow__col {
            width: 100%;
            border: 3px solid grey;
            padding: 5px;
            display: flex;
            flex-wrap: wrap;
        }

        .workflow__order-card {
            margin: 1px 1px 1px 1px;
            padding: 1px 1px 1px 1px;
            width: 100px;
            height: 30px;
            border:1px dotted gray;
            border-radius: 3px;
        }

    </style>
</head>
<body>
    <div class="workflow_wrapper">
        <div class="workflow__row">
            <div class="workflow__col">
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card" style="height: 50px; width: 70px"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
            </div>
            <div class="workflow__col">
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
            </div>
            <div class="workflow__col">
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
            </div>
            <div class="workflow__col">
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
            </div>
            <div class="workflow__col">
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
                <div class="workflow__order-card"></div>
            </div>

        </div>

    </div>

</body>
</html>