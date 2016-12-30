/* global PhotoSwipe PhotoSwipeUI_Default*/
'use strict';
(function () {
  $(document).ready(function () {


    function loadGallery(picasaid, authkey) {

      var requestUrl = 'https://photos.googleapis.com/data/feed/api/user/germinton/albumid/';
      requestUrl += picasaid;

      $.get({
        url: requestUrl,
        data: {
          alt: 'json',
          authkey: authkey,
          thumbsize: '75c,1600u',
          imgmax: 'd'
        }
      }).done(function (result) {
        var thumburl;
        var elements = $();
        var items = [];
        var mediacontent;
        var mediacontenturl;
        //var title;
        //var maxViewPortSize = Math.max($(window).width(), $(window).height());
        var index = 0;
        result.feed.entry.forEach(function (entry) {
          //title = entry.title.$t;
          thumburl = entry.media$group.media$thumbnail[0].url;
          elements = elements.add('<div><img class="thumbimage" data-index="' +
            index++ + '" data-lazy="' + thumburl + '"></div>');
          mediacontent = entry.media$group.media$thumbnail[1];
          mediacontenturl = mediacontent.url;
          //mediacontenturl = mediacontenturl.replace(title, '');
          //mediacontenturl += 'w' + maxViewPortSize + '/' + title;
          items.push({
            src: mediacontenturl,
            downloadsrc: entry.media$group.media$content[0].url,
            w: mediacontent.width,
            h: mediacontent.height
          });
        });
        $('.gallery').append(elements);
        $('.gallery').slick({
          infinite: false,
          arrows: true,
          dots: true,
          slidesToShow: 8,
          slidesToScroll: 8,
          lazyLoad: 'ondemand'
        });

        $('.gallery .thumbimage').click(function (e) {
          var index = parseInt($(e.currentTarget).data('index'), 10);

          var pswpElement = document.querySelectorAll('.pswp')[0];
          var pswp;
          // define options (if needed)
          var options = {
            // history & focus options are disabled on CodePen
            history: false,
            focus: false,
            index: index,
            shareButtons: [{
              id: 'download',
              label: 'Download',
              url: '{{raw_image_url}}',
              download: true
            }],
            getImageURLForShare: function (shareButtonData) {
              // `shareButtonData` - object from shareButtons array
              //
              // `pswp` is the gallery instance object,
              // you should define it by yourself
              //
              return pswp.currItem.downloadsrc || pswp.currItem.src;
            }
          };

          pswp = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
          pswp.init();
          var fsApi = pswp.ui.getFullscreenAPI();
          if (fsApi) {
            fsApi.enter();
          }
          var $playElement = $('.pswp__button--play');
          var playTimer;
          $playElement.bind('touchstart click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $playElement.toggleClass('playing');

            if ($playElement.hasClass('playing')) {
              playTimer = window.setInterval(function () {
                pswp.next();
              }, 3000);
            } else {
              window.clearInterval(playTimer);
            }
          });
          // Gallery starts closing
          pswp.listen('close', function () {
            var index = this.getCurrentIndex();
            $('.gallery').slick('slickGoTo', index, true);
          });
        });
      });
    }




    loadGallery('6300842604393698561', 'Gv1sRgCO6Pl86BqoiB2AE');

  });
}());
