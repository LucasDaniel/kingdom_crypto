
<body class="hold-transition login-page background_index">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Resend password</h3>
        </div>
        <div class="card-body">
            <form action="https://kingrespectcrypto.com/controller/resendpassword.php" method="post">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" placeholder="Email">
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
                        <button type="submit" class="btn btn-primary btn-block" name="submit" onclick="return valida()">Resend</button>
                    </div>
                </div>
            </form>

            <p class="mb-1">
                <a href="https://kingrespectcrypto.com/activateaccount.php">Back to activate</a>
            </p>
        </div>
    </div>
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