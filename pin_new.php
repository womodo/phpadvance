<?php
$dbname = "phpadvance";
$servername = "localhost";
$username = "root";
$password = "zaq12wsx";
$dsn = "mysql:dbname=".$dbname.";host=".$servername;
$dbh = new PDO($dsn, $username, $password);

$event = htmlspecialchars($_POST["event"]);

$PinName = htmlspecialchars($_POST["PinName"]);
$SlopePinFlg = htmlspecialchars($_POST["SlopePinFlg"]);
$OdrQty = htmlspecialchars($_POST["OdrQty"]);
$StockQty = htmlspecialchars($_POST["StockQty"]);
$StdQty = htmlspecialchars($_POST["StdQty"]);

if ($event == "save") {
    if ($SlopePinFlg == 'on') {
        $SlopePinFlg = '1';
    } else {
        $SlopePinFlg = '0';
    }

    $sql = "INSERT INTO m_pin ";
    $sql.= "(PIN_NAME,SLOPE_PIN_FLG,ODR_QTY,STOCK_QTY,STD_QTY) ";
    $sql.= "VALUES ('$PinName','$SlopePinFlg',$OdrQty,$StockQty,$StdQty) ";
    $dbh->exec($sql);
    $flg = "save";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ピン新規登録</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <form method="post" name="frm1">
        <div class="container-fluid mt-3 mb-3">
            <div class="card">
                <div class="card-header">
                    ピンの新規登録
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <label for="PinName" class="col-3 col-form-label text-end">ピン名</label>
                        <div class="col-9">
                            <input type="text" class="form-control text-center" name="PinName" id="PinName">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3 text-end"></div>
                        <div class="col-9">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="SlopePinFlg" id="SlopePinFlg">
                                <label class="form-check-label" for="SlopePinFlg">傾斜ピン</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="OdrQty" class="col-3 col-form-label text-end">発注点</label>
                        <div class="col-9">
                            <input type="number" class="form-control text-center" name="OdrQty" id="OdrQty">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="StockQty" class="col-3 col-form-label text-end">在庫数</label>
                        <div class="col-9">
                            <input type="number" class="form-control text-center" name="StockQty" id="StockQty">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="StdQty" class="col-3 col-form-label text-end">基準ショット数</label>
                        <div class="col-9">
                            <input type="number" class="form-control text-center" name="StdQty" id="StdQty">
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-3">
                            <button type="button" class="btn btn-primary" style="width:120px;" id="btnSave">登録</button>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-dark" style="width:120px;" id="btnClose">閉じる</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="event" value="<?=$event?>">
    </form>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(function() {
            // 登録ボタン
            $('#btnSave').on('click', function() {
                // 入力チェック
                var errmsg = "";

                var PinName = $('#PinName').val();
                if (PinName == "") {
                    errmsg += "ピン名が入力されていません。" + "\n";
                }

                // 同じピン名のものがすでに登録されている場合はエラー
                

                if (errmsg == "") {
                    // 保存
                    document.frm1.event.value = "save";
                    document.frm1.submit();                
                } else {
                    alert(errmsg);
                }
            });

            // 閉じるボタン
            $('#btnClose').on('click', function() {
                window.close();
            });
        });
    </script>

    <script>
        // 処理終了時
        var flg = '<?php echo($flg)?>';
        if (flg == 'save') {
            alert('登録しました。');
            window.close();
            // 呼び出し元の関数(getPinItemList)を呼び出す
            window.opener.getPinItemList();
        }
    </script>
</body>
</html>