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

<script type="text/javascript" src="/assets/js/users/new.js?bust=<? echo $cache_version; ?>"></script>
<? require_once "template/shared/footer.php"; ?>