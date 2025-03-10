import { getCSRFToken} from "../../global-functions";
import {Toast} from "../../components/toast";

export class JobTitleIntegration {
    constructor() {
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
                    new Toast({ position: ".offcanvas-end.show .offcanvas-header", text: (response.message || 'Job title deleted successfully.'), type: 'successful' })
                    
                },
                error: function (xhr) {
                    // Extract the error message from the API response
                    let errorMessage = xhr.responseJSON && xhr.responseJSON.messages ? xhr.responseJSON.messages.error : 'Failed to delete job title. Please try again.';
                    
                    // Show the error toast
                    new Toast({ position: ".offcanvas-end.show .offcanvas-header", text: errorMessage, type: 'error' })
                }
            });
        });


        // Handle the Add to List button click
        $('#addToList').click(function (e) {
            e.preventDefault(); // Prevent form submission

            let jobTitle = $('#jobTitleInput').val(); // Get job title input

            if (jobTitle === '') {
                new Toast({ position: ".offcanvas-end.show .offcanvas-header", text: 'Please enter a job title.', type: 'error' })
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
                    const option = `<option value="${response.job_title}">${response.job_title}</option>`
                    $('#jobTitleSelect_1').append(option);

                    // Add this class to all select "Job Title"
                    $('.js__select-to-custom-add-job-title .js__select2').append(option).trigger('change');
                    $('.js__select-to-custom-add-job-title .js__select2').val(response.job_title).trigger('change');

                    // Show the success toast with a message from the API
                    new Toast({ position: ".offcanvas-end.show .offcanvas-header", text: (response.message || 'Job title added successfully.'), type: 'successful' })
                },
                error: function (xhr) {
                    // Extract the error message from the API response
                    let errorMessage = xhr.responseJSON && xhr.responseJSON.messages ? xhr.responseJSON.messages.error : 'Failed to add job title. Please try again.';
                    
                    // Show the error toast
                    new Toast({ position: ".offcanvas-end.show .offcanvas-header", text: errorMessage, type: 'error' })
                }
            });
        });

        // Trigger add to list when pressing Enter in the job title input field
        $('#jobTitleInput').on('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Prevent default form submission
                $('#addToList').click(); // Trigger the add to list function
            }
        });
    }
}