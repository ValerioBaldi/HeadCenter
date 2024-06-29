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

// Gestisci il submit della form (puoi gestire qui l'invio dei dati tramite AJAX o altro)
document.getElementById('multi-step-form').addEventListener('submit', (event) => {
    event.preventDefault();
    // Esempio di output dei dati
    const formData = new FormData(event.target);
    const formObject = {};
    formData.forEach((value, key) => {
        formObject[key] = value;
    });
    console.log('Dati della form:', formObject);
});
