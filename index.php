
<?php 

session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Lanka</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* General styles for body and html */
        body, html {
            margin: 0;
            padding: 0;
            font-family: "Inter-Regular", Helvetica, Arial, sans-serif;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        /* Styles for anchor tags */
        a {
            color: #ffffff;
            text-decoration: none;
            background-color: #521485;
        }
        a:hover {
            color: rgb(253, 253, 3);
            text-decoration: none;
        }
        /* Styles for the main container */
        .index {
            background-color: #ffffff;
            width: 100%;
            height: 100%;
        }
        /* Wrapper for overlapping elements */
        .overlap-wrapper {
            background-color: #ffffff;
            height: 100vh;
            width: 100%;
            overflow: hidden;
            position: relative;
        }
        /* Overlapping container */
        .overlap {
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            width: 100%;
        }
        /* Background image styles */
        .background-image {
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            width: 100%;
            transition: opacity 1s;
        }
        /* Opacity overlay */
        .opacity {
            background-color: rgba(67, 66, 66, 0.75);
            height: 100%;
            position: absolute;
            top: 0;
            width: 100%;
        }
        /* Header styles */
        .header {
            align-items: center;
            background-color: #521485;
            display: flex;
            height: 80px;
            justify-content: space-between;
            padding: 0 16px;
            position: relative;
            width: 100%;
            z-index: 10;
        }
        /* Navigation styles */
        .header .nav-left {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-right: auto;
        }
        .header .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-left: auto;
            padding-right: 20px;
        }
        .header .nav-left img {
            height: 40px;
        }
        .header .nav-left .company-name {
            font-family: "Poppins-Bold", Helvetica;
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
        }
        .header .nav-left a {
            color: #ffffff;
            font-size: 16px;
            text-decoration: none;
        }
        /* Search input styles */
        .element-search-input {
            align-items: center;
            background-color: #ffffff;
            border: 1px solid #dfdfdf;
            border-radius: 8px;
            display: flex;
            gap: 8px; /* Reduced gap */
            padding: 4px 8px; /* Reduced padding */
        }
        .element-search-input input {
            border: none;
            outline: none;
            width: 100%;
        }
        .search-button {
            background-color: transparent;
            border: none;
            color: #bd4a4a;
            cursor: pointer;
            padding: 0;
            font-size: 16px; /* Reduced font size */
        }
        /* Avatar styles */
        .avatar {
            background-color: #f7f7f7;
            border-radius: 50%;
            height: 48px; /* Reduced height */
            width: 48px; /* Reduced width */
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .avatar i {
            font-size: 24px; /* Reduced font size */
            color: #521485;
        }
        /* Login/Register form styles */
        .login-register-form {
            background-color: #ffffff;
            border: 1px solid #dfdfdf;
            border-radius: 8px;
            display: none;
            padding: 20px;
            position: absolute;
            right: 20px;
            top: 90px;
            width: 300px;
            z-index: 10;
            max-height: 80vh;
            overflow-y: auto;
        }
        .login-register-form h3 {
            font-family: "Poppins-Bold", Helvetica;
            font-size: 18px;
            margin: 0 0 10px 0;
        }
        .login-register-form label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .login-register-form input[type="text"],
        .login-register-form input[type="password"],
        .login-register-form input[type="email"],
        .login-register-form input[type="file"] {
            border: 1px solid #dfdfdf;
            border-radius: 4px;
            padding: 8px;
            width: 100%;
            margin-bottom: 10px;
        }
        .login-register-form button {
            background-color: #bd4a4a;
            border: none;
            border-radius: 4px;
            color: #ffffff;
            cursor: pointer;
            font-size: 14px;
            padding: 10px;
            width: 100%;
        }
        .login-register-form button:hover {
            background-color: #a33a3a;
            color: white;
        }
/*        .login-register-form login:hover {
            background-color:red;
          
        }*/
        
        .links {
            
                background-color: #bd4a4a;
            border: none;
            border-radius: 4px;
/*            color: #ffffff;*/
            cursor: pointer;
            font-size: 14px;
            padding: 10px;
            width: 100%;
            text-align: center;
        }
        .login-register-form .forgot-password,
        .login-register-form .register,
        .login-register-form .back-to-login {
            background: none;
            border: none;
            color: #0d99ff;
            cursor: pointer;
            font-size: 12px;
            padding: 0;
            text-decoration: underline;
            margin-top: 10px;
        }
        /* Welcome text styles */
        .welcome-to-event {
            color: #ffffff;
            font-family: "Poppins-Bold", Helvetica;
            font-size: 48px;
            font-weight: 700;
            position: absolute;
            text-align: center;
            top: 40%;
            width: 100%;
            z-index: 1;
        }
        .lorem-ipsum-is {
            color: #ffffff;
            font-family: "Poppins-Bold", Helvetica;
            font-size: 14px;
            font-weight: 700;
            position: absolute;
            text-align: center;
            top: 50%;
            width: 50%;
            z-index: 1;
            left: 50%;
            transform: translateX(-50%);
        }
        /* Book now button styles */
        .book-now {
            position: absolute;
            top: 60%;
            width: 200px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1;
        }
        .book-now .overlap-2 {
            height: 45px;
            position: relative;
        }
        .rectangle-2 {
            background-color: #bd4a4a;
            border-radius: 10px;
            height: 42px;
            left: 0;
            position: absolute;
            top: 3px;
            width: 100%;
        }
        .text-wrapper-10 {
            color: #ffffff;
            font-family: "Poppins-Bold", Helvetica;
            font-size: 18px;
            font-weight: 700;
            left: 50%;
            position: absolute;
            text-align: center;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
        }
        /* Slider styles */
        .slider {
            align-items: center;
            bottom: 20px;
            display: flex;
            gap: 20px;
            justify-content: center;
            left: 50%;
            position: absolute;
            transform: translateX(-50%);
            width: 100%;
            z-index: 1;
        }
        .ellipse {
            background-color: #979595;
            border-radius: 50%;
            height: 13px;
            width: 13px;
            cursor: pointer;
        }
        /* Interactive button styles */
        .interactive-button {
            background-color: #bd4a4a;
            border: none;
            border-radius: 4px;
            color: #ffffff;
            cursor: pointer;
            padding: 8px 16px;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .interactive-button:hover {
            background-color: #a33a3a;
          
        }
        /* Hover effect for navigation links */
        .header .nav-right a,
        .header .nav-left a {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .header .nav-right a:hover,
        .header .nav-left a:hover {
            transform: scale(1.1); /* Slight zoom */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow */
        }
        /* Media query for responsive design */
        @media (max-width: 768px) {
            .welcome-to-event {
                font-size: 32px;
            }
            .book-now {
                width: 150px;
            }
            .text-wrapper-10 {
                font-size: 14px;
            }
            .header .nav-right {
                display: none;
            }
            .header .hamburger-menu {
                display: block;
                cursor: pointer;
            }
            .header .hamburger-menu div {
                width: 25px;
                height: 3px;
                background-color: #ffffff;
                margin: 4px 0;
            }
            .header .nav-right.responsive {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 80px;
                right: 0;
                background-color: #ffffff;
                width: 100%;
                padding: 10px;
            }
            .header .nav-right.responsive a {
                padding: 10px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="index">
        <div class="overlap-wrapper">
            <div class="overlap">
                <!-- Background image -->
                <img class="background-image" id="background-image" alt="Background" src="background1.jpg">
                <div class="opacity"></div>
                <!-- Header section -->
                <div class="header">
                    <div class="nav-left">
                        <img src="logo.png" alt="Logo">
                        <span class="company-name">EventLanka</span>
                    </div>
                    <div class="nav-right">
                        <a href="Home.html">Home</a>
                        <a href="#events">Events</a>
                        <a href="#services">Services</a>
                        <a href="#packages">Packages</a>
                        <a href="#about-us">About Us</a>
                        <a href="#contact-us">Contact Us</a>
                        <!-- Search input -->
                        <div class="element-search-input">
                            <input type="text" placeholder="Search">
                            <button class="search-button"><i class="fas fa-search"></i></button>
                        </div>
                        <!-- User avatar -->
                        <div class="avatar" id="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <!-- Hamburger menu for mobile view -->
                    <div class="hamburger-menu" id="hamburger-menu">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
                <!-- Login/Register form -->
                <div class="login-register-form" id="login-register-form">
                    <div class="login-panel" id="login-panel">
                        <h3>Login</h3>
                        <form>
                        <label for="username">Username/Email</label>
                        <input type="text" id="username" name="username">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password">
                        <button type="submit" name="submit">Login</button>
                        </form>
                        <button class="forgot-password" id="forgot-password-button">Forgot Password?</button>
                        <button class="register" id="register-button">Register</button>
                    </div>
                    <div class="forgot-password-panel" id="forgot-password-panel" style="display: none;">
                        <h3>Forgot Password</h3>
                        <label for="recovery-email">Email</label>
                        <input type="email" id="recovery-email" name="recovery-email">
                        <button type="submit" >Send Recovery Email</button>
<!--                      <a href="login.php" class="links" id="" type="submit">Send Recovery Email</a>-->
    
                        <button class="back-to-login" id="back-to-login-1">Back to Login</button>
                    </div>
                    <div class="register-panel" id="register-panel"style="display: none;">
                      <h3>Register</h3>
                      <form action="register.php" method="post" enctype="multipart/form-data">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" required><br>

                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required><br>

                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" required><br>

                            <label for="nic-number">NIC Number</label>
                            <input type="text" id="nic-number" name="nic_number" required><br>

                            <label for="nic-front-photo">NIC Front Photo</label>
                            <input type="file" id="nic-front-photo" name="nic_front_photo" required><br>

                            <label for="nic-back-photo">NIC Back Photo</label>
                            <input type="file" id="nic-back-photo" name="nic_back_photo" required><br>

                            <label for="new-username">Username</label>
                            <input type="text" id="new-username" name="new_username" required><br>

                            <label for="new-password">Password</label>
                            <input type="password" id="new-password" name="new_password" required><br>

                            <button type="submit" name="submit">Register Now</button>
                        
                      <button class="back-to-login" id="back-to-login-2">Back to Login</button>
                  </div>
              </div>
              <!-- Intro text and button -->
              <div class="welcome-to-event" id="intro-text">Welcome to the Event</div>
              <div class="lorem-ipsum-is" id="intro-subtext">Lorem ipsum is simply dummy text of the printing and typesetting industry.</div>
              <div class="book-now" id="intro-button">
                  <div class="overlap-2">
                      <div class="rectangle-2"></div>
                      <a href="#home" class="text-wrapper-10 interactive-button">Book Now</a>
                  </div>
              </div>
              <!-- Slider for images -->
              <div class="slider">
                  <div class="ellipse" onclick="jumpToImage(0)"></div>
                  <div class="ellipse" onclick="jumpToImage(1)"></div>
                  <div class="ellipse" onclick="jumpToImage(2)"></div>
                  <div class="ellipse" onclick="jumpToImage(3)"></div>
                  <div class="ellipse" onclick="jumpToImage(4)"></div>
              </div>
          </div>
      </div>
  </div>
  <script>
      // JavaScript for handling user avatar click and showing login/register form
      const userAvatar = document.getElementById('user-avatar');
      const loginRegisterForm = document.getElementById('login-register-form');
      const loginPanel = document.getElementById('login-panel');
      const forgotPasswordPanel = document.getElementById('forgot-password-panel');
      const registerPanel = document.getElementById('register-panel');
      const forgotPasswordButton = document.getElementById('forgot-password-button');
      const registerButton = document.getElementById('register-button');
      const backToLogin1 = document.getElementById('back-to-login-1');
      const backToLogin2 = document.getElementById('back-to-login-2');
      const hamburgerMenu = document.getElementById('hamburger-menu');
      const navRight = document.querySelector('.nav-right');
      const images = [
          { src: 'images project/Images Project/ch4.jpg', text: 'Welcome to the Event', subtext: 'Lorem ipsum is simply dummy text of the printing and typesetting industry.', button: 'Book Now', link: '#home' },
          { src: 'images project/Images Project/ch6.jpg', text: 'Join Our Events', subtext: 'Discover amazing events happening near you.', button: 'Explore Events', link: '#events' },
          { src: 'images project/Images Project/ev2.jpg', text: 'Our Services', subtext: 'We offer a wide range of services to make your events special.', button: 'View Services', link: '#services' },
          { src: 'images project/Images Project/ev5.jpg', text: 'Exclusive Packages', subtext: 'Get the best deals with our exclusive packages.', button: 'Check Packages', link: '#packages' },
          { src: 'images project/Images Project/pp6.png', text: 'About Us', subtext: 'Learn more about EventLanka and our mission.', button: 'Read More', link: '#about-us' },
      ];
      let currentImageIndex = 0;
      const backgroundImage = document.getElementById('background-image');
      const introText = document.getElementById('intro-text');
      const introSubtext = document.getElementById('intro-subtext');
      const introButtonLink = document.querySelector('.interactive-button');

      // Function to show image based on index
      function showImage(index) {
          backgroundImage.src = images[index].src;
          introText.textContent = images[index].text;
          introSubtext.textContent = images[index].subtext;
          introButtonLink.textContent = images[index].button;
          introButtonLink.href = images[index].link;
          updateSliderIndicator(index);
      }

      // Function to show next image
      function nextImage() {
          currentImageIndex = (currentImageIndex + 1) % images.length;
          showImage(currentImageIndex);
      }

      // Function to jump to a specific image
      function jumpToImage(index) {
          currentImageIndex = index;
          showImage(index);
      }

      // Function to update slider indicator
      function updateSliderIndicator(index) {
          const ellipses = document.querySelectorAll('.ellipse');
          ellipses.forEach((ellipse, i) => {
              if (i === index) {
                  ellipse.style.backgroundColor = '#ffffff';
              } else {
                  ellipse.style.backgroundColor = '#979595';
              }
          });
      }

      // Set interval to automatically change images
      setInterval(nextImage, 5000);

      // Event listener for user avatar click
      userAvatar.addEventListener('click', function () {
          loginRegisterForm.style.display = 'block';
          loginPanel.style.display = 'block';
          forgotPasswordPanel.style.display = 'none';
          registerPanel.style.display = 'none';
      });

      // Event listener to hide login/register form when clicking outside
      document.addEventListener('click', function (event) {
          if (!userAvatar.contains(event.target) && !loginRegisterForm.contains(event.target)) {
              loginRegisterForm.style.display = 'none';
          }
      });

      // Event listener for forgot password button click
      forgotPasswordButton.addEventListener('click', function () {
          loginPanel.style.display = 'none';
          forgotPasswordPanel.style.display = 'block';
      });

      // Event listener for register button click
      registerButton.addEventListener('click', function () {
                loginPanel.style.display = 'none';
                registerPanel.style.display = 'block';
            });

            // Event listener for back to login button click in forgot password panel
            backToLogin1.addEventListener('click', function () {
                forgotPasswordPanel.style.display = 'none';
                loginPanel.style.display = 'block';
            });

            // Event listener for back to login button click in register panel
            backToLogin2.addEventListener('click', function () {
                registerPanel.style.display = 'none';
                loginPanel.style.display = 'block';
            });

            // Event listener for hamburger menu click to toggle responsive navigation
            hamburgerMenu.addEventListener('click', function () {
                navRight.classList.toggle('responsive');
            });

            // Initial call to show the first image
            showImage(currentImageIndex);
        </script>
    </body>
</html>