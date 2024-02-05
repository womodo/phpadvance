<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#table1').DataTable({
                ajax: {
                    url: 'ajax_data.php',
                    dataSrc: '',    // レスポンスのデータの取り出し方。空の場合は直接使用
                },
                columns: [
                    { data:'ITEM_CD' },
                    { data:'MOLD_ITEM_CD' },
                    { data:'PIN_NO' },
                    { data:'QTY' },
                    { data:'STD_QTY', sortable:false },
                ],
                order: [
                    [ 0, 'desc' ],
                ],
                info: false,
                paging: false,
                scrollCollapse: true,
                scrollY: '200px',
                // searching: false,
                dom: '<"top"i>rt<"bottom"flp><"clear">',  /* DataTableの表示要素をカスタマイズ */
            });
        });
    </script>
    <style>
        thead {
            background-color: #f2f2f2;
            border: 1px solid #ddd;
        }
        th,td {
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <table id="table1" class="compact hover stripe">
        <thead>
            <tr>
                <th>ITEM_CD</th>
                <th>MOLD_ITEM_CD</th>
                <th>PIN_NO</th>
                <th>QTY</th>
                <th>STD_QTY</th>
            </tr>
        </thead>
    </table>
</body>
</html>