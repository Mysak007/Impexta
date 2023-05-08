import $ from 'jquery';

require('simplelightbox/dist/simple-lightbox.min.css');
require('simplelightbox/dist/simple-lightbox.min');

function addFormToCollection($collectionHolderClass) {
  const $collectionHolder = $(`.${$collectionHolderClass}`);
  const prototype = $collectionHolder.data('prototype');
  const index = $collectionHolder.data('index');
  let newForm = prototype;
  newForm = newForm.replace(/__name__/g, index);
  $collectionHolder.data('index', index + 1);
  const $newFormDiv = $('<div></div>').append(newForm);
  $collectionHolder.append($newFormDiv);
}

$(document).ready(() => {
  const $collectionHolder = $('.business-case-images');
  const $collectionFileHolder = $('.business-case-files');
  // eslint-disable-next-line
  new SimpleLightbox('.gallery a', { loop: true, overlay: true });

  $collectionHolder.data('index', $collectionHolder.find('input').length);

  $('body').on('click', '.add-images-row', (e) => {
    const $collectionHolderClass = $(e.currentTarget).data('collectionHolderClass');
    addFormToCollection($collectionHolderClass);
  });

  $('.add-files-row').on('click', (e) => {
    const $collectionHolderClass = $(e.currentTarget).data('collectionHolderClass');
    addFormToCollection($collectionHolderClass);
  });

  $collectionHolder.on('click', '.remove-image-row', function () {
    $(this).parent().parent().remove();
  });
  $collectionFileHolder.on('click', '.remove-file-row', function () {
    $(this).parent().parent().remove();
  });
});
