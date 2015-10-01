<? require_once "template/shared/header.php"; ?>

    <form>
        <center>
            User Name:&nbsp;&nbsp;<input id="user-name" type="text"></input>
            <br>
            <span class='empty-user-name error hidden'>
                Please enter a user name.
            </span>
            <span class='numeric-user-name error hidden'>
                Please enter a non-numeric user name.
            </span>
            <input id="submit-button" type="submit" value="Submit" />
        </center>
    </form>

<div class="flash-message-content user-registration-success">
    Your user has been successfully registered! Redirecting to your new profile...
    <br><br>
    <i>After a certain point, money is meaningless, it ceases to be the goal, the game is what counts.</i>
</div>
<? require_once "template/shared/flash_message.php"; ?>

<script type="text/javascript" src="/assets/js/users/new.js?bust=<?= $cache_version ?>"></script>
<? require_once "template/shared/footer.php"; ?>