<?php
$dbserver = "localhost";
$dbuser = "root";
$dbpassword = "zaq12wsx";
$dbname = "phpadvance";

$dsn = "mysql:host={$dbserver}; dbname={$dbname}; charset=utf8";
$options = array(PDO::ATTR_PERSISTENT);
$conn = new PDO($dsn, $dbuser, $dbpassword, $options);

$sql = "SELECT ITEM_CD,MOLD_ITEM_CD,COUNT(*) AS CNT FROM m_pin GROUP BY ITEM_CD,MOLD_ITEM_CD";
$stmt = $conn->prepare($sql);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM m_pin";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// print_r($items);
// echo "</pre>";

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: solid 1px;
            text-align: center;
            padding: 5px;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>ITEM_CD</th>
            <th>MOLD_ITEM_CD</th>
            <th>PIN_NO</th>
            <th>QTY</th>
            <th>STD_QTY</th>
        </tr>
        <?php
        foreach ($items as $item) {
            $idx = 0;
            foreach ($results as $rows) {
                if ($item["ITEM_CD"] == $rows["ITEM_CD"] && $item["MOLD_ITEM_CD"] == $rows["MOLD_ITEM_CD"]) {
                    echo "<tr>";
                    if ($idx == 0) {
                        echo "<td rowspan=".$item["CNT"].">".$item["ITEM_CD"]."</td>";
                        echo "<td rowspan=".$item["CNT"].">".$item["MOLD_ITEM_CD"]."</td>";
                    }
                    echo "<td>".$rows["PIN_NO"]."</td>";
                    echo "<td>".$rows["QTY"]."</td>";
                    echo "<td>".$rows["STD_QTY"]."</td>";
                    echo "</tr>";
                    $idx++;
                }
            }
        }
        ?>
    </table>
</body>
</html>