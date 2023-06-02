document.addEventListener("DOMContentLoaded", () => {
    Fancybox.bind("[data-fancybox]", {});
    Fancybox.bind("img.data-fancybox", {});
    Fancybox.bind(".data-fancybox img", {});
    $('.alert-click-hide').on('click', function() {
        $(this).fadeOut();
    });
});