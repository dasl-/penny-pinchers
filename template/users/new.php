<? require_once "template/shared/header.php"; ?>

    <form>
        <center>
            <div class="form-block">
                User Name:&nbsp;&nbsp;<input id="user-name" type="text"></input>
                <span class='empty-user-name error hidden'>
                    Please enter a user name.
                </span>
                <span class='numeric-user-name error hidden'>
                    Please enter a non-numeric user name.
                </span>
            </div>

            <div class="form-block">
                <i>Don't use this password with other websites -- we don't use https!</i><br>
                Password:&nbsp;&nbsp;<input id="password" type="password"></input>
                <span class='empty-password error hidden'>
                    Please enter a password.
                </span>
            </div>

            <div class="form-block">
                Confirm Password:&nbsp;&nbsp;<input id="password-confirm" type="password"></input>
                <span class='password-match error hidden'>
                    Passwords don't match.
                </span>
            </div>

            <input id="submit-button" type="submit" value="Submit" />
        </center>
    </form>

<div class="flash-message-content user-registration-success">
    Your user has been successfully registered! Redirecting to the homepage...
    <br><br>
    <i>After a certain point, money is meaningless, it ceases to be the goal, the game is what counts.</i>
</div>
<? require_once "template/shared/flash_message.php"; ?>

<script type="text/javascript" src="/assets/js/users/new.js?bust=<?= $cache_version ?>"></script>
<? require_once "template/shared/footer.php"; ?>