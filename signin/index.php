
<?php
    include_once("../config.php");

    if (isset($_SESSION)) {
        
        if (array_key_exists("uid",$_SESSION))
            header("location: ../dashboard/");
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GEOCARS | signin</title>
    <!-- ICON -->
    <link rel="icon" href="../assets/geocarsapp.png">
    <!-- CSS -->
    <link rel="stylesheet" href="signin.css">
    <!-- JS -->
    <script src="https://kit.fontawesome.com/0ad786b032.js" crossorigin="anonymous"></script>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>
<body>
    <div class="signin-wrapper">
        <div class="center-panel">
            <!-- form panel -->
            <div class="form-panel px-3 px-md-0 pt-5 pb-3 py-md-0">

                <!-- signin title -->
                <span class="signin-title overflow-ellipsis" role="text">
                    Sign in
                </span>
                
                <!-- signin form -->
                <div class="input-button-group">

                    <!-- email group -->
                    <div class="input-group">
                        <span class="input-label overflow-ellipsis" role="text">
                            Email
                        </span>
                        <div class="icon-input-group">
                            <i class="input-icon fa fa-envelope"></i>
                            <input id="email-input" class="input-field" type="email" name="signin-email" placeholder="Email">
                            <span id ="email-input-validate" class="input-validator-label overflow-ellipsis"></span>
                        </div>
                    </div>

                    <!-- password group -->
                    <div class="input-group">
                        <span class="input-label overflow-ellipsis" role="text">
                            Password
                        </span>
                        <div class="icon-input-group">
                            <i class="input-icon fa fa-lock"></i>
                            <input id="password-input" class="input-field" type="password" name="signin-password" placeholder="Password">
                            <span id="password-input-validate" class="input-validator-label overflow-ellipsis"></span>
                        </div>
                    </div>

                    <!-- submit button  -->
                    <button id="submit-form" class="signin-submit" type="submit" name="submit">sign in</button>

                    <!-- forgot password group -->
                    <!--<span class="forgot-password-group">-->
                    <!--    <a class="forgot-password-link overflow-ellipsis" href="#">Forgot password?</a>-->
                    <!--</span>-->

                    <!-- divider -->
                    <span class="divider" role="cell">
                        <hr class="divider-separator">
                        <span class="divider-label" role="text">OR</span>
                        <hr class="divider-separator">
                    </span>

                    <!-- singup link -->
                    <a class="signup-link" href="../signup/">SIGN UP</a>
                
                </div>

            </div>
            <!-- background panel -->
            <div class="background-panel" style="background-image: linear-gradient(to bottom , rgba(0,0,0,0.6) ,rgba(0,0,0,0.6)), url('../assets/signin/signin-background.jpeg');"></div>
        </div>
    </div>
</body>
<script type="text/javascript" src="../js/jquery-3.6.0.js"></script>
<script type="text/javascript" src="../js/is-email.js"></script>
<script>

    const validate = () => {
        let isinvalid ,
            emailF  , 
            emailV  ,
            passwF  , 
            passwV  ;

        isinvalid = false;
        emailF  = $("#email-input");
        emailV  = $("#email-input-validate");
        passwF  = $("#password-input");
        passwV  = $("#password-input-validate")

        if (emailF.val().length <= 0) {
            isinvalid = true;
            emailV.text("*empty email field");
        }
        else {
            if (!isEmail(emailF.val())) {
                isinvalid = true;
                emailV.text("*invalid email format");
            }
            else {
                emailV.text("");
            }
        }

        if (passwF.val().length <= 0) {
            isinvalid = true;
            passwV.text("*empty password field");
        }
        else {
            passwV.text("");
        }
        return isinvalid;
    };

    const signin = () => {
        if (validate())
                return;
            
        let email , password;

        email = $("#email-input").val();
        password = $("#password-input").val();

        $.ajax({
            url  : "onsignin.php" ,
            type : "POST" ,
            data : {
                email    : email,
                password : password
            },
            dataType : "json" ,
            success  : (response) => {
                /*
                    69 := success
                    70 := invalid user
                */
                switch (response.statusCode) {
                    case 70: {

                        $("#email-input-validate")
                        .text("*invalid email or password!");

                        $("#password-input")
                        .val("");

                        break;

                    }
                    case 69: {
                        window.location.href = "../dashboard/";
                        break;
                    }
                }
            } ,
            error    : (err) => {
                console.log(err);
            }
        });
    };

    $(document).ready(function() {

        $("#submit-form").click((e) => signin());

        $(window).keyup((e) => {
            if (e.keyCode == 13)
                signin();
        });
        
    });

</script>
</html>

