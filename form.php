<div class="modal fade" id="usermodal" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adding or Updating Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addform" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- username -->
                    <div class="form-group">
                        <label>Name:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-dark"><i class="fa fa-user-alt text-light"></i></span>
                            </div>
                            <input type="text" class="form-control" name="username" id="username"
                                placeholder="Enter your username" autocomplete="off" required="required">
                        </div>
                    </div>
                    <!-- email -->
                    <div class="form-group">
                        <label>Email:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-dark"><i class="fas fa-envelope-open text-light"></i></span>
                            </div>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Enter your Email" autocomplete="off" required="required">
                        </div>
                    </div>
                    <!-- mobile -->
                    <div class="form-group">
                        <label>Mobile:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-dark"><i class="fas fa-phone text-light"></i></span>
                            </div>
                            <input type="text" class="form-control" name="mobile" id="mobile"
                                placeholder="Enter your mobile" autocomplete="off" required="required"
                                maxlength="10" minlength="10">
                        </div>
                    </div>
                    <!-- photo -->
                    <div class="form-group">
                        <label>Photo:</label>
                        <div class="input-group">
                            <label class="custom-file-label" for="userphoto">Choose File</label>
                            <input type="file" class="custom-file-input" name="photo" id="userphoto">
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <!-- 2 input fileds first for adding and next for updationg, deleting or viewing profile -->
                    <input type="hidden" name="action" value="adduser">
                    <input type="hidden" name="userId" id="userId" value="">
                </div>
            </form>
        </div>
    </div>
</div>