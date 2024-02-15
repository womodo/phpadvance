<?php

// アップロード先のディレクトリ
$uploadDir = 'images/';

// ファイルが正しく受信されたか確認
if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    // アップロードされたファイルの一時的な保存先
    $tmpName = $_FILES['file']['tmp_name'];
    // アップロードされたファイルの名前
    $fileName = basename($_FILES['file']['name']);
    // ファイルの最終的な保存先のパス
    $uploadPath = $uploadDir . $fileName;

    // ファイルを指定したディレクトリに移動
    if (move_uploaded_file($tmpName, $uploadPath)) {
        // アップロードが成功した場合の処理
        echo 'ファイルがアップロードされました。';
    } else {
        // アップロードが失敗した場合の処理
        echo 'ファイルのアップロード中にエラーが発生しました。';
    }
} else {
    // ファイルが適切にアップロードされていない場合の処理
    echo 'ファイルのアップロードに失敗しました。';
}
?>