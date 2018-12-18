require('jquery');
require('croppie');

$(document).ready(() => {
  var $currentProfile = $('#current-avatar');
  var $profilePicPreview = null;
  var profilePicBase64 = null;

  let initCroppie = () => {
    //$profilePicPreview = $('#profile-picture-preview').croppie({
      $profilePicPreview = $('#current-avatar').croppie({

      customClass: "test",
      enableExif: true,
      viewport: {
        width: 220,
        height: 220,
        type: 'square',
      },
      boundary: {
        width: 240,
        height: 240,
      },
    });
  };

  // Let's init croppie to display an empty frame
  initCroppie();
  // Dirty wokraround to remove the alt text
  $profilePicPreview.find('.cr-image').attr('alt', '');

  function readFile(input) {
    if(input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (event) {
        initCroppie();

        $profilePicPreview.croppie('bind', {
          url: event.target.result
        });
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

  $('#profile-picture-upload').on('change', (e) => {
    // If input file was changed
    if(e.target.files.length > 0) {
      // if($currentProfile.length) {
      //   $currentProfile.remove();
      //   $currentProfile = [];
      // }

      if($profilePicPreview !== null) {
        $profilePicPreview.croppie('destroy');
        $profilePicPreview = null;
      }

      readFile(e.target);
    }
  });

  $('#form-restaurant-update').submit((e) => {
    var $form = $(this);

    if ($profilePicPreview) {
      if (!profilePicBase64) {
        //e.preventDefault();

        $profilePicPreview.croppie('result', 'base64').then(value => {
          profilePicBase64 = value;
          $('#avatar').val(value);
          $form.submit();
        });
      }
    }
  });
});
