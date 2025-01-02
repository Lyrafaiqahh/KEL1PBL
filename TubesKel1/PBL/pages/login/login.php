<script>
	$("#form-login").on("submit", function(event) {
			event.preventDefault(); 
			onLogin();
	});
	
	onLogin = () => {
		
		var form = $('#loginForm').get(0);
			var formData = new FormData(form);
			formData.append('action', 'verify_login');
			$.ajax({
				url: '/PBL/system/auth.php',
				data: formData,
				type: 'POST',
				processData: false,
				contentType: false,
				success: (data) => {
					
					if (data) {
						window.location.href = 'dashboard.php';
					} else {
						Swal.fire({
							title: "Login Gagal!",
							text: "Username atau Password tidak sesuai",
							icon: "warning",
							confirmButtonColor: "#3B7DDD",
						});
					}
				},
				error: (jqXHR, textStatus, errorThrown) => {
					console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
				}
			});
	}

</script>