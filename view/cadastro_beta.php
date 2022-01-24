<?php  ?>
<body class="hold-transition login-page background_index">
  <div class="row">
    <div class="col-8">
      <video width="700" controls autoplay>
        <source src="./resources/video/apresentacao.mp4" type="video/mp4">
        Your browser does not support HTML video.
      </video>
    </div>
    <div class="col-4">
      <div class="login-box">
        <div class="login-logo t_white">
          <?php echo $GLOBAL['title'] ?>
        </div>
        <div class="card">
          <div class="card-body login-card-body">
          <p class="login-box-msg"><?php echo $DICIONARIO['discovery_project'] ?></p>
            <p class="login-box-msg"><?php echo $DICIONARIO['beta_register'] ?></p>
            <form action="controller/envio_email.php" method="post">
              <div class="input-group mb-3">
                <input type="email" name="email" class="form-control" placeholder="<?php echo $DICIONARIO['email'] ?>">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="g-recaptcha" data-sitekey="<?php echo $GLOBAL['recaptcha']; ?>"></div>
              </div>
              <div class="row">
                <div class="col-8">
                </div>
                <div class="col-4">
                  <button class="display-none" type="submit" class="btn btn-primary btn-block"><?php echo $DICIONARIO['sign_in'] ?></button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

<script type="text/javascript">
  var onloadCallback = function() {
    
  };
</script>
