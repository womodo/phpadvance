<?php
$dbname = "phpadvance";
$servername = "localhost";
$username = "root";
$password = "zaq12wsx";
$dsn = "mysql:dbname=".$dbname.";host=".$servername;
$dbh = new PDO($dsn, $username, $password);

$data = [];
$target = htmlspecialchars($_POST["target"]);

function querySql($sql) {
    global $dbh;
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data = [];
    foreach ($result as $rows) {
        foreach ($rows as $key => $value) {
            if ($value == null) {
                $value = "";
            }
            $row[$key] = $value;
        }
        $data[] = $row;
    }
    return $data;
}

// ピン名
if ($target == "PinName") {
    $sql = "SELECT DISTINCT PIN_ID,PIN_NAME FROM m_pin ";
    $sql.= "WHERE 0 = 0 ";
    $sql.= "ORDER BY PIN_ID ";
    $data = querySql($sql);
}

// 品番
if ($target == "ItemCd") {
    $sql = "SELECT DISTINCT ITEM_CD FROM m_mold ";
    $sql.= "WHERE 0 = 0 ";
    $sql.= "ORDER BY ITEM_CD ";
    $data = querySql($sql);
}

// 型番
if ($target == "MoldItemCd") {
    $ItemCd = htmlspecialchars($_POST["ITEM_CD"]);
    if ($ItemCd != "") {
        $sql = "SELECT DISTINCT MOLD_ITEM_CD FROM m_mold ";
        $sql.= "WHERE 0 = 0 ";
        $sql.= "AND ITEM_CD = '$ItemCd' ";
        $sql.= "ORDER BY MOLD_ITEM_CD ";
        $data = querySql($sql);
    }
}

// ピンの紐付け
if ($target == "PinLinkList") {
    $ItemCd = htmlspecialchars($_POST["ITEM_CD"]);
    $MoldItemCd = htmlspecialchars($_POST["MOLD_ITEM_CD"]);
    if ($ItemCd != "" && $MoldItemCd != "") {
        $sql = "SELECT PIN_POSITION_NO,p.PIN_ID,p.PIN_NAME FROM m_pin_link AS l ";
        $sql.= "JOIN m_pin AS p ON l.PIN_ID = p.PIN_ID ";
        $sql.= "WHERE 0 = 0 ";
        $sql.= "AND ITEM_CD = '$ItemCd' ";
        $sql.= "AND MOLD_ITEM_CD = '$MoldItemCd' ";
        $sql.= "ORDER BY PIN_POSITION_NO";
        $data = querySql($sql);
    }
}

if ($target == "PinItemList") {
    $PinName = htmlspecialchars($_POST["PIN_NAME"]);
    $ItemCd = htmlspecialchars($_POST["ITEM_CD"]);
    $MoldItemCd = htmlspecialchars($_POST["MOLD_ITEM_CD"]);

    $sql = "SELECT ";
    $sql.= "p.PIN_ID, ";
    $sql.= "p.PIN_NAME, ";
    $sql.= "COUNT(*) AS CNT ";
    $sql.= "FROM m_pin AS p ";
    $sql.= "LEFT OUTER JOIN m_pin_link AS l ON p.PIN_ID = l.PIN_ID ";
    $sql.= "WHERE 0 = 0 ";
    if ($PinName != "") $sql.= "AND PIN_NAME LIKE '%$PinName%' ";
    if ($ItemCd != "") $sql.= "AND ITEM_CD LIKE '%$ItemCd%' ";
    if ($MoldItemCd != "") $sql.= "AND MOLD_ITEM_CD LIKE '%$MoldItemCd%' ";
    $sql.= "GROUP BY p.PIN_NAME, p.PIN_ID ";
    $sql.= "ORDER BY p.PIN_NAME, p.PIN_ID ";
    $pinList = querySql($sql);

    $sql = "SELECT ";
    $sql.= "p.PIN_ID, ";
    $sql.= "p.PIN_NAME, ";
    $sql.= "p.STOCK_QTY, ";
    $sql.= "p.STD_QTY, ";
    $sql.= "p.ODR_QTY, ";
    $sql.= "p.SLOPE_PIN_FLG, ";
    $sql.= "l.ITEM_CD, ";
    $sql.= "l.MOLD_ITEM_CD, ";
    $sql.= "l.PIN_POSITION_NO ";
    $sql.= "FROM m_pin AS p ";
    $sql.= "LEFT OUTER JOIN m_pin_link AS l ON p.PIN_ID = l.PIN_ID ";
    $sql.= "WHERE 0 = 0 ";
    if ($PinName != "") $sql.= "AND PIN_NAME LIKE '%$PinName%' ";
    if ($ItemCd != "") $sql.= "AND ITEM_CD LIKE '%$ItemCd%' ";
    if ($MoldItemCd != "") $sql.= "AND MOLD_ITEM_CD LIKE '%$MoldItemCd%' ";
    $sql.= "ORDER BY p.PIN_NAME, p.PIN_ID, l.ITEM_CD, l.MOLD_ITEM_CD, l.PIN_POSITION_NO ";
    $itemList = querySql($sql);

    foreach ($pinList as $pin) {
        $idx = 0;
        foreach ($itemList as $row) {
            if ($pin["PIN_ID"] == $row["PIN_ID"]) {
                $data[] = [
                    "PIN_INDEX" => $idx,
                    "PIN_CNT" => $pin["CNT"],
                    "PIN_ID" => $row["PIN_ID"],
                    "PIN_NAME" => $row["PIN_NAME"],
                    "STOCK_QTY" => $row["STOCK_QTY"],
                    "STD_QTY" => $row["STD_QTY"],
                    "ODR_QTY" => $row["ODR_QTY"],
                    "SLOPE_PIN_FLG" => $row["SLOPE_PIN_FLG"],
                    "ITEM_CD" => $row["ITEM_CD"],
                    "MOLD_ITEM_CD" => $row["MOLD_ITEM_CD"],
                    "PIN_POSITION_NO" => $row["PIN_POSITION_NO"],
                ];
                $idx++;
            }
        }
    }
}

$dbh = null;
echo json_encode($data);
?>