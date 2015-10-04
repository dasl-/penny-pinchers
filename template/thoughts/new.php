<? require_once "template/shared/header.php"; ?>

<h2>What are you thinking about?</h2>
<br><br>
<form id="new-thought">
    <center>
        Title:
        <input id="title" type="text"></input>
        <span class='empty-title error hidden'>
            Please enter a title.
        </span>
        <br>

        Text:
        <input id="text" type="text"></input>
        <span class='empty-text error hidden'>
            Please enter text.
        </span>
        <br>

        <input id="submit-button" type="submit" value="Submit" />
    </center>
</form>

<br>

<div class="flash-message-content new-success">
    You have successfully shared your thought <b><span class="success-thought"></span></b>!
</div>
<? require_once "template/shared/flash_message.php"; ?>

<script type="text/javascript" src="/assets/js/thoughts/new.js?bust=<?= $cache_version ?>"></script>

<? require_once "template/shared/footer.php"; ?>