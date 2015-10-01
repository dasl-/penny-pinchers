<? require_once "template/shared/header.php"; ?>

<h2>New Charge for <?= $user_name ?></h2>
<br><br>
<form id="new-charge">
    <center>
        Amount:&nbsp;&nbsp;<input id="amount" type="text"></input>
        <span class='empty-amount error hidden'>
            Please enter a charge.
        </span>
        <br>
        Description:&nbsp;&nbsp;<input id="description" type="text"></input>
        <span class='empty-description error hidden'>
            Please enter a description.
        </span>
        <br>
        Date: &nbsp;&nbsp;
        <input type="radio" name="charge-date" id="today" value="today" checked><label for="today">Today</label>
        <input type="radio" name="charge-date" id="yesterday" value="yesterday"><label for="yesterday">Yesterday</label>
        <br>
        <input id="submit-button" type="submit" value="Submit" />
    </center>
</form>

<br>

<p><a href="/users/<?= $user_name ?>/charges">View all charges for <?= $user_name ?></a></p>

<div class="flash-message-content new-charge-success">
    Your charge for <b><span class="success-amount"></span></b> has been successfully registered!
    <br><br>
    <i>Money is like an arm or leg: use it or lose it</i>
</div>
<? require_once "template/shared/flash_message.php"; ?>

<script type="text/javascript" src="/assets/js/charges/new.js?bust=<?= $cache_version ?>"></script>
<? require_once "template/shared/footer.php"; ?>