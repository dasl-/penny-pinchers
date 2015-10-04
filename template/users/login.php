<? require_once "template/shared/header.php"; ?>

	<h2>Login</h2>
    <form>
        <center>
            <div class="form-block">
                User Name:&nbsp;&nbsp;<input id="user-name" type="text"></input>
                <span class='empty-user-name error hidden'>
                    Please enter a user name.
                </span>
            </div>

            <div class="form-block">

            	<i>Don't have a password? Your password is your user name by default.</i><br><br>
                Password:&nbsp;&nbsp;<input id="password" type="password"></input>
                <span class='empty-password error hidden'>
                    Please enter a password.
                </span>
            </div>
            <input id="submit-button" type="submit" value="Submit" />
        </center>
    </form>

    <h2>Register New User</h2>
	<a href="/users/new">Register new user</a>

<div class="flash-message-content login-success">
    Thanks for logging in. Redirecting you...
    <br><br>
    <i>After a certain point, money is meaningless, it ceases to be the goal, the game is what counts.</i>
</div>
<? require_once "template/shared/flash_message.php"; ?>

<script type="text/javascript" src="/assets/js/users/login.js?bust=<?= $cache_version ?>"></script>
<? require_once "template/shared/footer.php"; ?>