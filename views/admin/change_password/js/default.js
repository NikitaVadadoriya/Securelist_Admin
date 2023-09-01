$(".passIcon").on("click", function () {

    const passwordInput = $(this).prev('.password');
    if (passwordInput.attr("type") === "password") {
        passwordInput.attr("type", "text");
    } else {
        passwordInput.attr("type", "password");
    }

    $(this).children('iconify-icon').toggle();
});