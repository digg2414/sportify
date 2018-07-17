<?php
    require_once('core/init.php');
    $account = new Account($conn);
    include('includes/handlers/register-handler.php');
    include('includes/handlers/login-handler.php');
?>

<html>
    <head>
        <title>Sportify - Authentication</title>
        <link rel="stylesheet" type="text/css" href="assets/css/register.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="assets/js/register.js"></script>
    </head>
    <body>
        <?php
    	if(isset($_POST['register-button'])) {
    		echo '<script>
    				$(document).ready(function() {
    					$("#login-form").hide();
    					$("#register-form").show();
    				});
    			</script>';
    	}
    	else {
    		echo '<script>
    				$(document).ready(function() {
    					$("#login-form").show();
    					$("#register-form").hide();
    				});
    			</script>';
    	}
    	?>
        <div id="background">
            <div id="auth-container">
                <div class="container" id="inputContainer">
                    <form id="login-form" method="POST" action="register.php">
                        <h2>Log In to your account</h2>
                        <p>
                            <?php echo $account->getError(Constants::$loginFailed); ?>
                            <label for="username">Username</label>
                            <input name="loginUsername" id="loginUsername" type="text" placeholder="Your Username" value="<?php getInput('loginUsername'); ?>" required />
                        </p>
                        <p>
                            <label for="password">Password</label>
                            <input name="loginPassword" id="loginPassword" type="password" placeholder="Your Password" required />
                        </p>

                        <button type="submit" name="login-button">LOG IN</button>

                        <div class="hasAccountText">
                            <span class="hideLogin">Don't have an account yet? Sign up here!</span>
                        </div>
                    </form>

                    <form id="register-form" method="POST" action="register.php">
                        <h2>Register with sportify</h2>
                        <p>
                            <?php echo $account->getError(Constants::$usernameCharacters); ?>
                            <?php echo $account->getError(Constants::$usernamePresent); ?>
                            <label for="Username">Username</label>
                            <input name="username" id="username" type="text" placeholder="Your Username" value="<?php getInput('username'); ?>" required  />
                        </p>
                        <p>
                            <?php echo $account->getError(Constants::$firstNameCharacters ); ?>
                            <label for="firstname">First Name</label>
                            <input name="firstname" id="firstname" type="text" placeholder="Your First Name" value="<?php getInput('firstname'); ?>" requierd />
                        </p>
                        <p>
                            <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                            <label for="lastname">Last Name</label>
                            <input name="lastname" id="lastname" type="text" placeholder="Your Last Name" value="<?php getInput('lastname'); ?>" required />
                        </p>
                        <p>
                            <?php echo $account->getError(Constants::$emailInvalid); ?>
                            <?php echo $account->getError(Constants::$emailPresent); ?>
                            <label for="email">Email</label>
                            <input name="email" id="email" type="email" placeholder="Your Email" value="<?php getInput('email'); ?>" requierd />
                        </p>
                        <p>
                            <?php echo $account->getError(Constants::$passwordNotSymbolic); ?>
                            <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                            <?php echo $account->getError(Constants::$passwordCharacters); ?>
                            <label for="password">Password</label>
                            <input name="password" id="password" type="password" placeholder="Your Password" required  />
                        </p>
                        <p>
                            <label for="confirm-password">Confirm Password</label>
                            <input name="confirm-password" id="confirm-password" type="password" placeholder="Confirm Your Password" required />
                        </p>

                        <button type="submit" name="register-button">SIGN UP</button>

                        <div class="hasAccountText">
                            <span class="hideRegister">Already have an account? Log in here!</span>
                        </div>
                    </form>
                </div>

                <div id="loginText">
                    <h1>Get great music, right now.</h1>
                    <h2>Listen to loads of songs for free.</h2>
                    <ul>
                        <li>
                            Discover music you'll fall in love with.
                        </li>
                        <li>
                            Create your own playlists.
                        </li>
                        <li>
                            Follow artists to keep up to date.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
