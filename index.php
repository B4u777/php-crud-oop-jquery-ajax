<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>DATABASE DATA </title>
</head>

<body>

    <div class="container">
        <table id="userTable" class="display table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Bank</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Bank</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form id="editForm" enctype="multipart/form-data">

                        <input type="hidden" id="edit_user_id" name="user_id">
                        <div class="form-row">


                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <input type="text" class="form-control" id="edit_user_name" name="user_name">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" class="form-control" id="edit_user_email" name="user_email">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="control-label" for="imageUpiload">Upload
                                    Image</label>
                                <div class="mb-2">
                                    <input type="file" class="form-control" name="imageUpload" id="imageUpload"
                                        placeholder="image" />
                                </div>
                                <div class="mb-2">
                                    <img id="previewImage" src="" alt="User image" class="img-thumbnail"
                                        style="width:120px;height:120px;object-fit:cover;">
                                </div>

                            </div>
                            <div class="form-group col-md-6">
                                <label><strong>Banks</strong></label>

                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input bank-checkbox" name="user_banks[]"
                                        value="Bank of Baroda" id="bank1">

                                    <label class="form-check-label" for="bank1">
                                        Bank of Baroda
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input bank-checkbox" name="user_banks[]"
                                        value="Punjab National Bank" id="bank2">

                                    <label class="form-check-label" for="bank2">
                                        Punjab National Bank
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input bank-checkbox" name="user_banks[]"
                                        value="UCO bank" id="bank3">

                                    <label class="form-check-label" for="bank3">
                                        UCO bank
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input bank-checkbox" name="user_banks[]"
                                        value="Canara Bank" id="bank4">

                                    <label class="form-check-label" for="bank4">
                                        Canara Bank
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input bank-checkbox" name="user_banks[]"
                                        value="SBI" id="bank5">

                                    <label class="form-check-label" for="bank5">
                                        SBI
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Gender</label>

                                <select class="form-control" id="edit_user_gender" name="user_gender">

                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-center align-items-center">

                            <button type="submit" class="btn btn-success">
                                Update
                            </button>
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="addModalBody">

                    <div id="form-response"></div>
                    

                    <form id="signup" class="form-horizontal" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label class="control-label" for="name">Name</label>
                                <div class="mb-2">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                                        autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label" for="email">Email</label>
                                <div class="mb-2">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                                        autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="control-label" for="password">Password</label>
                                <div class="mb-2">
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Password" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label" for="imageUpiload">Upload
                                    Image</label>
                                <div class="mb-2">
                                    <input type="file" class="form-control" name="imageUpload" id="imageUpload"
                                        placeholder="image" />
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="control-label" for="gender">Gender</label>
                                <div class="mb-2" id="gender">
                                    <div class="form-check-inline">
                                        <input class="form-check-input form-control" type="radio"
                                            name="inlineRadioOptions" id="inlineRadio1" value="Male">
                                        <label class="form-check-label" for="inlineRadio1">Male</label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input form-control" type="radio"
                                            name="inlineRadioOptions" id="inlineRadio2" value="Female">
                                        <label class="form-check-label" for="inlineRadio2">Female</label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input form-control" type="radio"
                                            name="inlineRadioOptions" id="inlineRadio3" value="Other">
                                        <label class="form-check-label" for="inlineRadio3">Other</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label" for="bank">Bank Applied
                                    for</label>
                                <div class="mb-2" id="banks">
                                    <div class="custom-control custom-checkbox">
                                        <input class="form-check-input" type="checkbox" name="bank[]"
                                            value="Bank of Baroda" id="bob">
                                        <label class="form-check-label" for="bob">
                                            Bank of Baroda
                                        </label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="form-check-input" type="checkbox" name="bank[]"
                                            value="Punjab National Bank" id="pnb">
                                        <label class="form-check-label" for="pnb">
                                            Punjab National Bank
                                        </label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="form-check-input" type="checkbox" name="bank[]" value="UCO bank"
                                            id="uco">
                                        <label class="form-check-label" for="uco">
                                            UCO bank
                                        </label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="form-check-input" type="checkbox" name="bank[]"
                                            value="Canara Bank" id="canara">
                                        <label class="form-check-label" for="canara">
                                            Canara Bank
                                        </label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="form-check-input" type="checkbox" name="bank[]" value="SBI"
                                            id="sbi">
                                        <label class="form-check-label" for="sbi">
                                            SBI
                                        </label>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="form-group d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn btn-primary">Sign
                                up</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>




    <script src="assets/js/jquery-3.7.1.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/dataTables.min.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>
    <script src="assets/js/additional-methods.min.js"></script>
    <script src="assets/js/table.js"></script>


</body>
</html>