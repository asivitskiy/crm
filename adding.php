<!DOCTYPE HTML>
<html>

<head>
    <title>Untitled</title>
    <meta charset="utf-8">
    <style type="text/css">
    #ss, .del_variant{
      cursor: pointer;
    }

    </style>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script>
    $(document)
        .ready(function () {
            var variant = $('#uzz')
                .clone(true);
            $('#ss')
                .click(function () {
                    $(variant)
                        .clone(true)
                        .appendTo('#variants')
                        .fadeIn('slow')
                        .find("input[name*=name]")
                        .focus();
                });
            $(document)
                .on('click', 'a.del_variant:not(:first)' , function () {
                    $(this)
                        .parents(".control-group")
                        .remove();
                });
        });
    </script>
</head>

<body>
    <div id="variants">
        <div class="control-group" id="uzz">
            <label class="control-label">Username</label>
            <div class="controls">
                <input type="text" placeholder="Username" name="name[]"> <a class="del_variant">X</a>
            </div>
        <div class="control-group" id="uzz">
            <label class="control-label">Username</label>
            <div class="controls">
                <input type="text" placeholder="Username" name="name[]"> <a class="del_variant">X</a>
            </div>
        
		</div>
		
    </div><span id="ss">Добавить вариант</span>
</body>

</html>