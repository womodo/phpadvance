<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>ファイルアップロード</title>
    <style>
        .thumbnail {
            position: relative;
            display: inline-block;
        }
        #zoom-image {
            display: none;
            position: absolute;
            top: 0;
            left: 100%;
            width: 400px;
            height: auto;
        }

        #popup-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            /* padding: 20px; */
            z-index: 9999;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            transition: top 0.3s ease, left 0.3s ease; /* 移動を滑らかにする */
        }

        #popup-image {
            /* max-width: 90%;
            max-height: 90%; */
            width: auto;
            height: 600px;
            cursor: move;
        }

        #close-popup {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body style="background-color:aliceblue;">
    <form method="post" name="frm1">
        <div class="container-fluid mt-3 mb-3">
            <input type="file" name="fileElem" id="fileElem" accept="image/*" style="display:none;">
            <input type="button" id="fileSelect" value="画像を選択">
            <div class="thumbnail">
                <a href="#">
                    <img src="" alt="" id="thumbnail-image" height="45px">
                </a>
                <img src="" alt="" id="zoom-image">
            </div>
        </div>
    </form>
    
    <div id="popup-container">
        <img id="popup-image" src="" alt="">
        <span id="close-popup">✖</span>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="js/jquery.blockUI.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.min.js"></script>
    <script>
        $(function(){
            $('#thumbnail-image')
            .on('mouseenter', function() {
                $('#zoom-image').show();
            })
            .on('mouseleave', function() {
                $('#zoom-image').hide();
            })
            .on('mousemove', function(e) {
                var $zoomedImage = $(this).find('.zoomed-image');
                var offsetX = e.pageX - $(this).offset().left;
                var offsetY = e.pageY - $(this).offset().top;
                var imageWidth = $zoomedImage.width();
                var imageHeight = $zoomedImage.height();
                var newX = offsetX + 20; // 画像の右側に少し余白を持たせる
                var newY = offsetY - (imageHeight / 2); // マウスの上部に画像の中央を配置
                $zoomedImage.css({ top: newY, left: newX });
            });

            $('#thumbnail-image').on('click', function(e) {
                e.preventDefault();
                var imageUrl = $('#thumbnail-image').attr('src');
                $('#popup-image').attr('src', imageUrl);
                $('#popup-container').show();
            });

            $('#close-popup').click(function() {
                $('#popup-container').hide();
            });

            var drag = false;
            var mouseX, mouseY;
            var offsetX, offsetY;

            $('#popup-container').mousedown(function(e) {
                drag = true;
                mouseX = e.clientX;
                mouseY = e.clientY;
                offsetX = $('#popup-container').offset().left - mouseX;
                offsetY = $('#popup-container').offset().top - mouseY;
            });

            $(document).mouseup(function() {
                drag = false;
            });

            $(document).mousemove(function(e) {
                if (drag) {
                    var newLeft = e.clientX + offsetX;
                    var newTop = e.clientY + offsetY;

                    $('#popup-container').css({
                        'left': newLeft,
                        'top': newTop
                    });
                }
            });

            // ESCキーでポップアップを閉じる
            $(document).keydown(function(e) {
                if (e.keyCode == 27) { // ESCキーのキーコード
                    $('#popup-container').hide();
                }
            });
            // ポップアップ外をクリックして閉じる
            $(document).mouseup(function(e) {
                var popup = $('#popup-container');
                if (!popup.is(e.target) && popup.has(e.target).length === 0) {
                    $('#popup-container').hide();
                }
            });

            $('#fileSelect').click(function() {
                $('#fileElem').click();
            });
            $('#fileElem').on('change', function(event) {
                handleImageUpload(event);
            });
        });

        async function handleImageUpload(event) {
            const file = event.target.files[0];
            const file_type = file.name.split('.').pop();
            console.log('originalFile instanceof Blob', file instanceof Blob);
            console.log(`originalFile size ${file.size / 1024 / 1024} MB`);

            var fileName = Date.now().toString() + '.' + file_type;

            const options = {
                maxSizeMB: 1,
                maxWidthOrHeight: 1024,
                useWebWorker: true,
            }
            imageCompression(file, options)
                .then(function (compressedFile) {
                    // 圧縮された画像ファイルをアップロード
                    var formData = new FormData();
                    formData.append('file', compressedFile, fileName);
                    
                    console.log('compressedFile instanceof Blob', compressedFile instanceof Blob);
                    console.log(`compressedFile size ${compressedFile.size / 1024 / 1024} MB`);

                    $.ajax({
                        url: 'upload.php',
                        type: 'POST',
                        data: formData,
                        processData: false, // dataをクエリ文字列に変換しない
                        contentType: false, // リクエストのContent-Typeを指定しない
                        success: function(response) {
                            console.log(response);
                            $('#thumbnail-image').attr('src','images/' + fileName);
                            $('#zoom-image').attr('src','images/' + fileName);
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    </script>
</body>
</html>