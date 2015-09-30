<? require_once "template/shared/header.php"; ?>

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

<script type="text/javascript" src="/assets/js/charges/new.js?bust=<?= $cache_version ?>"></script>
<? require_once "template/shared/footer.php"; ?>