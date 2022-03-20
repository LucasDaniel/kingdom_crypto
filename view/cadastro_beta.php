<?php  ?>
<body class="hold-transition login-page background_index">
    <?php require_once("menu.php"); ?>

    <!-- Inicio slideshow -->
    <!-- Slideshow container -->
    <div class="slideshow-container">

        <!-- Full-width images with number and caption text -->
        <div class="mySlides fade">
            <img src="resources/images/back1.png" style="width:1043px">
            <div class="text">1 / 3</div>
        </div>

        <div class="mySlides fade">
            <img src="resources/images/back2.png" style="width:1043px">
            <div class="text">2 / 3</div>
        </div>

        <div class="mySlides fade">
            <img src="resources/images/back3.png" style="width:1043px">
            <div class="text">3 / 3</div>
        </div>
    </div>
    <br>

  <!-- The dots/circles -->
  <div style="text-align:center; display:none;">
      <span class="dot" onclick="currentSlide(1)"></span>
      <span class="dot" onclick="currentSlide(2)"></span>
      <span class="dot" onclick="currentSlide(3)"></span>
  </div>

  <!-- Fim slideshow -->

    <div class="beta_test row">
        <div class="col-12">
            <div class="login-logo t_white">
                Game Play
            </div>
            <img src="resources/images/all_game.png" style="width:1000px">
        </div>
    </div>
    <div class="beta_test row">
      <div class="col-12">
          <div class="login-box">
              <div class="login-logo t_white">
                  Sign up for the beta test
              </div>
              <div class="card">
                  <div class="card-body login-card-body">
                  <p class="login-box-msg"><?php echo $DICIONARIO['discovery_project'] ?></p>
                      <p class="login-box-msg"><?php echo $DICIONARIO['beta_register'] ?></p>
                      <form action="https://kingrespectcrypto.com/controller/envio_email.php" method="post">
                          <div class="input-group mb-3">
                              <input type="email" name="email" class="form-control" placeholder="<?php echo $DICIONARIO['email'] ?>">
                              <div class="input-group-append">
                                  <div class="input-group-text">
                                      <span class="fas fa-envelope"></span>
                                  </div>
                              </div>
                          </div>
                          <div class="row m-left-0px">
                              <div class="g-recaptcha" name="recaptcha" data-sitekey="<?php echo $GLOBAL['site_recaptcha']; ?>"></div>
                          </div>
                          <div class="row m-top-12px">
                              <div class="col-8">
                              </div>
                              <div class="col-4">
                                  <button type="submit" class="btn btn-primary btn-block" name="submit" onclick="return valida()"><?php echo $DICIONARIO['sign_in'] ?></button>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="row m-top-1em">
      <div class="col-12">
          <div class="login-logo t_white">
              <?php echo $DICIONARIO['presetation_video'] ?>
          </div>
          <video width="700" controls autoplay>
              <source src="https://kingrespectcrypto.com/resources/video/apresentacao.mp4" type="video/mp4">
              Your browser does not support HTML video.
          </video>
      </div>
  </div>
  <?php require_once("redes_sociais.php"); ?>
</body>

<script type="text/javascript">
  function valida() {
    if (grecaptcha.getResponse() == "") {
      alert("Recaptcha not checked");
      return false;
    } else return true;
  }

  var slideIndex = 0;
  showSlides(slideIndex);

  // Next/previous controls
  function plusSlides(n) {
      showSlides(slideIndex += n);
  }

  // Thumbnail image controls
  function currentSlide(n) {
      showSlides(slideIndex = n);
  }

  function showSlides(n) {

      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("dot");
      for (i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";  
      }
      slideIndex++;
      if (slideIndex > slides.length) {slideIndex = 1}    
      for (i = 0; i < dots.length; i++) {
          dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block";  
      dots[slideIndex-1].className += " active";
      setTimeout(showSlides, 5000); // Change image every 2 seconds
  }
</script>
