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
                        <th scope="row"><img src="uploads/${user.photo}"></th>
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
        data: {page:pageno, action:'getAllUsers'},
        beforeSend: function() {
            console.log("Wait...Data is loading");
        },
        success: function(rows) {
            console.log(rows);
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
    });

    // calling getusers() function
    getUsers();
});
