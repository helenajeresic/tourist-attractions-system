function validateForm() {
    var naziv = document.getElementById('naziv').value;
    var opis = document.getElementById('opis').value;
    var xKoordinata = document.getElementById('x-koordinata').value;
    var yKoordinata = document.getElementById('y-koordinata').value;
    var slika = document.getElementById('slika').value;

    if(naziv === '' || opis === '' || xKoordinata === '' || yKoordinata === '' || slika === '') {
        alert('Molimo ispunite sva polja!');
        return false;
    }

    return true;
}