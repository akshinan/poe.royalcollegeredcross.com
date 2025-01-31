<?php
session_start();

ini_set('session.cookie_secure', true);
ini_set('session.cookie_httponly', true);
ini_set('session.use_strict_mode', true);
session_regenerate_id(true);

$config = require 'config.php';
$conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("Service unavailable. Please try again later.");
}

function logUserActivity($conn) {
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $deviceInfo = getDeviceInfo();
    $geolocation = getGeolocation($ipAddress);
    $referralSource = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'Direct';
    $browserInfo = $_SERVER['HTTP_USER_AGENT'];
    $screenResolution = isset($_POST['screen_resolution']) ? $_POST['screen_resolution'] : 'Unknown';
    $operatingSystem = php_uname('s');
    $languagePreferences = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

    $clickPatterns = 'To be captured via JavaScript';
    $scrollDepth = 'To be captured via JavaScript';
    $conversionData = 'To be defined';
    $utmParameters = isset($_POST['utm_parameters']) ? $_POST['utm_parameters'] : 'None';
    $heatmapData = 'To be captured via tools like Hotjar';
    $sessionReplay = 'To be captured via tools like Hotjar';

    $stmt = $conn->prepare("INSERT INTO user_activity_logs_poe (
        ip_address, device_info, geolocation, referral_source, browser_info,
        screen_resolution, operating_system, language_preferences, click_patterns,
        scroll_depth, conversion_data, utm_parameters, heatmap_data, session_replay
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("ssssssssssssss", $ipAddress, $deviceInfo, $geolocation, $referralSource, $browserInfo, $screenResolution, $operatingSystem, $languagePreferences, $clickPatterns, $scrollDepth, $conversionData, $utmParameters, $heatmapData, $sessionReplay);
    $stmt->execute();
    $stmt->close();
}

function getDeviceInfo() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match('/mobile/i', $userAgent)) {
        return 'Mobile';
    } elseif (preg_match('/tablet/i', $userAgent)) {
        return 'Tablet';
    } else {
        return 'Desktop';
    }
}

function getGeolocation($ipAddress) {
    $apiUrl = "http://ip-api.com/json/$ipAddress";
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    if ($data['status'] === 'success') {
        return $data['city'] . ', ' . $data['country'];
    }
    return 'Unknown';
}

logUserActivity($conn);

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="images/poe.png">

  <meta name="description" content="" />
  <meta name="keywords" content="" />

  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">

  <link rel="stylesheet" href="css/jquery.fancybox.min.css">

  <link rel="stylesheet" href="css/bootstrap-datepicker.css">

  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

  <link rel="stylesheet" href="css/aos.css">

  <link rel="stylesheet" href="css/style.css">
	
  <link rel="stylesheet" href="css/mobile.css"> 	

  <title>Project Orange Elephant</title>
  
