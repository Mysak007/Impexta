import $ from 'jquery';

const vatInput = $('input[name="client_[personalDetails][vatId]"]');
const nameInput = $('input[name="client_[personalDetails][companyName]"]');
const addressInput = $('input[name="client_[billingAddress][address][address]"]');
const aresError = $('.aresError');

function fillFromAres(data) {
  vatInput.val(data.tax_id);
  nameInput.val(data.company_name);

  let houseNumber = data.street_house_number;
  if (data.street_orientation_number) {
    houseNumber += `/${data.street_orientation_number}`;
  }

  addressInput.val(`${data.street} ${houseNumber}, ${data.zip} ${data.town}`);
}

$(document).ready(() => {
  $('.aresButton').click(() => {
    aresError.hide();
    $.ajax({
      type: 'GET',
      url: `/crm/api/ares/${$('#client__personalDetails_taxId').val()}`,
      success(data) {
        const parsedData = JSON.parse(data);
        if (!parsedData.street) {
          parsedData.street = parsedData.town;
        }
        fillFromAres(parsedData);
        addressInput.delay(500).trigger('keyup');
      },
      error() {
        aresError.show();
      },
    });
  });
});
