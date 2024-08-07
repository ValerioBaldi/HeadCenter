let currentPage = 1;
const formPages = document.querySelectorAll('.form-page');
const summaryItems = document.querySelectorAll('.summary-item');

showPage(1);
function showPage(pageNumber) {
    formPages.forEach(page => page.classList.remove('active'));
    summaryItems.forEach(item => item.classList.remove('active'));
    
    formPages[pageNumber - 1].classList.add('active');
    summaryItems[pageNumber - 1].classList.add('active');
    
    if (pageNumber === 9) {
        showSummary();
    }

    currentPage = pageNumber;
}

function nextPage() {
    if (currentPage < formPages.length) {
        showPage(currentPage + 1);
    }
}

// Aggiungi event listener ai punti nel sommario per navigare direttamente alla pagina corrispondente
summaryItems.forEach((item, index) => {
    item.addEventListener('click', () => {
        showPage(index + 1);
    });
});

document.getElementById('multi-step-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Previeni il comportamento predefinito di submit
    
    // Eseguire qui l'invio dei dati tramite AJAX o creare un oggetto FormData
    const formData = new FormData(this); // 'this' fa riferimento al form stesso
    
    // Esempio di invio tramite fetch API
    /* fetch('./digital.php', {
        method: 'POST',
        body: formData,
    })
    fetch('./Download.php', {
        method:'POST',
        body: formData,
    }) */
    fetch('./headache.php', {
        method:'POST',
        body: formData,
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Errore durante l\'invio dei dati');
        }
        return response.text();
    })
    .then(data => {
        console.log('Risposta dal server:', data);
        // Gestisci la risposta dal server come desiderato
        window.location.href = 'okpag.php';
    })
    .catch(error => {
        console.error('Errore:', error);
        // Gestisci gli errori di invio
    });
});

function showSummary() {
    document.getElementById('summary-headache-date').innerText = `Date: ${document.getElementById('headache_date').value}`;
    document.getElementById('summary-starting-time').innerText = `From: ${document.getElementById('starting_time').value}`;
    document.getElementById('summary-ending-time').innerText = `To: ${document.getElementById('ending_time').value}`;
    document.getElementById('summary-still-going').innerText = `Still going: ${document.getElementById('still_going').checked ? 'Yes' : 'No'}`;
    document.getElementById('summary-ache-position').innerText = `Pain Position: ${document.getElementById('ache_position_hidden').value}`;
    document.getElementById('summary-ache-intensity').innerText = `Pain Intensity: ${document.querySelector('input[name="ache_intensity"]:checked').value}`;
    document.getElementById('summary-ache-type').innerText = `Pain Type: ${document.getElementById('ache_type_hidden').value}`;
    document.getElementById('summary-painkillers').innerText = `Painkillers: ${document.getElementById('painkillers_hidden').value}`;
    document.getElementById('summary-repercussions').innerText = `Repercussions: ${document.getElementById('repercussions_hidden').value}`;
    document.getElementById('summary-symptoms').innerText = `Symptoms: ${document.querySelector('textarea[name="symptoms"]').value}`;
    document.getElementById('summary-notes').innerText = `Notes: ${document.querySelector('textarea[name="notes"]').value}`;
};
