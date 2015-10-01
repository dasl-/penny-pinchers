<? // Use this to display transient success/failure messages that flash and then fade out. ?>
<div id="flash-message-container"></div>
<div class="flash-message-content failure-empty"></div>
<div class="flash-message-content failure-default">
	Oops. Something went wrong :'(
    <br><br>
    <center><img src="http://media.giphy.com/media/10YwwI8H0Np3J6/giphy.gif"></center>
</div>
<script type="text/javascript" src="/assets/js/modules/flash_message.js?bust=<?= $cache_version ?>"></script>
