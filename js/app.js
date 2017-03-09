$(function () {
  $(document).on('click', '.btn-add-image', function(e) {
    e.preventDefault();
    var $this = $(this);

    var $template = $('.produk-img-upload').first(),
        $clone = $template.clone();
    $clone.find('.btn-control')
          .attr('class', 'btn btn-control btn-success form-control btn-add-image')
          .html('<span class="fa fa-plus"></span>');

    $clone.find('img')
          .attr('src',Laravel.baseurl + '/img/no-thumbnail.jpg');

    $clone.find('.des')
          .val('');

    $this.attr('class', 'btn btn-control btn-danger form-control btn-delete-image')
         .html('<span class="fa fa-trash"></span>');

    $('#produk-img').append($clone);
  });

  $(document).on('click', '.btn-delete-image', function(e) {
    e.preventDefault();
    var $this = $(this),
        id = undefined;
    if($this.hasClass('delete-update')) {
      if(confirm('Anda akan menghapus gambar ini?')) {
        id = $this.data('id');
      } else {
        return e.preventDefault();
      }
    }
    var $parent = $this.parent().parent().parent();
    $parent.remove();

    if(typeof id != 'undefined') {
      $.ajax({
        url: Laravel.baseurl + '/api/delete-image',
        type: 'POST',
        data: {
              id:id,
              _token:Laravel.csrfToken
        }
      })
      .fail(function() {
        alert('Terjadi kesalahan!');
      });

    }
  });
});