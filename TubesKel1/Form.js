document.querySelectorAll('.upload-form').forEach((form) => {
  form.addEventListener('submit', (event) => {
    event.preventDefault(); // Prevent default form submission

    const formData = new FormData(form);
    const formAction = form.getAttribute('action');

    fetch(formAction, {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(data => {
      alert(data); // Show response message from form.php
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Terjadi kesalahan saat mengunggah file.');
    });
  });
});
