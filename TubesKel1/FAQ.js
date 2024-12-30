document.addEventListener("DOMContentLoaded", () => {
    const faqContainer = document.getElementById("faq-container");
    const addFaqBtn = document.getElementById("add-faq-btn");
    const pertanyaanInput = document.getElementById("pertanyaan");
  
    // Fungsi untuk memuat data FAQ dari server (Read)
    const loadFAQs = async () => {
      try {
        const response = await fetch("faq.php", { method: "GET" });
        const faqs = await response.json();
  
        faqContainer.innerHTML = ""; // Kosongkan kontainer sebelum diisi
  
        faqs.forEach((faq) => {
          const faqItem = document.createElement("div");
          faqItem.className = "faq-item";
  
          faqItem.innerHTML = `
            <h3>${faq.pertanyaan}</h3>
            <p>${faq.jawaban}</p>
          `;
  
          faqContainer.appendChild(faqItem);
        });
      } catch (error) {
        console.error("Gagal memuat FAQ:", error);
      }
    };
  
    // Fungsi untuk menambahkan pertanyaan baru (Create)
    const addFAQ = async () => {
      const pertanyaan = pertanyaanInput.value.trim();
  
      if (!pertanyaan) {
        alert("Pertanyaan tidak boleh kosong!");
        return;
      }
  
      try {
        const response = await fetch("faq.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `pertanyaan=${encodeURIComponent(pertanyaan)}`,
        });
  
        const result = await response.json();
        alert(result.message); // Beri notifikasi jika berhasil atau gagal
        pertanyaanInput.value = ""; // Kosongkan input
      } catch (error) {
        console.error("Gagal menambahkan FAQ:", error);
      }
    };
  
    // Event listener untuk tombol Tambahkan
    addFaqBtn.addEventListener("click", addFAQ);
  
    // Muat data FAQ saat halaman dimuat
    loadFAQs();
  });
  