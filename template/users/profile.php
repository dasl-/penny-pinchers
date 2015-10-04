<? require_once "template/shared/header.php"; ?>
<h2><?= $page_title ?></h2>

<p><a href="/users/<?= $profile_user->user_name ?>/charges">View charges</a></p>

<?
    if ($is_own_profile) {
?>
        <p><a href="/charges/new">Add new charge</a></p>
        <p><a href='/users/logout'>logout</a></p>
        <h2>Change Password</h2>
        <form>
        <div class="form-block">
            Old password:&nbsp;&nbsp;<input id="old-password" type="password"></input>
            <span class='empty-old-password error hidden'>
                Please enter a password.
            </span>
        </div>

        <div class="form-block">
            <i>Don't use this password with other websites -- we don't use https!</i><br>
            New password:&nbsp;&nbsp;<input id="new-password" type="password"></input>
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

        <input id="change-password-submit-button" type="submit" value="Change Password" />
        </form>

        <div class="flash-message-content change-password-success">
            Your password has been changed. Please login again.
        </div>
        <? require_once "template/shared/flash_message.php"; ?>
<?
    }
?>

<script type="text/javascript" src="/assets/js/users/profile.js?bust=<?= $cache_version ?>"></script>
<? require_once "template/shared/footer.php"; ?>
