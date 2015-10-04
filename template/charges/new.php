<? require_once "template/shared/header.php"; ?>

<form id="new-charge">
    <center>
        <div class="form-block">
            Date: &nbsp;&nbsp;
            <input type="radio" name="charge-date" id="today" value="today" checked><label for="today">Today</label>
            <input type="radio" name="charge-date" id="yesterday" value="yesterday"><label for="yesterday">Yesterday</label>
        </div>

        <div class="form-block">
            Description:<br>
            <input id="description" type="text"></input>
            <span class='empty-description error hidden'>
                Please enter a description.
            </span>
        </div>

        <div class="form-block">
            Amount:<br>
            <input id="amount" type="number"></input>
            <span class='empty-amount error hidden'>
                Please enter a charge.
            </span>
        </div>

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