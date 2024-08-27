document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('delivery-form');
    const resultDiv = document.getElementById('result');

    form.addEventListener('submit', (event) => {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData(form);

        fetch('calculate_delivery.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok.');
            }
            return response.text(); // Ensure this is correctly handled
        })
        .then(data => {
            resultDiv.innerHTML = data; // Update the result div with the response data
        })
        .catch(error => {
            console.error('Error:', error);
            resultDiv.innerHTML = 'An error occurred. Please try again.';
        });
    });
});
