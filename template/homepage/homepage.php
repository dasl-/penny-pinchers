<? require_once "template/shared/header.php"; ?>
<h2>Welcome</h2>
Auster October: Day 1.

<h2>Users</h2>
<table>
	<tr>
		<th>User Name</th>
		<th>Total Charges</th>
		<th>Actions</th>
	</tr>
	<?
		foreach ($users as $user) {
			require 'template/homepage/user_row.php';
		}
	?>
</table>

<?
	if (empty($users)) {
		echo "<p>No users have registered yet.</p>";
	}
?>

<h2>Useful Links</h2>
<ul>
	<li>
		<a href="/users/new">Register new user</a>
	</li>
</ul>
<h2>Wish List</h2>
<ul>
	<li>Mobile UI</li>
</ul>

<div class="flash-message-content test">
	test flash
</div>
<? require_once "template/shared/flash_message.php"; ?>
<script type="text/javascript" src="/assets/js/homepage/homepage.js?bust=<?= $cache_version ?>"></script>
<? require_once "template/shared/footer.php"; ?>