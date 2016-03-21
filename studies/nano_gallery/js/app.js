'use strict';
(function () {
  $(document).ready(function () {
    var nanoGallerySettings = {
      kind: 'picasa',
      userID: 'germinton',
      album: '6258722297616112449&authkey=Gv1sRgCLzTo5_dobmcOw',
      paginationMaxLinesPerPage: 1,
      //thumbnailAlignment: 'justified',
      thumbnailWidth: '72C',
      thumbnailHeight: '72C',
      thumbnailLabel: {
        display: false
      },

      theme: 'clean'
    };
    $('.nanogallery').nanoGallery(nanoGallerySettings);
  });
}());
