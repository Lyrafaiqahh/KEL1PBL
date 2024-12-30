document.querySelectorAll('.upload-main-btn').forEach((button) => {
  button.addEventListener('click', (event) => {
    event.preventDefault(); // Prevent default form submission

    const uploadBox = event.target.closest('.upload-box');
    const fileInput = uploadBox.querySelector('input[type="file"]');
    const formData = new FormData();

    if (fileInput && fileInput.files.length > 0) {
      formData.append('uploads[]', fileInput.files[0]);
      formData.append('nim', document.querySelector('input[name="nim"]').value); // NIM input

      // AJAX request
      fetch('Form.php', {
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
    } else {
      alert('Silakan pilih file terlebih dahulu!');
    }
  });
});
