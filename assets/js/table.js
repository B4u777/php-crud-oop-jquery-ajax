$(document).ready(function() {
    $('#userTable').DataTable({
        ajax: {
            url: "../crud_oop/api/user.php?action=getUsers",
            type: 'GET',
            dataSrc: 'data',
            error: function (xhr, error, thrown) {
                console.log("AJAX Error:", error);
                console.log("Response:", xhr.responseText);
            }
        },
        columns: [
            {data:'user_image',
        render: function(data){
            if (!data) {
                return 'No Image';
            }
            return '<img src="../crud_oop/uploads/users/' + data + '" width="50" height="50">';
        }},
            { data: 'user_name' },
            { data: 'user_email' },
            { data: 'user_gender' },
            { data: 'user_banks' },
            {
                data: null,
                orderable: false,
                searchable: false,

                render: function(data, type, row) {

                    return `
                        <button 
                            class="btn btn-sm btn-primary addBtn"
                            id="addUserBtn">
                            ADD
                        </button>
                        <button 
                            class="btn btn-sm btn-primary editBtn"
                            data-id="${row.user_id}">
                            Edit
                        </button>

                        <button 
                            class="btn btn-sm btn-danger deleteBtn"
                            data-id="${row.user_id}">
                            Delete
                        </button>
                        
                    `;
                }
            }
        ]
    });

    // ====================================
    // Delete Ajax Code
    // ===================================

    $(document).on('click', '.deleteBtn', function() {

        let user_id = $(this).data('id');
        
    
        if (confirm('Are you sure you want to delete this user?')) {
    
            $.ajax({
                url: '../crud_oop/api/user.php?action=deleteUser',
                type: 'POST',
    
                data: {
                    user_id: user_id
                },
    
                success: function(response) {
    
                    console.log(response);
    
                    if (response.status) {
    
                        alert('User deleted successfully');
    
                        // DataTable reload
                        $('#userTable').DataTable()
                            .ajax.reload(null, false);
    
                    } else {
    
                        alert(response.message);
                    }
                },
    
                error: function(xhr) {
                    console.log('Error:', xhr.responseText);
                    alert('Something went wrong!');
                }
            });
    
        }
    
    });

    // ====================================
    // Edit modal show Code
    // ===================================

    $(document).on('click', '.editBtn', function() {

        let table = $('#userTable').DataTable();
    
        // Current row ka data
        let row = table.row($(this).closest('tr')).data();
    
        console.log(row);
    
        // Form mein values set
        $('#edit_user_id').val(row.user_id);
        $('#edit_user_name').val(row.user_name);
        $('#edit_user_email').val(row.user_email);
        $('#edit_user_gender').val(row.user_gender);
        if (row.user_image) {
            $('#previewImage')
                .attr('src', '../crud_oop/uploads/users/' + row.user_image)
                .show();
        } else {
            $('#previewImage')
                .attr('src', '')
                .hide();
        }

       // Sabhi bank checkbox uncheck
       $('.bank-checkbox').prop('checked', false);
    
       // Database se banks
       if (row.user_banks) {
    
           let banks = row.user_banks.split(',');
    
           banks.forEach(function(bank) {
    
               bank = bank.trim();
    
               $('.bank-checkbox[value="' + bank + '"]')
                   .prop('checked', true);
           });
       }
    
    
        // Bootstrap 4 modal
        $('#editModal').modal('show');
    
    });

    // ====================================
    // Edit form data update Ajax Code
    // ===================================

    $('#editForm').on('submit', function(e) {

        e.preventDefault();
        let formData = new FormData(this);
        let file = formData.get('imageUpload');

        console.log(file);
    
        $.ajax({
            url: '../crud_oop/api/user.php?action=updateUser',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
    
            success: function(response) {
    
                if (response.status) {
    
                    alert('User Updated successfully');
    
                    // Bootstrap 4 modal close
                    $('#editModal').modal('hide');
    
                    $('#editModal').one('hidden.bs.modal', function() {
    
                        // Remove stuck backdrop
                        $('.modal-backdrop').remove();
    
                        // Remove Bootstrap modal class
                        $('body').removeClass('modal-open');
    
                        // Reset body styles
                        $('body').css({
                            'padding-right': '',
                            'overflow': ''
                        });
                    });
    
                    // DataTable refresh
                   $('#userTable').DataTable().ajax.reload(null, false);
    
                } else {
    
                    alert(response.message);
                }
            },
    
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    
    });

    $(document).on('click', '#addUserBtn', function(e) {

        e.preventDefault();
        $('#addModal').modal('show');
    });
    
        $("#signup").validate({

            // 1. Define validation rules
            rules: {
                name: {
                    required: true,
                    minlength: 4
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 5
                },
                imageUpload:{
                    required:true,
                    extension: "jpg|jpeg|png|gif"
        
                },
                inlineRadioOptions:{
                    required:true
                },
                "bank[]": {
                    required: true,
                    minlength: 1
                },
            },
        
            // 2. Define custom error messages
            messages: {
                name: {
                    required: "Please enter your name.",
                    minlength: "Your name must be at least 3 characters long."
                },
                email: {
                    required: "Please enter your email address.",
                    email: "Please enter a valid email address."
                },
                password: {
                    required: "Please enter password.",
                    minlength: "Your password must be 5 characters long."
                },
                imageUpload: {
                    required: "Please select an image to upload.",
                    extension: "Only JPG, JPEG, PNG, or GIF formats are allowed."
            
                }, 
                inlineRadioOptions:"you must select to gender",
                "bank[]": {
                    required: "Please select at least one Bank."
                },
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");
                
                if (element.attr("type") == "radio") {
                    error.insertAfter("#gender");
                } else if(element.attr("name") == "bank[]") {
                    error.appendTo("#banks");
                }else{
                    error.insertAfter(element);
                }
},
            submitHandler: function (form) {
                
                var Data = new FormData(form);
                console.log(Data);
                $.ajax({
                    type: 'POST',
                    url: '../crud_oop/api/user.php?action=addUser',
                    data: Data,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(response) {

                        console.log("JSON Response:", response);
                    
                        if (response.status === 'success') {
                    
                            $("#form-response")
                                .html('<p class="success-msg">' + response.message + '</p>');
                    
                            // Reset form
                            form.reset();
                    
                            // Reset jQuery Validate state
                            $(form).validate().resetForm();
                    
                            // Hide modal after 1.5 seconds
                            setTimeout(function() {
                                $("#addModal").modal("hide");
                    
                                // Clear success message
                                $("#form-response").empty();
                    
                            }, 1500);
                            $("#addModal").on("hidden.bs.modal", function () {

                                var form = $("#signup");
                            
                                form[0].reset();
                            
                                form.validate().resetForm();
                            
                                $("#form-response").empty();
                            
                                // Remove validation classes
                                form.find(".error").removeClass("error");
                                form.find(".valid").removeClass("valid");
                            
                            });
                    
                            // Reload DataTable
                            var table = $('#userTable').DataTable();
                            table.ajax.reload(null, false);
                    
                        } else {
                    
                            $("#form-response")
                                .html('<p class="error">' + response.message + '</p>');
                        }
                    },
                    
                    error: function() {
                        $("#form-response").html('<p class="error">Something went wrong. Please try again.</p>');
                        
                    }
                });
                
            }
        });
        
        
        
        
        
    });



    

 