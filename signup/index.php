
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GEOCARS | signup</title>
    <!-- ICON -->
    <link rel="icon" href="../assets/geocarsapp.png">
    <!-- CSS -->
    <link rel="stylesheet" href="signup.css">
    <!-- JS -->
    <script src="https://kit.fontawesome.com/0ad786b032.js" crossorigin="anonymous"></script>
    <!-- bootstrap -->
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>
<body>
    <div class="signup-wrapper">
        <div class="center-panel">

            <!-- carousel -->
            <div id="carousel-slide" class="carousel-panel">

                <!-- carousel controls -->

                <div id="parallax-scroll" class="parallax-container" style="background-image: linear-gradient(to right , rgba(0,0,0,0.4),rgba(0,0,0,0.4)) , url('../assets/signup/carousel-image-0.jpeg');"> 

                    <div class="carousel-item">
                        <div class="carousel-item-content">
                            <span class="slide-text" role="text">
                                <!-- TODO: edit greeting text -->
                                We keep track of your location.
                            </span>
                        </div>
                    </div><!--
                    --><div class="carousel-item">
                        <div class="carousel-item-content">
                            <span class="slide-text" role="text">
                                <!-- TODO: edit greeting text -->
                                We value our clients.
                            </span>
                        </div>
                    </div><!--
                    --><div class="carousel-item">
                        <div class="carousel-item-content">
                            <span class="slide-text" role="text">
                                <!-- TODO: edit greeting text -->
                                We value your vehicle.
                            </span>
                        </div>
                    </div>

                </div>

            </div>

            <!-- signup form panel -->
            <div class="signup-form-panel px-3 px-md-0 pt-5 pb-3 py-md-0">

                 <!-- signup title -->
                 <span class="signup-title overflow-ellipsis" role="text">
                    Sign up
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
                            <input id="email-input" class="input-field" type="email" name="signup-email" placeholder="Email">
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
                            <input id="password-input" class="input-field" type="password" name="signup-password" placeholder="Password">
                            <span id="password-input-validate" class="input-validator-label overflow-ellipsis"></span>
                        </div>
                    </div>

                    <!-- confirm password group -->
                    <div class="input-group">
                        <span class="input-label overflow-ellipsis" role="text">
                            Confirm password
                        </span>
                        <div class="icon-input-group">
                            <i class="input-icon fa fa-check-circle"></i>
                            <input id="confirm-password-input" class="input-field" type="password" name="signup-confirm-password" placeholder="Confirm password">
                            <span id="confirm-password-input-validate" class="input-validator-label overflow-ellipsis"></span>
                        </div>
                    </div>

                    <!-- submit button  -->
                    <button id="submit-form" class="signup-submit" type="submit" name="submit">sign up</button>

                    <!-- divider -->
                    <span class="divider" role="cell">
                        <hr class="divider-separator">
                        <span class="divider-label" role="text">OR</span>
                        <hr class="divider-separator">
                    </span>

                    <!-- singup link -->
                    <a class="signin-link" href="../signin/">SIGN IN</a>
                
                </div>

            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="../js/jquery-3.6.0.js"></script>
<script type="text/javascript" src="../js/is-email.js"></script>
<script type="text/javascript" src="../js/message-box.js"></script>
<script>
    
    const validate = () => {
        let isinvalid ,
            emailF ,
            emailV , 
            passwF ,
            passwV ,
            ConfPassF ,
            ConfPassV ;

        isinvalid = false;
        emailF = $("#email-input");
        emailV = $("#email-input-validate");
        passwF = $("#password-input");
        passwV = $("#password-input-validate");
        ConfPassF = $("#confirm-password-input");
        ConfPassV = $("#confirm-password-input-validate");

        if (emailF.val().length <= 0) {
            isinvalid = true;
            emailV.text("*empty email field.");
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
            passwV.text("*empty password field.");
        }
        else {
            if (passwF.val().length < 8) {
                isinvalid = true;
                passwV.text("*weak password!");
            }
            else {
                passwV.text("");
            }
        }

        if (ConfPassF.val().length <= 0) {
            isinvalid = true;
            ConfPassV.text("*empty confirm password field.");
        }
        else {
            ConfPassV.text("");
            if (passwF.val() !== ConfPassF.val()) {
                isinvalid = true;
                ConfPassV.text("*password does not match!");
            }
            else {
                ConfPassV.text("");
            }
        }
        return isinvalid;
    }

    $(document).ready(function() {
        
        const carousel = $("#carousel-slide");
        const parallax = $("#parallax-scroll");
        const children = parallax.children().toArray();

        (function(){
            const resize = () => {
                const _w = window.innerWidth;
                children.forEach((elem) => {
                    if (_w > 0 && _w < 768) {
                        elem.style.width = `${carousel.width()}px`;
                    }
                    else {
                        elem.style.width = "calc(768px / 2)";
                    }
                });
            }
            
            resize();
            
            $(window).resize((e)=> {
                resize();
            });

        })();

        let index = 0;
        let dir   = "r";
        
        setInterval(() => {

            carousel.scrollLeft(children[index].offsetWidth * index);
            
            if (index === (children.length -1)) {
                dir = "l";
            }
            else if (index === 0) {
                dir = "r";
            }

            if (dir === "l") 
                index --;
            else 
                index ++;
            
            if ((index < 0) || (index > (children.length -1))) {
                index = 0;
            }

        },3000);
        
        $("#submit-form").click(() => {
            
            if (validate())
                // if invalid form
                return;

            let email,password,cpassword;

            email = $("#email-input").val();
            password = $("#password-input").val();
            cpassword = $("#confirm-password-input").val();
            
            $.ajax({
                url  : "onsignup.php" ,
                type : "POST" ,
                data : { 
                    email : email ,
                    password : password ,
                    cpassword : cpassword ,
                } ,
                dataType : "json" ,
                success  : (response) => {
                    /*
                        69 := success
                        70 := fail
                        71 := user exist
                    */
                    switch (response.statusCode) {
                        case 71: {

                            $("#email-input-validate")
                            .text("*email is in use!");
                            break;

                        }
                        case 70: {
                            messageBox(response.message,(popup) => {
                                popup.remove();
                            });
                            break;
                        }
                        case 69: {
                            messageBox(response.message,(popup) => {
                                window.location.href = "../signin/";
                                popup.remove();
                            });
                            break;
                        }
                    }
                },
                error   : (err) => {
                    console.log(err);
                }
            });
        });
    });

</script>
</html>