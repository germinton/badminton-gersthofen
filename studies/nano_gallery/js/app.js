'use strict';
(function () {
  $(document).ready(function () {
    var saved_picasaid,
      saved_authkey;

    function myImgToolbarCustInit(elementName) {
      if (elementName == 'custom1') {
        return '<a class="gallery_image_download" target="new"><i class="fa fa-download fa-2x"></i></a>';
      }
    }

    function myImgToolbarCustDisplay($elements, item, data) {
      var requestUrl = 'https://photos.googleapis.com/data/feed/api/user/germinton/albumid/';
      requestUrl += saved_picasaid;
      requestUrl += '/photoid/';
      requestUrl += item.GetID();

      $.get({
        url: requestUrl,
        data: {
          alt: 'json',
          authkey: saved_authkey
        }
      }).done(function (result) {
        var url = result.feed.media$group.media$content[0].url;
        var title = result.feed.title.$t;
        var width = result.feed.gphoto$width.$t;
        url = url.replace(result.feed.title.$t, '');
        url += 'w' + width + '/' + title;
        $elements.find('.gallery_image_download').attr({
          href: url,
          download: title
        });
      });
    }

    function LoadNanoGallery(picasaid, authkey) {
      saved_picasaid = picasaid;
      saved_authkey = authkey;
      var nanoGallerySettings = {
        kind: 'picasa',
        userID: 'germinton',
        album: saved_picasaid + '&authkey=' + saved_authkey,
        paginationMaxLinesPerPage: 1,
        //thumbnailAlignment: 'justified',
        thumbnailWidth: '72C',
        thumbnailHeight: '72C',
        thumbnailLabel: {
          display: false
        },

        viewerToolbar: {
          autoMinimize: 0,
          standard: 'minimizeButton,previousButton,pageCounter,nextButton,playPauseButton,fullscreenButton,custom1,label'
        },
        fnImgToolbarCustInit: myImgToolbarCustInit,
        fnImgToolbarCustDisplay: myImgToolbarCustDisplay,
        //fnImgToolbarCustClick: myImgToolbarCustClick,

        theme: 'clean'
      };
      $('.nanogallery').nanoGallery(nanoGallerySettings);
    }




    LoadNanoGallery('6258722297616112449', 'Gv1sRgCLzTo5_dobmcOw');

  });
}());
