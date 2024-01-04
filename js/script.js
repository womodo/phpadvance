// function for patination
function pagination(totalpages, currentpages) {
    var pagelist = "";
    if (totalpages > 1) {
        currentpages = parseInt(currentpages);
        pagelist += `<ul class="pagination justify-content-center">`;
        const prevClass = currentpages == 1 ? "disabled" : "";
        pagelist += `<li class="page-item ${prevClass}"><a class="page-link" href="#" data-page="${currentpages-1}">Previous</a></li>`;
        for (let p = 1; p <= totalpages; p++) {
            const activeClass = currentpages == p ? "active" : "";
            pagelist += `<li class="page-item ${activeClass}"><a class="page-link" href="#" data-page="${p}">${p}</a></li>`;
        }
        const nextClass = currentpages == totalpages ? "disabled" : "";
        pagelist += `<li class="page-item ${nextClass}"><a class="page-link" href="#" data-page="${currentpages+1}">Next</a></li>`;
        pagelist += `</ul>`;
    }
    $("#pagination").html(pagelist);
}


// function to get users from database
function getUserRow(user) {
    var userRow = "";
    if (user) {
        userRow = `<tr>
                        <th scope="row"><img src=${user.photo != null ? `"uploads/${user.photo}"` : '"images/no_image.png"'}></th>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.mobile}</td>
                        <td>
                            <a href="#" class="mr-3 profile" data-target="#userViewModal" data-toggle="modal" title="View Profile" data-id=${user.id}><i class="fas fa-eye text-success"></i></a>
                            <a href="#" class="mr-3 edituser" data-target="#usermodal" data-toggle="modal" title="Edit" data-id=${user.id}><i class="fas fa-edit text-info"></i></a>
                            <a href="#" class="mr-3 deleteuser" title="Delete" data-id=${user.id}><i class="fas fa-trash-alt text-danger"></i></a>
                        </td>
                    </tr>`;
    }
    return userRow;
}


// get users function
function getUsers() {
    var pageno = $("#currentpage").val();
    $.ajax({
        url: "ajax.php",
        type: "GET",
        dataType: "json",
        data: {page:pageno, action:"getAllUsers"},
        beforeSend: function() {
            console.log("Wait...Data is loading");
        },
        success: function(rows) {
            // console.log(rows);
            if (rows.users) {
                var userslist = "";
                $.each(rows.users, function(index, user) {
                    userslist += getUserRow(user);
                });
                $("#usertable tbody").html(userslist);
                let totaluser = rows.count;
                let totalpages = Math.ceil(parseInt(totaluser)/4);
                const currentpages = $("#currentpage").val();
                pagination(totalpages, currentpages);
            }
        },
        error: function(request, error) {
            console.log(arguments);
            console.log("Error: " + error);
        }
    });
}

// loading document
$(document).ready(function () {

    $("#addform").on("submit", (function (event) {
        event.preventDefault();
        var msg = $("#userId").val().length > 0
         ? "User has been updated successfully"
         : "New user has been added successfully";
        $.ajax({
            url: "ajax.php",
            type: "POST",
            dataType: "json",
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function() {
                console.log("Waiting");
            },
            success: function(response) {
                console.log(response);
                if (response) {
                    $("#usermodal").modal("hide");
                    $("#addform")[0].reset();
                    $('.displaymessage').html(msg).fadeIn().delay(2500).fadeOut();
                    getUsers();
                }
            },
            error: function(request, error) {
                console.log(arguments);
                console.log("Error: " + error);
            }
        });
    }));

    // onclick event for pagination
    $(document).on("click", "ul.pagination li a", function(event) {
        event.preventDefault();

        const pagenum = $(this).data("page");
        $("#currentpage").val(pagenum);
        getUsers();
        $(this).parent().siblings().removeClass("active");
        $(this).parent().addClass("active");
    });

    // onclick event for editing
    $(document).on("click", "a.edituser", function(event) {
        var uid = $(this).data("id");
        // alert(uid);
        $.ajax({
            url: "ajax.php",
            type: "GET",
            dataType: "json",
            data: {id:uid, action:"editUserData"},
            beforeSend: function() {
                console.log("Waiting");
            },
            success: function(rows) {
                // console.log(rows);
                if (rows) {
                    $("#username").val(rows.name);
                    $("#email").val(rows.email);
                    $("#mobile").val(rows.mobile);
                    $("#userId").val(rows.id);
                }
            },
            error: function() {
                console.log("something went wrong");
            }
        });
    });

    // onclick for adding user btn
    $("#adduserbtn").on("click", function() {
        $("#addform")[0].reset();
        $("#userId").val("");
    });

    // onclick event for deleting
    $(document).on("click", "a.deleteuser", function(event) {
        event.preventDefault();
        var uid = $(this).data("id");
        if (confirm("Are you sure you want to delete this user?")) {
            $.ajax({
                url: "ajax.php",
                type: "GET",
                dataType: "json",
                data: {id:uid, action:"deleteUser"},
                beforeSend: function() {
                    console.log("Waiting");
                },
                success: function(res) {
                    if (res.delete == 1) {
                        $(".displaymessage").html("Use has been deleted successfully!").fadeIn().delay(2500).fadeOut();
                        getUsers();
                        console.log("done");
                    }
                },
                error: function() {
                    console.log("something went wrong");
                }
            });
        }
    });

    // profile view
    $(document).on("click", "a.profile", function() {
        var uid = $(this).data("id");
        $.ajax({
            url: "ajax.php",
            type: "GET",
            dataType: "json",
            data: {id:uid, action:"editUserData"},
            beforeSend: function() {
                console.log("Waiting");
            },
            success: function(user) {
                if (user) {
                    const profile = `<div class="row">
                                        <div class="col-sm-6 col-md-4">
                                            <img src=${user.photo != null ? `"uploads/${user.photo}"` : '"images/no_image.png"'} alt="Image" class="rounded">
                                        </div>
                                        <div class="col-sm-6 col-md-8">
                                            <h4 class="text-primary">${user.name}</h4>
                                            <p>
                                                <i class="fas fa-envelope-open"></i> ${user.email}
                                                <br>
                                                <i class="fas fa-phone"></i> ${user.mobile}
                                            </p>
                                        </div>
                                    </div>`;
                    $("#profile").html(profile);
                }
            },
            error: function() {
                console.log("something went wrong");
            }
        });
    });

    // search data
    $(document).on("keyup", "#searchinput", function() {
        const searchText = $(this).val();
        if (searchText.length > 1) {
            $.ajax({
                url: "ajax.php",
                type: "GET",
                dataType: "json",
                data: {searchQuery:searchText, action:"searchUser"},
                beforeSend: function() {
                    console.log("Wait...Data is loading");
                },
                success: function(users) {
                    if (users) {
                        var userslist = "";
                        $.each(users, function(index, user) {
                            userslist += getUserRow(user);
                        });
                        $("#usertable tbody").html(userslist);
                        $("#pagination").hide();
                    }
                },
                error: function() {
                    console.log("something went wrong");
                }
            });
        } else {
            getUsers();
            $("#pagination").show();
        }
    });

    // calling function when document is loaded
    getUsers();
});
