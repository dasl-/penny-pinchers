<? require_once "template/shared/header.php"; ?>
<h2>Welcome</h2>
We're about to begin Austere October!

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

<h2>Useful Links</h2>
<ul>
	<li>
		<a href="/users/new">Register new user</a>
	</li>
</ul>

<script type="text/javascript" src="/assets/js/homepage/homepage.js?bust=<?= $cache_version ?>"></script>
<? require_once "template/shared/footer.php"; ?>