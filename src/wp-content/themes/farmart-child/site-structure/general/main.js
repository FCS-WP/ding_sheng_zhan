document.addEventListener("DOMContentLoaded", function () {
  // Check if the current page is the home page
  if (!document.body.classList.contains("home")) {
    return; // Exit the script if it's not the home page
  }

  var slides = document.querySelectorAll(".home .n2-ss-slide");
  var lastSlide = slides[slides.length - 1];
  var header = document.querySelector(".home .site-header");

  function checkOverflow() {
    var isActive = lastSlide.classList.contains("n2-ss-slide-active");

    if (isActive) {
      document.documentElement.style.overflow = "auto";
    } else {
      document.documentElement.style.overflow = "hidden";
    }
  }

  function handleScroll() {
    var sliderTop = lastSlide.getBoundingClientRect().top;
    var sliderBottom = lastSlide.getBoundingClientRect().bottom;
    var scrollY = window.scrollY;
    var windowHeight = window.innerHeight;
    // Uncomment if needed for header color change on scroll
    // if (scrollY > 50) {
    //   header.classList.add("header-black");
    // } else {
    //   header.classList.remove("header-black");
    // }

    if (sliderTop !== 0) {
      document.documentElement.style.overflow = "auto";
    } else {
      checkOverflow();
    }
  }

  checkOverflow();
  window.addEventListener("scroll", handleScroll);

  var observer = new MutationObserver(function (mutationsList) {
    mutationsList.forEach(function (mutation) {
      if (
        mutation.type === "attributes" &&
        mutation.attributeName === "class"
      ) {
        checkOverflow();
      }
    });
  });

  if (lastSlide) {
    observer.observe(lastSlide, { attributes: true });
  }
});
window.onscroll = function() {fixHeader()};

function fixHeader() {
    var header = document.querySelector(".fix-menu");
    var sticky = header.offsetTop;
    
    if (window.pageYOffset > sticky) {
        header.classList.add("fixed");
    } else {
        header.classList.remove("fixed");
    }
}


  

jQuery(document).ready(function($) {
    $(document).on('click', '.ajax-pagination', function(e) {
        e.preventDefault();

        var page = $(this).data('page');
        var maxPages = $('#custom-post-pagination').data('max-pages');

        $.ajax({
            url: "/wp-admin/admin-ajax.php",
            type: 'POST',
            data: {
                action: 'load_next_post',
                page: page
            },
            success: function(response) {
                if (response) {
                    $('.custom-post-content').html(response);
                    $('#custom-post-pagination').data('current-page', page);

                    var startPage = Math.max(1, page - 2);
                    var endPage = Math.min(maxPages, page + 2);

                    var paginationHtml = '';
                    if (page > 1) {
                        paginationHtml += '<button class="ajax-pagination" data-page="' + (page - 1) + '"><img width="18" height="18" src="/wp-content/uploads/2024/08/left-chevron.png" /></button>';
                    }

                    for (var i = startPage; i <= endPage; i++) {
                        paginationHtml += '<button class="ajax-pagination ' + (i == page ? 'active' : '') + '" data-page="' + i + '">' + i + '</button>';
                    }

                    if (page < maxPages) {
                        paginationHtml += '<button class="ajax-pagination" data-page="' + (page + 1) + '"><img width="18" height="18" src="/wp-content/uploads/2024/08/chevron.png" /></button>';
                    }

                    $('.pagination').html(paginationHtml);
                }
            }
        });
    });
});
