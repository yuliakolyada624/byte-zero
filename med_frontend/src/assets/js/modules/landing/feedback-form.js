export class FeedbackForm {
  constructor(form) {
    this.form = form
    this.requiredInputs = form.querySelectorAll('.js-feedback-input[data-validation="true"]')
    this.radioGroup = form.querySelectorAll('input[name="topic_of_interest"]');
    this.isValid = true
    this.#init()
  }

  handleSubmit = (event) => {
    event.preventDefault()
    //console.log('Form submitted')
    this.requiredInputs.forEach((input) => {
      if (!input.value.length) {
        this.isValid = false
        input.classList.add('is-invalid')
      } else {
        input.classList.remove('is-invalid')
      }
    })

    if (this.isValid) {
      const formData = this.getFormData();

      $.ajax({
        url: this.form.action, 
        type: 'POST', 
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        },
        data: formData, 
        dataType: 'json', 
        success: (response) => {
          console.log(response); 
          // Clear the form fields
          this.form.reset(); // Reset the form to its initial values
          this.form.parentNode.classList.add("success");
          setTimeout(() => this.form.parentNode.classList.remove("success"), 5000);
        },
        error: (jqXHR, textStatus, errorThrown) => {
          console.error(textStatus, errorThrown); 
        }
      });

    } else {
      this.isValid = true
    }
  }


  getFormData() {
    const formData = {};
    this.requiredInputs.forEach(input => {
      formData[input.name] = input.value;
    });
    
    this.radioGroup.forEach(radio => {
      if (radio.checked) {
        formData[radio.name] = radio.value;
      }
    });

    return formData; 
  }

  #init() {
    this.form.addEventListener("submit", this.handleSubmit)
  }
}
