const country = document.querySelector('#client__country');
const vatIdSk = document.querySelector('#client__personalDetails_vatIdSk');
const aresButton = document.querySelector('.aresButton');

if (country.value === 'CZECHIA') {
  vatIdSk.disabled = true;
  aresButton.disabled = false;
}
if (country.value === 'SLOVAKIA') {
  vatIdSk.disabled = false;
  aresButton.disabled = true;
}

// eslint-disable-next-line no-unused-vars
country.addEventListener('change', (event) => {
  if (country.value === 'CZECHIA') {
    vatIdSk.disabled = true;
    aresButton.disabled = false;
  }
  if (country.value === 'SLOVAKIA') {
    vatIdSk.disabled = false;
    aresButton.disabled = true;
  }
});
