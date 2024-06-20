
        document.addEventListener("DOMContentLoaded", function() {
            // Function to change content based on navigation
            function changeContent(page) {
                var allContent = document.querySelectorAll(".content > div");
                allContent.forEach(function(item) {
                    item.style.display = "none";
                });
                document.getElementById(page + "Content").style.display = "block";
            }

            // Toggle between content based on navigation bar
            document.querySelectorAll(".menu ul li a").forEach(function(link) {
                link.addEventListener("click", function(event) {
                    event.preventDefault();
                    var page = this.innerHTML.toLowerCase();
                    changeContent(page);
                });
            });

            // Automatically change content based on the active image in the slider
            var sliderImages = document.querySelectorAll(".slider img");
            sliderImages.forEach(function(image, index) {
                image.addEventListener("animationiteration", function() {
                    var currentPage = document.querySelector(".menu ul li a.active").innerHTML.toLowerCase();
                    var newIndex = index % 5; // Assuming there are 5 images in the slider
                    var page = "";
                    switch (newIndex) {
                        case 0:
                            page = "home";
                            break;
                        case 1:
                            page = "events";
                            break;
                        case 2:
                            page = "services";
                            break;
                        case 3:
                            page = "gallery";
                            break;
                        case 4:
                            page = "contact";
                            break;
                        default:
                            page = "about";
                            break;
                    }
                    changeContent(page);
                });
            });

            // Login form submission logic
            document.getElementById("loginForm").addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent form submission
                var email = this.querySelector('input[name="email"]').value;
                var password = this.querySelector('input[name="password"]').value;

                console.log("Email:", email);
                console.log("Password:", password);
            });

            // Registration form submission logic
            document.getElementById("registerForm").addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent form submission
                var email = this.querySelector('input[name="email"]').value;
                var username = this.querySelector('input[name="username"]').value;
                var name = this.querySelector('input[name="name"]').value;
                var password = this.querySelector('input[name="password"]').value;
                var confirmPassword = this.querySelector('input[name="confirmPassword"]').value;
                // Here you can perform registration validation and submission
                // For simplicity, let's just log the form data to the console
                console.log("Email:", email);
                console.log("Username:", username);
                console.log("Name:", name);
                console.log("Password:", password);
                console.log("Confirm Password:", confirmPassword);
            });

            // Forgot password form submission logic
            document.getElementById("forgotPasswordForm").addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent form submission
                var email = this.querySelector('input[name="email"]').value;
                // Here you can implement logic for sending a password reset email
                // For simplicity, let's just log the email to the console
                console.log("Forgot Password Email:", email);
            });

            // Toggle between login, registration, and forgot password forms
            document.getElementById("loginBtn").addEventListener("click", function() {
                showForm("loginForm");
            });

            document.getElementById("registerBtn").addEventListener("click", function() {
                showForm("registerForm");
            });

            document.getElementById("forgotPasswordBtn").addEventListener("click", function() {
                showForm("forgotPasswordForm");
            });

            function showForm(formId) {
                var forms = document.querySelectorAll(".section-w3ls");
                forms.forEach(function(form) {
                    form.classList.remove("active");
                });
                document.getElementById(formId).classList.add("active");
            }
        });
   