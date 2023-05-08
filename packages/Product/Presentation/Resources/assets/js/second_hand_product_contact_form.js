const buttons = document.querySelectorAll('.interested-in');
let buttonId;
let productName;
let contactForm;

buttons.forEach((button) => {
  button.addEventListener('click', () => {
    buttonId = button.attributes[2].value;
    // eslint-disable-next-line no-undef
    headers = document.querySelectorAll('h3.ProductContainer-textProductName');
    // eslint-disable-next-line no-undef
    headers.forEach((header) => {
      if (header.children[0].href.slice(-1) === buttonId) {
        // eslint-disable-next-line prefer-destructuring
        productName = header.children[0];
      }
    });
    contactForm = document.querySelector('#second_hand_product_contact_form_text');
    contactForm.innerHTML = `Mám zájem o ${productName.innerText}, je tento produkt k dispozici?`;
  });
});
