<?php
$event = isset($_POST["event"]) ? $_POST["event"] : "";

$list = [];
$method = $_SERVER["REQUEST_METHOD"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($event == "src") {
        for ($i=0; $i < 10; $i++) { 
            $list[] = $i;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/jquery.blockUI.js"></script>
</head>
<body>
    <script>
        $(function(){
            // $(document).ajaxStop($.unblockUI);

            $(".button").click(function(e){
                $.blockUI();

                $('#event').val("src");
                $('#frm1').submit();

                $.ajax({
                    url: 'blockui_test.php',
                    type: 'POST',
                    cache: false,
                });
            });
        });
    </script>
    <form id="frm1" method="post">
        <input class="button" type="button" value="button">
        <input type="hidden" name="event" id="event">
    </form>

    <div>
        <?php
            echo $method;
            echo "<br>";
            foreach ($list as $key => $value) {
                echo $value;
                echo "<br>";
            }
        ?>
    </div>
</body>
</html>