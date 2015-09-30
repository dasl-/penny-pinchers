<tr>
	<td><?= $user->user_name ?></td>
	<td><?= $total_charges[$user->user_id] ?></td>
	<td>
		<a href="/users/<?= $user->user_name ?>/charges/new">New charge</a>
		&nbsp;&nbsp;&nbsp;
		<a href="/users/<?= $user->user_name ?>/charges">View charges</a>
	</td>
</tr>