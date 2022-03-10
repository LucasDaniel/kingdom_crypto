<?php  ?>
<body class="hold-transition login-page background_index">
  <div class="login-box">
    <div class="login-logo t_white">
      <?php echo $GLOBAL['title'] ?>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg"><?php echo $DICIONARIO['make_login'] ?></p>
        <form action="https://kingrespectcrypto.com/controller/login.php" method="post">
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="<?php echo $DICIONARIO['email'] ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="<?php echo $DICIONARIO['password'] ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
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

        <p class="mb-1">
          <a href="https://kingrespectcrypto.com/forgotpassword.php"><?php echo $DICIONARIO['forgot_password'] ?></a>
        </p>
        <p class="mb-0">
          <a class="text-center"><?php echo $DICIONARIO['new_account'] ?></a>
        </p>
      </div>
    </div>
  </div>
  <?php require_once("redes_sociais.php"); ?>
</body>

<script type="text/javascript">
  function valida() {
    if (grecaptcha.getResponse() == "") {
      alert("Recaptcha not checked.");
      return false;
    } 
    return true;
  }
</script>