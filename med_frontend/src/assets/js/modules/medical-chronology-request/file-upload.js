// import { Toast } from "../../components/toast"
import { itemMarkup } from "./_item-markup"
import { getCSRFToken } from "../../global-functions";

export class uploadFileField {
  constructor(fileInput, formInstance) {
    this.uploadInput = fileInput
    this.form = this.uploadInput.closest(".js-upload-file-form")
    this.formInstance = formInstance
    this.progressWrap = this.form.querySelector(".js-upload-file-progress-wrap")
    this.progressFill = this.form.querySelector(".js-upload-file-progressline-fill")
    this.progressCounter = this.form.querySelector(".js-upload-file-progressline-counter")
    this.fileLoadSection = this.form.querySelector(".js-upload-file-loadbox")
    this.filesCounter = this.form.querySelector(".js-upload-file-files-counter")
    this.itemsList = this.form.querySelector(".js-upload-file-items")
    this.validStatusForm = true

    this.init()
  }

  updateCounter = () => {
    const totalLoaded = this.itemsList.querySelectorAll(
      ".medical-chronology-request-form-upload-file__item",
    ).length
    //this.filesCounter.innerText = totalLoaded
    if (totalLoaded < 1) {
      this.resetFields()
      this.fileLoadSection.classList.remove("_show")
      this.uploadInput.value = ""
      this.formInstance.files = []
      this.formInstance.checkisFormFilled()
    }
  }

  resetFields = () => {
    this.progressWrap.classList.remove("_show")
    this.progressFill.style.width = "0%"
    this.progressCounter.innerText = "0%"
  }

  // handlers =========================================

  handleRemove = (event) => {
    const _self = this;
    if (event.target.classList.contains("js-upload-file-delete-btn")) {

      // Attach event listener for delete buttons

      const $button = $(event.target);
      const fileId = $button.data('item-id'); // Retrieve the file ID
      console.log(fileId);


      // Confirm the deletion action (optional)
      // if (!confirm("Are you sure you want to delete this file?")) {
      //     return;
      // }

      // AJAX request to delete the file
      $.ajax({
          url: SITEURL + 'orders/delete-exhibit', // Endpoint for file deletion
          type: 'POST',
          data: JSON.stringify({ file_id: fileId }),
          headers: {
              "X-CSRF-TOKEN": getCSRFToken(), 
          },
          contentType: 'application/json',
          dataType: 'json',
          success: function (response) {
              if (response.success) {
                  // Remove the file item from the DOM
                  $button.closest('.medical-chronology-request-form-upload-file__item').remove();
                  console.log("File deleted successfully.");
                  $('.cost-amount').html(response.total_cost);
                  $('.total-exhibits').html(response.exhibit_count);
                  $('.total-pages').html(response.total_pages);
                  _self.updateCounter()
                  new Toast({ position: ".header .justify-content-end", text: 'File deleted successfully.', type: 'successful', class: 'page-toast'  })

              } else {
                  new Toast({ position: ".header .justify-content-end", text: 'Failed to delete file. Please try again.', type: 'error', class: 'page-toast' })
              }
          },
          error: function (xhr) {
              console.error("Error deleting file:", xhr.responseText);
              new Toast({ position: ".header .justify-content-end", text: 'An error occurred while deleting the file. Please try again.', type: 'error', class: 'page-toast' })
          }
      });

      //event.target.closest(".medical-chronology-request-form-upload-file__item").remove()

    }
  }



