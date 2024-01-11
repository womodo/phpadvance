<?php
$list = [];

if (isset($_POST['event'])) {
    // sleep(1);
    switch ($_POST['event']) {
        case 'insert':
            echo "insert button - text1:".$_POST['text1'];
            break;
        case 'select':
            echo "select button - text1:".$_POST['text1'];
            break;
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="http://malsup.github.io/jquery.blockUI.js"></script>
</head>
<body>
    <script>
        $(function(){
            // $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

            $(".button").click(function(e){
                e.preventDefault();

                var clickBtnValue = $(this).val();
                document.frm1.event.value = clickBtnValue;

                $.blockUI();
                $.ajax({
                    url: 'simple-ajax-in-php.php',
                    type: 'POST',
                    data: $(document.frm1).serialize(),
                    beforeSend: function() {
                        $('#loader').show();
                        $('#result').hide();
                    },
                    success: function(result) {
                        console.log("action preformed succesfully");
                        $('div#result').html('Button clicked: ' + result);
                        $('#loader').hide();
                        $('#result').show();
                        // $('#xxx').html('aaa');

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        $('div#result').html('Error: ' + errorThrown);
                        $('#loader').hide();
                        $('#result').show();
                    }
                }).always(function(){
                    $.unblockUI();
                });
            });
        });
    </script>

    <form name="frm1">
        <input type="text" name="text1">
        <input type="button" class="button" name="insert" value="insert">
        <input type="submit" class="button" name="select" value="select">
        <input type="hidden" name="event">
    </form>

    <img src="images/loader.gif" id="loader" style="display: none;">
    <div id="result"></div>
    <div id="xxx"><?=$xxx?></div>
    
    <?php
    if (count($list) > 0) {
        foreach ($list as $key => $value) {
    ?>
            <div><?=$key?> : <?=$value?></div>
    <?php
        }
    }
    ?>
</body>
</html>