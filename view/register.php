
<body class="hold-transition login-page background_index">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Register</h3>
        </div>
        <div class="card-body">
            <form action="https://kingrespectcrypto.com/controller/register.php" method="post">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" placeholder="Email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Password (more than 5 characters) </label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="***">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Retype password</label>
                            <input type="password" id="repassword" name="repassword" class="form-control" placeholder="***">
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
                        <button type="submit" class="btn btn-primary btn-block" name="submit" onclick="return valida()"><?php echo $DICIONARIO['register'] ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

<script type="text/javascript">
  function valida() {

    var password = document.getElementById("password").value;
    var repassword = document.getElementById("repassword").value;

    if (password.length < 2) {
        alert("Password less than 6 characters.");
        return false;
    } 
    if (password != repassword) {
        alert("Passwords don't match.");
        return false;
    }
    if (grecaptcha.getResponse() == "") {
      alert("Recaptcha not checked.");
      return false;
    } 
    
    return true;
  }
</script>