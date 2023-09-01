$.validator.addMethod("pattern", function (value, element, pattern) {
    if (pattern instanceof RegExp) {
        return pattern.test(value);
    } else {
        return false;
    }
}, "Invalid format.");

$("#loginForm").validate({
    errorElement: "span",
    rules: {
        // email: {
        //     required: true,
        //     pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        // },
        user_name: {
            required: true
        },
        password: {
            required: true,
            // pattern: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z\d]{8,}$/,
        }
    },
    messages: {
        // email: {
        //     required: "Please enter email address",
        //     pattern: "Please enter a valid email address",
        // },
        user_name: {
            required: "Please enter username"
        },
        password: {
            required: "Please enter password",
            // pattern: "Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, and one number",
        }
    }
});

$("#passIcon").on("click", function () {
    var passwordInput = $("#password");
    if (passwordInput.attr("type") === "password") {
        passwordInput.attr("type", "text");
    } else {
        passwordInput.attr("type", "password");
    }
    $("#passIcon iconify-icon").toggle();
});
