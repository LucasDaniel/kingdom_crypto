<?php  ?>
<body class="hold-transition login-page background_index">
  <div class="row">
    <div class="col-8">
      <div class="login-logo t_white">
        <?php echo $DICIONARIO['presetation_video'] ?>
      </div>
      <video width="700" controls autoplay>
        <source src="https://kingrespectcrypto.com/resources/video/apresentacao.mp4" type="video/mp4">
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
  <?php require_once("redes_sociais.php"); ?>
</body>

<!--
  https://twitter.com/kingrespectcryp
  https://www.youtube.com/channel/UCyhZdrEARIQjk-QnBaLTf2w/videos
-->

<script type="text/javascript">
  function valida() {
    if (grecaptcha.getResponse() == "") {
      alert("Recaptcha not checked");
      return false;
    } else return true;
  }
</script>