  changeFileHandle = (event) => {
    const files = event.target.files;

    // Check and filter PDF files
    const pdfFiles = Array.from(files).filter(file => file.type === "application/pdf");

    if (pdfFiles.length === 0) {
        console.warn("No PDF files selected. Please upload files in PDF format.");
        return;
    }

    pdfFiles.forEach((file) => {
        const fileSize = file.size;
        const fileName = file.name.replace(/_/g, ' ').replace(/-/g, ' ');

        console.log(`Uploading: ${fileName}, Size: ${fileSize} bytes`);


        // Create FormData for each file
        const formData = new FormData();
        const nameForRequest = this.uploadInput.getAttribute("name")
        const orderNumber = $('#medical-chronology-request-order-number').val();
        const reportType = $('#report_type').val();
        formData.append(nameForRequest, file);
        formData.append('order_number', orderNumber);
        formData.append('report_type', reportType);

        // Show progress for each file
        this.progressWrap.classList.add("_show");
        this.formInstance.files.push(file)

        // Perform AJAX upload with progress handling for each file
        $.ajax({
            url: `${SITEURL}orders/upload-exhibits`,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            xhr: () => {
                const xhr = new window.XMLHttpRequest();
                xhr.upload.onprogress = (event) => {
                    if (event.lengthComputable) {
                        const percent = Math.round((event.loaded / event.total) * 100);
                        console.log(`Upload progress for ${fileName}: ${percent}%`);
                        this.progressFill.style.width = `${percent}%`;
                        setTimeout(() => {
                            this.progressCounter.innerText = `${percent}%`;
                        }, 10);

                        if (event.loaded === event.total) {
                            setTimeout(() => this.resetFields(), 2000);
                        }
                    }
                };
                return xhr;
            },
            success: (response) => {
                console.log(`Upload successful for ${fileName}`);
                
                console.log(response);

                new Toast({ position: ".header .justify-content-end", text: 'Exhibit(s) uploaded successfully!', type: 'successful', class: 'page-toast'  })
                
                this.fileLoadSection.classList.add("_show");
                this.itemsList.append(itemMarkup(fileName, fileSize, response.fileHash));
                $('.cost-amount').html(response.total_cost);
                $('.total-exhibits').html(response.exhibit_count);
                $('.total-pages').html(response.total_pages);
                $('#user_order_number').html(response.order_number);
                $('#medical-chronology-request-order-number').val(response.order_number);
            },
            error: (response) => {
                console.error(`Upload failed for ${fileName}`);
                console.log(response);
                // Error: Please upload PDF file(s). The file(s) you uploaded are not in the correct format.
                // Upload Failed: One or more files are duplicates and have already been uploaded.
                // Upload Failed: Unable to upload the file(s) due to server issues. Please try again later.
                // Upload Failed: The PDF file you uploaded is corrupt and cannot be processed.
                new Toast({ position: ".header .justify-content-end", text: `Upload failed for ${fileName}`, type: 'error', class: 'page-toast' })
            },
            complete: () => {
                this.progressWrap.classList.remove("_show");
                this.updateCounter();
            }
        });
    });
};


/*

  changeFileHandle = (event) => {
    const file = event.target.files[0];

    // Check if the file is a PDF
    if (file.type !== "application/pdf") {
      console.warn(`The selected file type is ${file.type}. Only 'application/pdf' is allowed.`);
      return;
    }

    const fileSize = file.size;
    const fileName = file.name.replace(/_/g, ' ').replace(/-/g, ' ');
    console.log(`Uploading: ${fileName}, Size: ${fileSize} bytes`);

    // Show file section and append the file to the list
    this.fileLoadSection.classList.add("_show");
    this.itemsList.append(itemMarkup(fileName, fileSize));

    // Prepare form data for upload
    const formData = new FormData();

    const formData = new FormData()
    let nameForRequest = "file_name"
    if (this.uploadInput.hasAttribute("name")) {
      nameForRequest = this.uploadInput.getAttribute("name")
    }
    formData.append(nameForRequest, file)
    // Show progress bar
    this.progressWrap.classList.add("_show");

    // Perform AJAX upload with progress handling
    $.ajax({
      url: `${SITEURL}orders/upload-exhibits`,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      xhr: () => {
        const xhr = new window.XMLHttpRequest();
        xhr.upload.onprogress = (event) => {
          if (event.lengthComputable) {
            const percent = Math.round((event.loaded / event.total) * 100);
            console.log(`Upload progress: ${percent}%`);
            this.progressFill.style.width = `${percent}%`;
            setTimeout(() => {
              this.progressCounter.innerText = `${percent}%`;
            }, 50);

            if (event.loaded === event.total) {
              setTimeout(() => this.resetFields(), 1500);
            }
          }
        };
        return xhr;
      },
      success: () => {
        console.log("Upload successful");
        // Additional success handling if needed
      },
      error: () => {
        console.error("Upload failed");
        // Additional error handling if needed
      },
      complete: () => {
        this.progressWrap.classList.remove("_show");
        this.updateCounter();
      }
    });
  };
  */



  // changeFileHandle = (event) => {
  //   const file = event.target.files[0]

  //   if (file.type !== "application/pdf") {
  //     console.warn(`your file type is ${file.type} not match to 'application/pdf'`)
  //   }
  //   console.log(file)
  //   /*this.formInstance.files.push(file)*/
  //   /*this.formInstance.checkisFormFilled()*/
  //   const fileSize = file.size
  //   const fileName = file.name.replace(/_/g, ' ').replace(/-/g, ' ')
  //   console.log(fileName);
  //   this.fileLoadSection.classList.add("_show")
  //   this.itemsList.append(itemMarkup(fileName, fileSize))

  //   const formData = new FormData()
  //   let nameForRequest = "file_name"
  //   if (this.uploadInput.hasAttribute("name")) {
  //     nameForRequest = this.uploadInput.getAttribute("name")
  //   }
  //   formData.append(nameForRequest, file)

  //   const xhr = new XMLHttpRequest()

  //   this.progressWrap.classList.add("_show")
  //   xhr.upload.onprogress = (event) => {
  //     if (event.lengthComputable) {
  //       const percent = Math.round((event.loaded / event.total) * 100)
  //       console.log(`Upload progress: ${percent}%`)
  //       this.progressFill.style.width = `${percent}%`
  //       setTimeout(() => {
  //         this.progressCounter.innerText = `${percent}%`
  //       }, 700)
  //       if (event.loaded === event.total) {
  //         setTimeout(() => {
  //           this.resetFields()
  //         }, 1500)
  //       }
  //     }
  //   }

  //   xhr.onload = function () {
  //     this.progressWrap.classList.remove("_show")
  //     if (xhr.status === 201) {
  //       console.log("Upload successful")

  //       // if success todo
  //     } else {
  //       console.error("Upload failed")
  //       // if error todo
  //     }
  //   }

  //   this.updateCounter()

  //   xhr.open("POST", SITEURL+"orders/upload-exhibits", true)
  //   xhr.send(formData)
  // }

  submitFileFormHandle = (e) => {
    e.preventDefault()
  }
  // handlers end =====================================

  init() {
    this.uploadInput.addEventListener("change", (event) => {
      this.changeFileHandle(event)
    })
    this.itemsList.addEventListener("click", this.handleRemove)
  }
}
