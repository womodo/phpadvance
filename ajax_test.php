<?php
// この部分はPHPコードとして実行される
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    if (isset($_POST['functionName'])) {
        // Ajaxリクエストがある場合の処理
        $functionName = $_POST['functionName'];
        $param1 = $_POST['param1'];
        $param2 = $_POST['param2'];

        // PHP関数の呼び出し
        if (function_exists($functionName)) {
            $result = call_user_func_array($functionName, array($param1, $param2));
            echo $result;
        }

        // switch ($functionName) {
        //     case 'your_php_function1':
        //         $result = your_php_function1($param1, $param2);
        //         echo $result;
        //         break;
        //     case 'your_php_function2':
        //         // $result = your_php_function2($param1, $param2);
        //         // $result = call_user_func($functionName, $param1, $param2);
        //         echo $result;
        //         break;
        //     default:
        //         break;
        // }
        exit;
    } else {
        if (isset($_POST['param1']) && $_POST['param1'] == 'error') {
            header("HTTP/1.1 500 Internal Server Error");
            echo "エラーが発生しました。";
        } else {
            $responseData = array(
                'success' => true,
                'message' => '正常なリクエストです。',
            );
            header('Content-Type: application/json');
            echo json_encode($responseData);
        }
        exit;
    }
}

// 呼び出される関数
function your_php_function1($param1, $param2) {
    return "Result: " . $param1 . ", " . $param2;
}
function your_php_function2($param1, $param2) {
    // return "Result: " . $param1 . ", " . $param2;
    return json_encode(["param1"=>$param1, "param2"=>$param2]);
}

// この部分はファイルにアクセスされた時に実行される
$phpVariable = "Hello from PHP!";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP, jQuery, and Ajax Example</title>
    <!-- jQueryをCDNから読み込む -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <script>
        // この部分はJavaScriptとして実行される

        // button2をクリックした時
        function button2_click() {
            // Ajaxリクエストを作成
            $.ajax({
                type: "POST",
                url: "", // 空の場合、同じファイルに対してリクエストを送信
                data: {
                    functionName: "your_php_function2",
                    param1: $('#inputText').val(),
                    param2: "value2",
                },
                success: function (result) {
                    // Ajaxリクエストの成功時の処理
                    console.log(result);
                    $("#p2").html(result);
                }
            });
        }

        function button3_click() {
            $.ajax({
                type: "POST",
                url: "", // 空の場合、同じファイルに対してリクエストを送信
                data: {
                    param1: $('#inputText').val(),
                },
            }).done(function(response) {
                // 成功時
                console.log(response);
                $("#p2").html(response);
            }).fail(function(xhr, status, error) {
                // 失敗時
                console.error('エラー:', xhr, status, error);
            });
        }
    </script>
</head>
<body>
    <h1><?php echo $phpVariable ?></h1>

    <form id="myForm" method="post">
        <input type="text" name="inputText" id="inputText">
        <button type="submit">button1</button>
    </form>

    <button type="button" onclick="button2_click()">button2</button>
    <button type="button" onclick="button3_click()">button3</button>

    <p id="p2"></p>


    <script>
        // 
        $('#myForm').submit(function(event) {
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "", // 空の場合、同じファイルに対してリクエストを送信
                data: {
                    functionName: "your_php_function1",
                    param1: $('#inputText').val(),
                    param2: "value2",
                },
                success: function (result) {
                    // Ajaxリクエストの成功時の処理
                    console.log(result);
                    $("#p2").html(result);
                }
            });
        });
    </script>
</body>
</html>