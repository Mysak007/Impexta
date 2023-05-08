import $ from 'jquery';

function addFormToCollection($collectionHolderClass) {
  const $collectionHolder = $(`.${$collectionHolderClass}`);

  const prototype = $collectionHolder.data('prototype');

  const index = $collectionHolder.data('index');

  let newForm = prototype;
  newForm = newForm.replace(/__name__/g, index);

  $collectionHolder.data('index', index + 1);

  const $newFormDiv = $('<div class="box box-primary"></div>').append(newForm);
  $collectionHolder.append($newFormDiv);
}

$(document).ready(() => {
  const $collectionHolder = $('div.opening-hours');

  $collectionHolder.data('index', $collectionHolder.find('input').length);

  $('body').on('click', '.add-opening-hours', (e) => {
    const $collectionHolderClass = $(e.currentTarget).data('collectionHolderClass');
    addFormToCollection($collectionHolderClass);
  });

  $collectionHolder.on('click', '.remove-store-hours-row', function () {
    $(this).parent().parent().remove();
  });
});
