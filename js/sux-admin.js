/**
 * Sux Admin
 * Released Under MIT License
 * Copyright (c) 2016 Fesuy <fesuydev@gmail.com>
 */
(function($, window, document, undefined) {
  var sideScroll,
    navScroll,
    wWidth = $(window).width(),
    wHeight = $(window).height(),
    toInt = parseInt;

  function createScroll() {
    if (typeof sideScroll !== "undefined") {
      sideScroll.destroy();
    }
    sideScroll = new IScroll('.sidebar-nav', {
      scrollbars: (!$('.sidebar').hasClass('sidebar-collapse') && wWidth > 991),
      mouseWheel: true
    });
    sideScroll.refresh();
  }

  function refreshSidebar() {
    if (typeof sideScroll !== "undefined") {
      sideScroll.refresh();
    }
  }

  var fnResize = function() {
    wWidth = $(window).width(),
    wHeight = $(window).height();
    removeActiveSidebar();
    createScroll();

    if (wWidth >= 768) {
      $('body').removeClass('open-sidebar');
    }
  };

  function removeActiveSidebar() {
    $('.sidebar-menu li').removeClass('active');
    $('.sidebar-submenu').removeClass('in');
  }

  var hideSearch = function() {
    $('.form-search-collapse').collapse('hide');
  }

  $(window).resize(fnResize);

  $(document).ready(function() {
    createScroll();
    $('.sidebar-menu').metisMenu();
  });

  $('.search-toggle').click(function(e) {
    e.preventDefault();
  });
  $('.form-search-collapse').on('shown.bs.collapse', function() {
    if ($('body').hasClass('open-sidebar')) {
      $('body').toggleClass('open-sidebar');
    }
    if ($(this).find('.close-search').length > 0) return;
    $(this).append($('<span class="fa fa-close close-search"></span>'));
  });

  $(document).on('click', '.close-search', hideSearch);

  $('[data-toggle="sidebar-collapse"]').click(function(e) {
    e.preventDefault();
    if (wWidth > 991) {
      var anim = $('.navbar-top, .sidebar, .content-wrapper');
      anim.addClass('sidebar-collapsed')
        .toggleClass('sidebar-collapse');
      // Simulating transition end
      setTimeout(function() {
        if (anim.hasClass('sidebar-collapsed') && !anim.hasClass('sidebar-collapse')) {
          anim.removeClass('sidebar-collapsed');
        }
      }, 200);
    } else if (wWidth < 768) {
      $('body').toggleClass('open-sidebar');
    }
    removeActiveSidebar()
    createScroll();
  });

  var navDropdownUtil = function() {
    if (wWidth > 767) return;
    var dropdown = $(this).find('.dropdown-menu'),
      toggle = $(this).find('.dropdown-toggle');
    if (dropdown.find('.dropdown-title').length <= 0) {
      var text = toggle.attr('title') || toggle.data('title') || $.trim(toggle.text());
      // toggle.title(text);
      var el = [
        '<div class="mobile-nav-dropdown">',
        '<span class="close-dropdown">&times;</span>',
        '<li class="dropdown-title">' + text + '</li>',
        '</div>'
      ].join('');
      dropdown.prepend($(el));
    }
    $('body').toggleClass('modal-open', $('.dropdown-nav').hasClass('open'));
  }

  $('.dropdown-nav').on('shown.bs.dropdown', navDropdownUtil)
    .on('hidden.bs.dropdown', navDropdownUtil);

  $('.sidebar-menu li > a').click(function(e) {
    var subMenu = $(this).next();

    if (subMenu.length > 0) {
     e.preventDefault();
     if (subMenu.find('.submenu-first').length > 0) return;
      var txt = $(this).attr('title') || $(this).data('title') || $(this).text();
      var el = $('<li class="submenu-first">' + $.trim(txt) + '</li>');
      subMenu.prepend(el);
    }

  });

  $('.sidebar-menu').on('shown.metisMenu', function(e) {
    var subMenu = $(e.target);
    if (($('.sidebar').hasClass('sidebar-collapse') || wWidth < 991) && subMenu.length > 0) {
      var subMenuH = subMenu.height(),
          y = e.target.offsetParent.offsetTop;
      var impactPos = ($(window).height() - (y + subMenu.height())) > 50 ? { top: 0, bottom: 'auto' } : { top: 'auto', bottom: 0 };
      if( subMenu.css('top') != impactPos.top) {
        subMenu.css(impactPos);
      }
    }
    refreshSidebar();
  }).on('hidden.metisMenu', refreshSidebar);

  $('[data-toggle="tooltip"]').tooltip();
  $('[data-toggle="popover"]').popover();

})(jQuery, window, document);
