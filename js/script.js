$(document).ready(function () {
    $("#addform").on("submit", (function (e) {
        e.preventDefault();
        $.ajax({
            url: "ajax.php",
            type: "POST",
            dataType: "json",
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function() {
                console.log("Wait...Data is loading");
            },
            success: function(response) {
                console.log(response);
                if (response) {
                    $("#usermodal").modal("hide");
                    $("#addform")[0].reset();
                }
            },
            error: function(request, error) {
                console.log(arguments);
                console.log("Error: " + error);
            }
        });
    }));
});
