const fileInput = document.querySelector('.input-container.profilepictureInput input[type="file"]');
const profilePic = document.querySelector('.current-picture img');

if(fileInput){
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                profilePic.src = event.target.result; 
            };
            reader.readAsDataURL(file);
        }
    });
}

// Select all input fields using the specific selector
const passwordInputFields = document.querySelectorAll('.input-container.field-error input');

if(passwordInputFields){
// Function to check the input value and toggle class on the parent container
    function togglePasswordClass(input) {
        const inputContainer = input.closest('.input-container'); // Get the parent container
        if (input.value) {
            inputContainer.classList.add('filled'); // Add class to parent if input is not empty
        } else {
            inputContainer.classList.remove('filled'); // Remove class from parent if input is empty
        }
    }

    // Loop through each input and add event listeners
    passwordInputFields.forEach(input => {
        input.addEventListener('input', () => togglePasswordClass(input));
        input.addEventListener('blur', () => togglePasswordClass(input)); // Optional: check when the input loses focus
    });
}






