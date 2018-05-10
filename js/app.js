$(function () {

  $(document).on('click', '.btn-add-image', function(e) {
    e.preventDefault();
    var $this = $(this);

    var $template = $('.app-img-upload').first(),
        $clone = $template.clone();
    $clone.find('.btn-control')
          .attr('class', 'btn btn-control btn-success form-control btn-add-image')
          .html('<span class="fa fa-plus"></span>');

    $clone.find('img')
          .attr('src', 'http://localhost/ecommerce/public/img/no-thumbnail.jpg');

    $clone.find('.des')
          .val('');

    $this.attr('class', 'btn btn-control btn-danger form-control btn-delete-image')
         .html('<span class="fa fa-trash"></span>');

    $('.app-img').append($clone);
  });

  $(document).on('click', '.btn-delete-image', function(e) {
    e.preventDefault();
    var $this = $(this);
    var $parent = $this.parent().parent().parent();
    $parent.remove();
  });

  $.getFileExtension = function(filename) {
    var ext = /^.+\.([^.]+)$/.exec(filename);
    return ext == null ? "" : ext[1];
  }

  $(document).on('change', '.img-app', function() {
    var file = this.files[0],
        $this = $(this);
        $parent = $this.parent('.image');
    if(file) {
      var reader = new FileReader();
      var ext = $.getFileExtension(file.name);
      ext = ext.toLowerCase();
      console.log(file);
      var except = ['jpg','jpeg','png','gif']

      if(except.indexOf(ext) == -1) {
          alert('File harus berextensi ' + except.join(', '));
          file = undefined;
          return ;
      } else if(file.size > 2000000) {
          alert('Ukuran gambar lebih dari 2MB');
          file = undefined;
          return ;
      }

      if(file) {
        reader.onload = function(e) {
          var result = e.target.result;
          $parent.find('img').attr('src', file ? result : '');
        }
        reader.readAsDataURL(file);
      }
    }
  });

  $(document).on('change', '.app-ico', function() {
    var file = this.files[0],
        $this = $(this);
        $parent = $this.parent('.image');
    if(file) {
      var reader = new FileReader();
      var ext = $.getFileExtension(file.name);
      ext = ext.toLowerCase();
      console.log(file);
      var except = ['jpg','jpeg','png','gif']

      if(except.indexOf(ext) == -1) {
          alert('File harus berextensi ' + except.join(', '));
          file = undefined;
          return ;
      } else if(file.size > 2000000) {
          alert('Ukuran gambar lebih dari 2MB');
          file = undefined;
          return ;
      }

      if(file) {
        reader.onload = function(e) {
          var result = e.target.result;
          $parent.find('img').attr('src', file ? result : '');
        }
        reader.readAsDataURL(file);
      }
    }
  });

  $(document).on('change', '.app-andro', function() {
    var file = this.files[0],
        $this = $(this);
        $parent = $this.parent('.image');
    if(file) {
      var reader = new FileReader();
      var ext = $.getFileExtension(file.name);
      ext = ext.toLowerCase();
      var except = ['apk'];

      if(except.indexOf(ext) == -1) {
          alert('File harus berextensi ' + except.join(', '));
          file = undefined;
          return;
      } else if(file.size > 3000000) {
          alert('Ukuran gambar lebih dari 2MB');
          file = undefined;
          return;
      }
      if(file) {
        $parent.find('img').attr('src', DOMAIN_APP + "/img/app/check-app.png");
      }
    }
  });

  $(document).on('change', '.app-pdf', function() {
    var file = this.files[0],
        $this = $(this);
        $parent = $this.parent('.image');
    if(file) {
      var reader = new FileReader();
      var ext = $.getFileExtension(file.name);
      ext = ext.toLowerCase();
      var except = ['pdf'];

      if(except.indexOf(ext) == -1) {
          alert('File harus berextensi ' + except.join(', '));
          file = undefined;
          return;
      } else if(file.size > 3000000) {
          alert('Ukuran gambar lebih dari 2MB');
          file = undefined;
          return;
      }
      if(file) {
        $parent.find('img').attr('src', DOMAIN_APP + "/img/app/check-pdf.png");
      }
    }
  });
});