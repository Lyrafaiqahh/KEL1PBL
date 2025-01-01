document.querySelectorAll('.upload-form').forEach((form) => {
  form.addEventListener('submit', (event) => {
    event.preventDefault(); // Prevent default form submission

    const fileInput = form.querySelector('input[type="file"]');
    const files = fileInput.files;

    // Check if any file is not PDF
    for (const file of files) {
      if (file.type !== 'application/pdf') {
        alert('Hanya file PDF yang diizinkan. Silakan unggah file dengan format PDF.');
        return; // Stop the upload process
      }
    }

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
