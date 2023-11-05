<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>註冊</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/favicon.ico">
</head>

<body class="bg-milky">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block overflow-hidden">
                        <img class="bg-coffee" src="img/bg-register.svg" alt="">
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                <h2 class="h6 text-danger mb-4" id="error"></h2>
                            </div>
                            <!-- Form -->
                            <form action="action/users/doSignUp.php" method="post" class="user" id="form">
                                <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="name"
                                            placeholder="User Name" name="name">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="email"
                                        placeholder="Email Address" name="email">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="password" placeholder="Password" name="password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="repassword" placeholder="Repeat Password" name="repassword">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="tel" class="form-control form-control-user"
                                            id="phone" placeholder="Phone" name="phone">
                                    </div>
                                    <div class="col-sm-6">
                                    <select class="form-select gender-select" aria-label="gender"  name="gender" id="gender">
                                        <option value="">Select Your Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="LGBTQIA+">LGBTQIA+</option>
                                        <option value="Private">Private</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="date" class="form-control form-control-user" id="birthday"
                                    name="birthday">
                                </div>
                                
                                <button class="btn btn-user btn-block bg-milky border-0 sign-up" id="send" type="button">Sign Up !</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.php">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        const form = document.querySelector("#form");
        const name=document.querySelector("#name");
        const password=document.querySelector("#password");
        const repassword=document.querySelector("#repassword");
        const email=document.querySelector("#email");
        const gender=document.querySelector("#gender");
        const phone=document.querySelector("#phone");
        const birthday=document.querySelector("#birthday");
        const remail=/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/
        const send=document.querySelector("#send");
        const error=document.querySelector("#error");
        
        send.addEventListener("click",function(){
        
        
        if(name.value==""){
            error.innerText="請輸入帳號"
            return;
        }else{
            error.innerText=""
        }
        
        if(name.value.length<4){
            error.innerText="帳號請設定在4~12位英數字之間"
            return;
        }

        if(name.value.length>12){
            error.innerText="帳號請設定在4~12位英數字之間"
            return;
        }

        if(email.value==""){
            error.innerText="請輸入email"
            return;
        }
        
        if(!remail.test(email.value)){
            error.innerText="email格式錯誤"
            return;
        }

        if(password.value==""){
            error.innerText="請輸入密碼"
            return;
        }else{
            error.innerText=""
        }

        if(repassword.value!=password.value){
            error.innerText="密碼不一致"
            return;
        }else{
            error.innerText=""
        }

        if(phone.value == ""){
            error.innerText="請輸入電話號碼"
            return;
        }else{
            error.innerText=""
        }

        if(gender.value == ""){
            error.innerText="請選擇性別"
            return;
        }else{
            error.innerText=""
        }
        
        if(birthday.value == ""){
            error.innerText="請輸入生日日期"
            return;
        }else{
            error.innerText=""
        }
        
        form.submit();
    })
        



    </script>
    
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>