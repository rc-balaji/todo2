
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    
</head>

<body>
    <div class="login-container">
        <form  name="myform" action="index.php" method="post" id="login-form"  onsubmit="return check()"   >
            <h2>Login</h2>
            <div class="login-input">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="login-input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="login-button">
                <input type="submit" value="Login">
            </div>
        </form>
    </div>
    <script>

        function check(){
            let user=document.forms["myform"]["username"].value
            let pass=Number(document.forms["myform"]["password"].value)
            const username=["sam","ram","raj"]
            const password=[123,234,456]
            t=0
            for(let i=0;i<3;i++){
               if(user===username[i] && pass===password[i]){
                    t=1
               }
               else if(user===username[i] && pass!==password[i]){
                    t=2
               }
            }

            if(t===1){
                alert("Success")
                return true
            }
            else if(t===2)
            {
                alert("Incorrect Pass")
                return false
            }else{
                alert("Not found")
                return false
            }
        }
    </script>

</body>

</html>
