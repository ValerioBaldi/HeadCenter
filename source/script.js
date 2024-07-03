let currentPage = 1;
const formPages = document.querySelectorAll('.form-page');
const summaryItems = document.querySelectorAll('.summary-item');

showPage(1);
function showPage(pageNumber) {
    formPages.forEach(page => page.classList.remove('active'));
    summaryItems.forEach(item => item.classList.remove('active'));
    
    formPages[pageNumber - 1].classList.add('active');
    summaryItems[pageNumber - 1].classList.add('active');
    
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
    fetch('./digital.php', {
        method: 'POST',
        body: formData,
    })
    fetch('./Download.php', {
        method:'POST',
        body: formData,
    })
    fetch('./headache.php', {
        method:'POST',
        body: formData,
    })
   /*  .then(response => {
        if (!response.ok) {
            throw new Error('Errore durante l\'invio dei dati');
        }
        return response.text();
    })
    .then(data => {
        console.log('Risposta dal server:', data);
        // Gestisci la risposta dal server come desiderato
    })
    .catch(error => {
        console.error('Errore:', error);
        // Gestisci gli errori di invio
    }); */
});
