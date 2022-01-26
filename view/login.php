<?php  ?>
<body class="hold-transition login-page background_index">
  <div class="login-box">
    <div class="login-logo t_white">
      <?php echo $GLOBAL['title'] ?>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg"><?php echo $DICIONARIO['make_login'] ?></p>

        <form action="https://kingrespectcrypto.com/controller/login.php" method="post">
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="<?php echo $DICIONARIO['email'] ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="<?php echo $DICIONARIO['password'] ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember" disabled>
                <label for="remember">
                  <?php echo $DICIONARIO['remember_me'] ?>
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block"><?php echo $DICIONARIO['sign_in'] ?></button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mb-1">
          <a href="https://kingrespectcrypto.com/forgotpassword.php"><?php echo $DICIONARIO['forgot_password'] ?></a>
        </p>
        <p class="mb-0">
          <a href="https://kingrespectcrypto.com/register.php" class="text-center"><?php echo $DICIONARIO['new_account'] ?></a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
  <?php require_once("redes_sociais.php"); ?>
</body>
