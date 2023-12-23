<?php
require_once("Mail.php");
require_once("Mail/mime.php");

mb_language("japanese");
mb_internal_encoding("UTF-8");

$params = array(
    "host" => "ssl://smtp.gmail.com",
    "port" => "465",
    "auth" => true,
    "username" => "",
    "password" => "",
    "debug" => false,
    "protocol" => "SMTP_AUTH",
);

$mailObject = Mail::factory("smtp", $params);
$recipients = "";

$body = "添付ファイルのテストです。\r\n\r\n文字化けしないか？";
$body = mb_convert_encoding($body,"ISO-2022-JP","auto");

$mimeObject = new Mail_Mime("\n");
$mimeObject->setTxtBody($body);
$mimeObject->addAttachment("テスト.csv","text/csv",mb_encode_mimeheader("testテスト.csv","UTF-8"),true,"base64");

$bodyParam = array(
    "head_charset" => "ISO-2022-JP",
    "text_charset" => "ISO-2022-JP"
);

$body = $mimeObject->get($bodyParam);

$addHeaders = array(
    "To" => "",
    "From" => "",
    "Subject" => mb_encode_mimeheader(mb_convert_encoding("件名","JIS","UTF-8")),
);

$headers = $mimeObject->headers($addHeaders);

$result = $mailObject->send($recipients, $headers, $body);

print_r($result);

?>