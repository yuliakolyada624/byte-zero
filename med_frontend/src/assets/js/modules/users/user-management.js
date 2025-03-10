import { jsPagination } from "../js-pagination";
import { updateTotalResults, getCSRFToken, getGlobalEnvironment } from "../../global-functions";
import ComponentDropdownSelect2 from "./../../components/form/dropdown-select2"
import {Toast} from "../../components/toast";
import ComponentFormWrapper from "../../components/form/form";
import { EditUserOffcanvas } from "./sidebars/edit-user__offcanvas";

export class UserManagementIntegration {
    constructor() {
        // Listen for filter changes on the select elements
        $("#collapseFilter select").on('change', () => {
            console.log("UserManagementIntegration filter changed");
            this.applyFilter();
        });

        $("#usersFilterStatus").on('change', () => {
            console.log("UserManagementIntegration filter changed");
            this.applyFilter();
        });

        $("#usersSearchSubmit").on('click', () => {
            this.applyFilter();
        })

        const classWrapper = this;

        $(".users-searches").find(".component__autocomplete-input").on('change', function () {
            classWrapper.updateStyle($(this));
        })

        $(".js__users-filters__reset").on('click', function () {
            resetAllFilters($(this));
        });

        $(".js__users-searches-user").on('input', function (e) {
            e.preventDefault()
            const currentElem = $(this);
            const currentValue = currentElem.val().toLowerCase();
            const wrapperElem = currentElem.closest(".users-searches");
            const listElem = wrapperElem.find(".js__users-searches-user-list");
            const userIdHiddenInput = wrapperElem.find('#usersSearchesSearchUsersByNameEmail');

            const url = listElem.data("url");

            listElem.addClass('_hidden');
            userIdHiddenInput.val('');

            if (currentValue && currentValue.length > 2) {
                if (getGlobalEnvironment() != '') {
                    $.ajax({
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': getCSRFToken()
                        },
                        method: 'POST',
                        data: { search: currentValue },
                        success: function (response) {
                            listElem.html('');
                            listElem.html(response.searchResult);
                            listElem.removeClass("_hidden");
                            $('.js__users-searches-user-item').on('click', function (e) {
                                e.preventDefault();
                                const userNames = $(this).data('name');
                                const userId = $(this).data('id');
                                currentElem.val(userNames);
                                userIdHiddenInput.val(userId);
                                listElem.addClass("_hidden");
                            })
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                } else {
                    listElem.removeClass('_hidden');
                }
            }
        });

        $(document).on('click', function (event) {
            if (!$(event.target).closest('.users-searches__user-search').length && !$(event.target).closest('.js__users-searches-user-list').length) {
                $('#usersSearchesSearchUsersByNameEmail').val('');
                $(".js__users-searches-user-list").addClass('_hidden');
            }
        });

        // Handle Suspend Selection
        $('#suspend-users').on('click', function (e) {
            e.preventDefault();
            let selectedUsers = getSelectedUsers();

            if (selectedUsers.length > 0) {
                // Send AJAX request to suspend users
                $.ajax({
                    url: SITEURL+'user-management/deactivate-users', // Backend route for suspension
                    type: 'POST',
                    data: {
                        ids: selectedUsers,
                        action: 'suspend'
                    },
                    success: function (response) {
                        new Toast({ position: ".header .justify-content-end", text: 'Selected users suspended successfully', type: 'successful', class: 'page-toast'  })
                        loadUsersPage(1);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error suspending users:', error);
                    }
                });
            } else {
                new Toast({ position: ".header .justify-content-end", text: 'Please select at least one user.', type: 'error', class: 'page-toast' })
            }
        });

        // Handle Reactivate Selection
        $('#reactivate-users').on('click', function (e) {
            e.preventDefault();
            let selectedUsers = getSelectedUsers();

            if (selectedUsers.length > 0) {
                // Send AJAX request to reactivate users
                $.ajax({
                    url: SITEURL+'user-management/reactivate-users', // Backend route for reactivation
                    type: 'POST',
                    data: {
                        ids: selectedUsers,
                        action: 'reactivate'
                    },
                    success: function (response) {
                        new Toast({ position: ".header .justify-content-end", text: 'Selected users reactivated successfully', type: 'successful', class: 'page-toast' })
                        loadUsersPage(1);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error reactivating users:', error);
                    }
                });
            } else {
                new Toast({ position: ".header .justify-content-end", text: 'Please select at least one user.', type: 'error', class: 'page-toast' })
            }
        });


        // CSV download functionality
        const userManagementDownloadBtn = document.querySelector('.download-btn');
        if (userManagementDownloadBtn) {
            userManagementDownloadBtn.addEventListener('click', function () {
                const filters = new URLSearchParams({
                    status: document.querySelector('#usersFilterStatus').value,
                    role: document.querySelector('#usersFilterRole').value,
                    job_title: document.querySelector('#usersFilterJob').value,
                    plaintiff_name: document.querySelector('#usersFilterPlantiffName').value,
                    user_name_email: document.querySelector('#usersSearchesSearchUsersByNameEmail').value
                });
                // Construct the URL with filters
                window.location.href = SITEURL + '/user-management/download_csv?' + filters.toString();
            });
        }

        $(document).on('click', '.delete', function () {
            $(this).closest('.card').remove();
        });

        /* Invite  */
        
        //  TODO - refactor to new  toastr Function to display success toast
        function showSuccessToast(message) {
            $('#successToastMessage').text(message); // Set the dynamic message
            let successToast = new bootstrap.Toast(document.getElementById('successToast'));
            successToast.show(); // Show the toast
        }

        // Function to display error toast
        function showErrorToast(message) {
            $('#errorToastMessage').text(message); // Set the dynamic message
            let errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
            errorToast.show(); // Show the toast
        }

        function getCSRFToken(){
            let csrfTokenInput = document.querySelector('input[name="csrf_token"]');
            let csrfTokenMeta = document.querySelector('meta[name="csrf_token"]');
            return csrfTokenInput ? csrfTokenInput.value : csrfTokenMeta ? csrfTokenMeta.content : '';
        }

        
        // Handle showing delete modal with correct job title
        $(document).on('click', '.delete-job-title', function () {
            let jobTitle = $(this).data('job-title');
            let id = $(this).data('id'); // Assuming the job title ID is passed via `data-id`
            $('#jobTitleName').text(jobTitle); // Display job title in modal
            $('#jobTitleName').data('id', id); // Store the ID in the modal for reference
            $('#deleteJobTitle').modal('show'); // Show the delete confirmation modal
        });

        // Handle deletion confirmation
        $('#confirmDelete').click(function () {
            let id = $('#jobTitleName').data('id'); // Get the job title ID from the modal
            let jobTitleName = $('#jobTitleName').text();

            // Make AJAX request to delete the job title
            $.ajax({
                url: SITEURL+`job-title/delete/${id}`,  // Your backend URL for deleting job titles
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": getCSRFToken(),
                },
                dataType: "json",
                success: function (response) {
                    // If the deletion was successful, remove the job title from the list
                    $('#job-list-item-' + id ).remove();

                    // Also remove the job title from the select dropdown
                    $('#jobTitleSelect_1 option:contains("' + jobTitleName + '")').remove();

                    // Close the modal
                    $('#deleteJobTitle').modal('hide');

                    // Show success toast
                    showSuccessToast(response.message);
                },
                error: function (xhr) {
                    // Extract the error message from the API response
                    let errorMessage = xhr.responseJSON && xhr.responseJSON.messages ? xhr.responseJSON.messages.error : 'Failed to delete job title. Please try again.';
                    
                    // Show the error toast
                    showErrorToast(errorMessage);
                }
            });
        });


        // Handle the Add to List button click
        $('#addToList').click(function (e) {
            e.preventDefault(); // Prevent form submission

            let jobTitle = $('#jobTitleInput').val(); // Get job title input

            if (jobTitle === '') {
                showErrorToast('Please enter a job title.'); // Validation error
                return;
            }

            const formData = new FormData();
            formData.append("job_title", jobTitle);

            // Make AJAX request to add the job title
            $.ajax({
                url: SITEURL+'job-title/add', // Backend URL for adding job titles
                headers: {
                    "X-CSRF-TOKEN": getCSRFToken(),
                },
                type: "POST",
                data: formData,
                dataType: "json",  
                processData: false, 
                contentType: false, 
                success: function (response) {
                    // Clear the input field
                    $('#jobTitleInput').val('');

                    // Append the new job title to the list dynamically
                    $('#jobTitleList').append(`
                        <tr id="job-list-item-${response.id}">
                                <td> ${response.job_title}</td>
                                <td class="text-end">
                                    unassigned
                                        <button class="ms-2 delete-job-title" type="button" data-bs-target="#deleteJobTitle" data-bs-toggle="modal" 
                                            data-job-title="${response.job_title}" 
                                            data-id="${response.id}">
                                            <svg class="icon icon-delete">
                                                <use href="/assets/themes/default/icon/icons/icons.svg#delete" />
                                            </svg>
                                        </button>
                                </td>
                            </tr>
                    `);

                    // Append the new job title to the select dropdown
                    $('#jobTitleSelect_1').append(`
                        <option value="${response.job_title}">${response.job_title}</option>
                    `);

                    // Show the success toast with a message from the API
                    showSuccessToast(response.message || 'Job title added successfully.');
                },
                error: function (xhr) {
                    // Extract the error message from the API response
                    let errorMessage = xhr.responseJSON && xhr.responseJSON.messages ? xhr.responseJSON.messages.error : 'Failed to add job title. Please try again.';
                    
                    // Show the error toast
                    showErrorToast(errorMessage);
                }
            });
        });


        let inviteCount = 1; // Start with one invite form
        const maxInvites = 10; // Limit of 10 invites

        // Function to update the IDs and names of the newly added form
        function updateFormIds(form, count) {
            form.attr('id', `userInviteForm_${count}`);
            form.find('#firstName_1').attr('id', `firstName_${count}`).attr('name', `firstName_${count}`);
            form.find('#lastName_1').attr('id', `lastName_${count}`).attr('name', `lastName_${count}`);
            form.find('#email_1').attr('id', `email_${count}`).attr('name', `email_${count}`);
            form.find('#role_1').attr('id', `role_${count}`).attr('name', `role_${count}`);
            form.find('#jobTitleSelect_1').attr('id', `jobTitleSelect_${count}`).attr('name', `job_title_${count}`);
        }

        // Handle adding additional user invite forms
        $('#invite_additional').click(function (e) {
            e.preventDefault(); // Prevent the default action

            if (inviteCount < maxInvites) {
                inviteCount++; // Increment the count of invite forms

                // Clone the first form and update its IDs
                let newForm = $('#userInviteForm_1').clone(); // Clone the first form
                updateFormIds(newForm, inviteCount); // Update the IDs for the cloned form

                newForm.find(".delete").removeClass('d-none');

                newForm.find(".select2").remove();

                ComponentDropdownSelect2.init(newForm.find('.component__dropdown2'));

                // Append the new form to the container (before the invite button)
                newForm.insertAfter('#userInviteForm_1').hide().fadeIn(); // Insert and animate

                if (inviteCount === maxInvites) {
                    // Disable the "Invite additional user" button if max limit is reached
                    $('#invite_additional').addClass('disabled').text('Invite limit reached');
                }
            }
        });


        // Handle form submission
        $('#inviteUsersBtn').click(function (e) {
            e.preventDefault(); // Prevent default form submission

            let allFormsValid = true;

            // Loop through all forms to check for validation
            $('.userInviteForm').each(function () {
                let form = $(this);
                form.addClass('was-validated'); // Add Bootstrap validation class
                
                // If any field is invalid, prevent the form from being submitted
                console.log(form);
                
                    let first_name = form.find('input[id^="firstName_"]');
                    let last_name = form.find('input[id^="lastName_"]');

                    if (first_name.val() === null || first_name.val() === "") {
                        first_name.closest('.is-required').addClass('_invalid');
                        allFormsValid = false;
                    } else {
                        first_name.closest('.is-required').removeClass('_invalid');
                    }

                    if (last_name.val() === null || last_name.val() === "") {
                        last_name.closest('.is-required').addClass('_invalid');
                        allFormsValid = false;
                    } else {
                        last_name.closest('.is-required').removeClass('_invalid');
                    }

                    // Validate Work Email
                    let emailField = form.find('input[id^="email_"]');
                    let email = emailField.val().trim();
                    // TODO
                    //let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

                    if (!email) {
                        emailField.closest('.is-required').addClass('_invalid');
                        allFormsValid = false;
                    } /*else if (!emailPattern.test(email)) {
                        emailField.closest('.is-required').addClass('_invalid');
                        emailField.siblings('.form-field__error').text('Invalid email format').show();
                        allFormsValid = false;
                    }*/ else {
                        emailField.closest('.is-required').removeClass('_invalid');
                        emailField.siblings('.form-field__error').hide();
                    }


                    // Manually check if select fields have valid values
                    let roleSelect = form.find('select[id^="role_"]');
                    let jobTitleSelect = form.find('select[id^="jobTitleSelect_"]');

                    // Check if the selected value is invalid (default "Select" option)
                    if (roleSelect.val() === null || roleSelect.val() === "") {
                        roleSelect.addClass('is-invalid');
                        allFormsValid = false;
                    } else {
                        roleSelect.removeClass('is-invalid');
                    }

                    if (jobTitleSelect.val() === null || jobTitleSelect.val() === "") {
                        //jobTitleSelect.addClass('is-invalid');
                        allFormsValid = false;
                    } else {
                        jobTitleSelect.removeClass('is-invalid');
                    }
            });

            if (allFormsValid) {
                // Collect all invite form data
                let inviteFormsData = [];

                $('.userInviteForm').each(function () {
                    let formId = $(this).attr('id');
                    let formData = {
                        first_name: $(this).find(`#firstName_${formId.split('_')[1]}`).val(),
                        last_name: $(this).find(`#lastName_${formId.split('_')[1]}`).val(),
                        email: $(this).find(`#email_${formId.split('_')[1]}`).val(),
                        role: $(this).find(`#role_${formId.split('_')[1]}`).val(),
                        job_title: $(this).find(`#jobTitleSelect_${formId.split('_')[1]}`).val(),
                    };
                    inviteFormsData.push(formData);
                });

                // Send the collected form data via AJAX to the backend
                $.ajax({
                    url: SITEURL+'accounts/invite-users',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCSRFToken(),
                    },
                    contentType: 'application/json',
                    data: JSON.stringify({ invites: inviteFormsData }),
                    success: function (response) {
                        new Toast({ position: ".offcanvas-end.show .offcanvas-header", text: 'Invitations ('+inviteFormsData.length +') sent successfully', type: 'successful' })

                        // Remove all forms except the first one
                        $('.userInviteForm').not(':first').remove();
                        $('#userInviteForm_1').removeClass('was-validated');
                        // Clear the first form fields
                        $('.userInviteForm:first').find('input, select').val('').removeClass('was-validated');

                        $('#role_1').val(null).trigger('change');
                        $('#jobTitleSelect_1').val(null).trigger('change');

                        // update last users
                        loadUsers(); 
                    },
                    error: function (xhr) {
                        let errorMessage = xhr.responseJSON && xhr.responseJSON.messages ? xhr.responseJSON.messages.error : 'Failed to send invitations. Please try again.';
                        new Toast({ position: ".offcanvas-end.show .offcanvas-header", text: errorMessage, type: 'error' })
                    }
                });
            } else {
                new Toast({ position: ".offcanvas-end.show .offcanvas-header", text: 'Please fill in all required fields.', type: 'error' })
            }
        });


         // Listen for the offcanvas 'shown' event
        $('#invite_users_sidebar').on('shown.bs.offcanvas', function () {
            console.log('Invite Users sidebar is now open');
            // You can trigger any additional logic here
            $('#firstName_1').focus(); 
        });

        $('#invite_users_sidebar').on('shown.bs.offcanvas', function () {
            loadUsers(); 
        });

        // Function to load both registered and invited users
        function loadUsers() {
            $.ajax({
                url: SITEURL+'user-management/get-last-users', 
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    let registeredUsers = response.registeredUsers; // Get registered users from response
                    let invitedUsers = response.invitedUsers; // Get invited users from response

                    let registeredContainer = $('#registeredUsersList');
                    let invitedContainer = $('#invitedUsersList');

                    // Clear existing content
                    registeredContainer.empty();
                    invitedContainer.empty();

                    // Populate registered users
                    if (registeredUsers.length > 0) {
                        registeredUsers.forEach(function (user) {
                            registeredContainer.append(`
                                <div class="card p-3 mb-2 rounded-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <picture class="photo__image">
                                                <img src="/user/profile-avatar/${user.id}?width=52&height=52" alt="img" class="photo__img" width="52" height="52" />
                                            </picture>

                                            <div>
                                                <p class="fw-medium">${user.first_name} ${user.last_name}</p>
                                                <p class="fs-12">${user.email}</p>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <p class="fs-12 fw-medium">${user.group_name}</p>
                                            <p class="fs-12">${user.company_name}</p>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    } else {
                        registeredContainer.append('<p class="text-muted">No registered users available at the moment.</p>');
                    }

                    // Populate invited users
                    if (invitedUsers.length > 0) {
                        invitedUsers.forEach(function (user) {
                            invitedContainer.append(`
                                    <div class="card p-3 mb-2 rounded-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <picture class="photo__image">
                                                    <img src="/user/profile-avatar/${user.id}?width=52&height=52" alt="img" class="photo__img" width="52" height="52" />
                                                </picture>

                                                <div>
                                                    <p class="fw-medium">${user.first_name} ${user.last_name}</p>
                                                    <p class="fs-12">${user.email}</p>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <p class="fs-12 fw-medium">${user.group_name}</p>
                                                <p class="fs-12">${user.company_name}</p>
                                            </div>
                                        </div>
                                    </div>
                            `);
                        });
                    } else {
                        invitedContainer.append('<p class="text-muted">No invited users available at the moment.</p>');
                    }

                    // Update badges with the number of users
                    $('#registered-tab .counter').text(registeredUsers.length);
                    $('#invited-tab .counter').text(invitedUsers.length);
                },
                error: function () {
                    $('#registeredUsersList').html('<p class="text-danger">Failed to load registered users.</p>');
                    $('#invitedUsersList').html('<p class="text-danger">Failed to load invited users.</p>');
                }
            });
        }
        

        /* END Invite  */

        // Initialize pagination
        const _jsPagination = new jsPagination();
        _jsPagination.updatePagination(loadUsersPage);  // Changed to load users page
    }

    updateStyle = (elem) => {
        if (elem.val() !== '') {
            elem.addClass('has-value');
        } else {
            elem.removeClass('has-value');
        }
    }

    applyFilter = () => {
        console.log("UserManagementIntegration applyFilter");

        const formData = getFormData();

        // Make AJAX request for filtering users
        $.ajax({
            url: `${SITEURL}user-management/list/filter`,  // Changed to user management endpoint
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": getCSRFToken(),
            },
            data: formData,
            processData: false, // Important for FormData
            contentType: false, // Important for FormData
            dataType: "json",
            success: (data) => {
                console.log(data);

                const $ListContent = $("#ListContent");
                $ListContent.empty(); // Clear the container
                $ListContent.append(data.Content); // Append the new HTML content for user list

                const $SectionOffcanvas = $("#SectionOffcanvas");
                $SectionOffcanvas.empty(); // Clear the offcanvas section
                $SectionOffcanvas.append(data.SectionOffcanvas); // Append the new HTML for offcanvas if needed

                new EditUserOffcanvas();

                const _jsPagination = new jsPagination();
                _jsPagination.updatePagination(loadUsersPage);  // Update pagination for users

                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
                const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

                updateTotalResults();  // Update the total number of users shown
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error("Error:", textStatus, errorThrown);
            },
        });
    };
}

function resetAllFilters(elem) {
    const tab = elem.closest('.js__users-filters-tab');
    const listSelect2 = tab.find('.js__select2');
    listSelect2.val(null).trigger('change');
}

function getFormData() {
    // Create a FormData object for user management filters
    const formData = new FormData();

    // Append values from filters to the FormData object
    formData.append("status", $("#usersFilterStatus").val());
    formData.append("role", $("#usersFilterRole").val());
    formData.append("job_title", $("#usersFilterJob").val());
    formData.append("plaintiff_name", $("#usersFilterPlantiffName").val());
    formData.append("user_name_email", $("#usersSearchesSearchUsersByNameEmail").val());

    console.log("formData", formData);

    return formData;
}


function loadUsersPage(page) {
    const formData = getFormData();

    console.log("page", page);

    formData.append("page", page);

    // Make AJAX request to load paginated users
    $.ajax({
        url: SITEURL + `user-management/list/filter`,  // Changed to user management endpoint
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": getCSRFToken(),
        },
        data: formData,
        processData: false, // Important for FormData
        contentType: false, // Important for FormData
        dataType: "json",
        success: (data) => {
            console.log(data);

            const $ListContent = $("#ListContent");
            $ListContent.empty(); // Clear the container
            $ListContent.append(data.Content); // Append the new HTML content for user list

            const $SectionOffcanvas = $("#SectionOffcanvas");
            $SectionOffcanvas.empty(); // Clear the offcanvas section
            $SectionOffcanvas.append(data.SectionOffcanvas); // Append the new HTML for offcanvas if needed

            new EditUserOffcanvas();

            const _jsPagination = new jsPagination();
            _jsPagination.updatePagination(loadUsersPage);  // Update pagination for users
            
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

            updateTotalResults();  // Update the total number of users shown
        },
        error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error:", textStatus, errorThrown);
        },
    });
}


// Function to get selected user IDs
function getSelectedUsers() {
    let selectedUsers = [];
    $("input.user:checked").each(function () {
        selectedUsers.push($(this).val());
    });
    return selectedUsers;
}

//toast
const toastFormInvite = document.querySelector(".invite-users .js-toast")

if(toastFormInvite){

    $('.invite-users .js-toast-btn').click(function(event) {
        new Toast({ position: ".offcanvas-end.show .offcanvas-header", text: toastFormInvite.getAttribute("data-toast"), type: toastFormInvite.getAttribute("data-toast-status"), class: toastFormInvite.getAttribute("data-toast-class") })
    });
}
const toastFormJobTitle = document.querySelector(".job-title .js-toast")

if(toastFormJobTitle){

    $('.job-title .js-toast-btn').click(function(event) {
        new Toast({ position: ".offcanvas-end.show .offcanvas-header", text: toastFormJobTitle.getAttribute("data-toast"), type: toastFormJobTitle.getAttribute("data-toast-status") })
    });
}
