document.addEventListener("DOMContentLoaded", function () {
    // Kalender interaktif
    const calendarBody = document.getElementById("calendarBody");
    const currentMonth = document.getElementById("currentMonth");

    const today = new Date();

    const renderCalendar = () => {
        const monthNames = [
            "January", "February", "March", "April", "May",
            "June", "July", "August", "September", "October", "November", "December"
        ];

        // Set judul bulan dan tahun
        currentMonth.textContent = `${monthNames[today.getMonth()]}, ${today.getFullYear()}`;

        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1).getDay();
        const lastDate = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate();

        // Clear table and redraw
        calendarBody.innerHTML = "";
        let row = document.createElement("tr");

        for (let i = 0; i < firstDay; i++) {
            row.appendChild(document.createElement("td"));
        }

        for (let date = 1; date <= lastDate; date++) {
            const cell = document.createElement("td");
            cell.textContent = date;
            cell.classList.add("calendar-date");

            // Highlight today's date
            if (date === today.getDate()) {
                cell.classList.add("highlight");
            }

            row.appendChild(cell);

            if ((date + firstDay) % 7 === 0 || date === lastDate) {
                calendarBody.appendChild(row);
                row = document.createElement("tr");
            }
        }
    };

    renderCalendar();

    // Kalender - Pilih tanggal
    calendarBody.addEventListener("click", function (e) {
        if (e.target.classList.contains("calendar-date") && e.target.innerText) {
            alert(`Tanggal: ${e.target.innerText} dipilih.`);
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        const seeMoreButton = document.querySelector(".see-more-btn");
        
        // Interaksi tombol "Lihat Selengkapnya"
        seeMoreButton.addEventListener("click", function () {
            alert("Fitur 'Lihat Selengkapnya' sedang dalam pengembangan!");
        });
    });
    
});
