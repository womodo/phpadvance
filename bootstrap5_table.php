<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* 固定高さのコンテナ */
        .fixed-height-container {
            /* height: 200px; */
            /* 適切な高さに調整してください */
            overflow-y: auto;
            /* テーブルがコンテナを超える場合にスクロール可能にする */
        }

        /* スクロール時に固定するthead */
        .fixed-thead {
            position: sticky;
            top: 0;
        }
    </style>
    <title>Fixed Height Container with Scrollable Table</title>
</head>

<body>
    <div class="container-fluid" style="background-color: antiquewhite;">
        <div class="row">
            <div class="col p-0">
                <input type="text" id="text1">
            </div>
        </div>
    </div>

    <div class="container-fluid fixed-height-container" id="tableWrapper">
        <div class="row">
            <div class="col p-0">
                <table class="table table-bordered table-sm mb-0" id="table1">
                    <thead class="table-dark fixed-thead">
                        <tr>
                            <td>ITEM_CD</td>
                            <td>MOLD_ITEM_CD</td>
                            <td>PIN_NO</td>
                            <td>QTY</td>
                            <td>STD_QTY</td>
                        </tr>
                    </thead>
                    <tbody id="tbody1"></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="background-color: antiquewhite;">
        <div class="row">
            <div class="col p-0">
                test
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="js/jquery.blockUI.js"></script>
    <script>
        $(document).ready(function(){
            //画面読み込み時に実行
            getTableData();

            //inputが入力された時に実行
            $('#text1').on('change', function() {
                var inputValue = $(this).val();
                getTableData(inputValue);
            });
        });

        //テーブルのデータを取得して画面表示
        function getTableData(qty = 0) {
            $.blockUI();
            var tableWrapper = document.getElementById('tableWrapper');
            var tbody = $('#tbody1');

            $.ajax({
                type: 'POST',
                url: 'ajax_data.php',
                data: { qty : qty },
                dataType: 'json',
            })
            .done(function(data) {
                tbody.empty();
                tableWrapper.style.height = null;

                $.each(data, function(index, value) {
                    tbody.append(
                        '<tr>' +
                        `<td>${value.ITEM_CD}</td>` +
                        `<td>${value.MOLD_ITEM_CD}</td>` +
                        `<td>${value.PIN_NO}</td>` +
                        `<td>${value.QTY}</td>` +
                        `<td>${value.STD_QTY}</td>` +
                        '</tr>');
                });
            })
            .fail(function(error) {
                tbody.empty();
                tableWrapper.style.height = null;

                console.log(error);
            })
            .always(function(xhr, msg) {
                var tableyHeight = document.getElementById('table1').clientHeight;
                if (tableyHeight > 200) {
                    tableWrapper.style.height = '200px';
                } else {
                    tableWrapper.style.height = null;
                }
                $.unblockUI();
            });
        }
    </script>
</body>
</html>