</head>
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

  <div class="site-wrap">

    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
	  </div>

    <div class="top-bar py-2" id="home-section">
      <div class="container">
        <div class="row">
          <div class="col-md-6 text-center text-lg-right order-lg-2">
            <ul class="social-media m-0 p-0">

            </ul>
          </div>
          <div class="col-md-6 text-center text-lg-left order-lg-1">
            <p class="mb-0 d-inline-flex">
            </p>
          </div>

        </div>
      </div> 
    </div>

    <header class="site-navbar py-4 js-sticky-header site-navbar-target" role="banner">

      <div class="container">
        <div class="row align-items-center">

          <div class="col-11 col-xl-2">
            <h1 class="mb-0 site-logo">
              <a href="index.html" class="mb-0 d-flex align-items-center">
                <img src="images/poe-rcrcs (2).png" alt="First Logo" style="height:65px;" style="width:auto;">
              </a>
            </h1>
          </div>
          
          
          
          <div class="col-12 col-md-10 d-none d-xl-block">
            <nav class="site-navigation position-relative text-right" role="navigation">

            </nav>
          </div>
        </div>
      </div>
      
    </header>

	<div class="content-desktop">
    <div class="particlehead"></div>
      <div class="site-blocks-cover">
        <div class="container">
          <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-12" data-aos="fade-up" data-aos-delay="400">
              <div class="row justify-content-center mb-4">
                <div class="col-md-10 text-center">
                  <h1>Help us end the <span class="typed-words"></span></h1>
                  <p class="lead mb-5"><a href="">Your support can help end the human-elephant conflict in Sri Lanka. Through Project Orange Elephant, we're creating a natural solution that protects both lives and livelihoods, reducing confrontations between people and elephants. But we can't do it alone. Join us in building a future where communities and wildlife live in harmony.</a></p>
                  <div><a href="https://buymeacoffee.com/projectorangeelephant" class="btn btn-primary btn-md">Donate</a>
					</div>
                </div>
              </div>
            </div>
          </div>
        </div>
		  </div>
	</div>
		
		
	<div class="content-mobile">
    <div class="particlehead"></div>
      <div class="site-blocks-cover">
        <div class="container">
          <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-12" data-aos="fade-up" data-aos-delay="400">
              <div class="row justify-content-center mb-4">
                <div class="col-md-10 text-center">
                  <h1>Help us end the <span class="typed-words">CONFLICT</span></h1>
                  <p class="lead mb-5"><a href="https://www.slwcs.org/project-orange-elephant">Your support can help end the human-elephant conflict in Sri Lanka...</a></p>
                  <div><a href="https://buymeacoffee.com/projectorangeelephant" class="btn btn-primary btn-md">Donate</a>
					</div>
                </div>
              </div>
            </div>
          </div>
        </div>
	</div>
	</div>	


		
      
      <br>
      <div class="site-section" id="about-section">
        <div class="container">
          <div class="row mb-5">

            <div class="col-md-5 ml-auto mb-5 order-md-2"  data-jarallax-element="50">
              <img src="images/poe (9).webp" alt="Image" class="img-fluid rounded">
            </div>
            <div class="col-md-6 order-md-1"  data-jarallax-element="-50">

              <div class="row">

                <div class="col-12">
                  <div class="text-justify pb-1">
                    <h2 class="site-section-heading">Introduction</h2>
                  </div>
                </div>
                <div class="col-12 mb-4">
                  <p class="lead">Project Orange Elephant is a pioneering conservation initiative by the Sri Lanka Wildlife Conservation Society (SLWCS) aimed at reducing the human-elephant conflict in Sri Lanka. By using citrus trees as a natural deterrent, we work to keep elephants away from farming villages, promoting a peaceful coexistence between local communities and wildlife.</p>
                </div>
                <div class="col-md-12 mb-md-5 mb-0 col-lg-6">
                  <div class="unit-4">
                    <div>
                      <h3>Mission</h3>
                      <p>To create a sustainable and harmonious environment where humans and elephants can coexist, safeguarding both wildlife and livelihoods.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>
            </div>
            </div>
	  </div>


	<div class="content-desktop">
      <section class="site-section">
        <div class="container">
          <div class="row">
            <div class="col" data-aos="fade-in" data-aos-delay="0">
              <img src="images/poe (1).webp" alt="Image" class="img-fluid rounded">
            </div>
            <div class="col" data-aos="fade-in" data-aos-delay="100">
              <img src="images/poe (2).webp" alt="Image" class="img-fluid rounded">
            </div>
            <div class="col" data-aos="fade-in" data-aos-delay="200">
              <img src="images/poe (3).webp" alt="Image" class="img-fluid rounded">
            </div>

          </div>
        </div>
      </section>
	</div>
	
	
	<div class="content-mobile">
		<section class="site-section">
        <div class="container">
          <div class="row">
            <div class="col" data-aos="fade-in" data-aos-delay="0">
              <img src="images/poe (1).webp" alt="Image" class="img-fluid rounded">
            </div>
			  </div>
          </div>
			<br>
			  <div class="container">
          <div class="row">
            <div class="col" data-aos="fade-in" data-aos-delay="100">
              <img src="images/poe (2).webp" alt="Image" class="img-fluid rounded">
            </div>
			  </div>
          </div>
			<br>
			  <div class="container">
          <div class="row">
            <div class="col" data-aos="fade-in" data-aos-delay="200">
              <img src="images/poe (3).webp" alt="Image" class="img-fluid rounded">
            </div>
          </div>
        </div>
      </section>
	</div>	


      <section class="site-section">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-lg-4 mb-lg-0 mb-4">
              <div class="box-with-humber bg-white p-5">
                <h2 class="text-primary">Donate</h2>
                <p class="mb-4">Your contributions help us expand Project Orange Elephant to more villages, securing a safer future for people and elephants.</p>
              </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-lg-0 mb-4" data-jarallax-element="-50">
              <div class="box-with-humber bg-white p-5">
                <h2 class="text-primary">Join Us</h2>
                <p class="mb-4">Royal College Red Cross members can join Project Orange Elephant to help plant citrus trees, raise awareness, and work with local farmers on sustainable practices.</p>
              </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-lg-0 mb-4" data-jarallax-element="20">
              <div class="box-with-humber bg-white p-5">
                <h2 class="text-primary">Spread the Word</h2>
                <p class="mb-4">Help us raise awareness about human-elephant conflict and the importance of conservation in Sri Lanka.</p>
              </div>
            </div>
          </div>
        </div>
      </section>


      <div class="site-section border-bottom" id="team-section">
      </div>
      <footer class="ftco-footer ftco-bg-dark ftco-section">
        <div class="container text-center">
            <div class="col-md">
                <div class="ftco-footer-widget mb-4">
                    <ul class="ftco-footer-social list-unstyled mt-3">
                          <li class="ftco-animate d-inline-block"><a href="https://www.facebook.com/rcrcs.org?_rdc=1&_rdr" target="_blank"><span class="icon-facebook"></span></a></li>
                          <li class="ftco-animate d-inline-block"><a href="https://www.twitter.com/RCRed_Cross/" target="_blank"><span class="icon-twitter"></span></a></li>
                          <li class="ftco-animate d-inline-block"><a href="https://www.instagram.com/projectorangeelephant/" target="_blank"><span class="icon-instagram"></span></a></li>
                          <li class="ftco-animate d-inline-block"><a href="https://www.youtube.com/@RoyalCollegeRedCrossSociety" target="_blank"><span class="icon-youtube"></span></a></li>
                      <li class="ftco-animate d-inline-block"><a href="https://www.linkedin.com/company/rcredcross/" target="_blank"><span class="icon-linkedin"></span></a></li>
                    </ul>
                    <h2 style="font-family: 'Garamond', serif;">Royal College Red Cross Society</h2>
                    <p>© 2025 Project Orange Elephant | Royal College Red Cross Society</p>
                    <a href="https://royalcollegeredcross.com/acknowledgements" style="font-family: 'Garamond', serif;">BUILT BY BOYS IN THE SCHOOL</a>
                </div>
            </div>
        </div>
      </footer>

    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/bootstrap-datepicker.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script src="js/jarallax.min.js"></script>
    <script src="js/jarallax-element.min.js"></script>
    <script src="js/lozad.min.js"></script>
    <script src="js/modernizr.min.js"></script>
    <script src="js/three.min.js"></script>
    <script src="js/TweenMax.min.js"></script>
    <script src="js/OBJLoader.js"></script>
    <script src="js/ParticleHead.js"></script>
    <script src="js/mobile.js"></script>

    <script src="js/jquery.sticky.js"></script>

    <script src="js/typed.js"></script>
    <script>
      var typed = new Typed('.typed-words', {
        strings: ["Conflict","struggle","disruption"],
        typeSpeed: 80,
        backSpeed: 80,
        backDelay: 1000,
        startDelay: 500,
        loop: true,
        showCursor: true
      });
    </script>
    <script src="js/main.js"></script>

  </body>
  </html>
