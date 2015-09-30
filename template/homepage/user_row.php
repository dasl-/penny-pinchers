<tr>
	<td><?= $user->user_name ?></td>
	<td><?= isset($total_charges_by_user_id[$user->user_id]) ?
			formatMoney($total_charges_by_user_id[$user->user_id]) :
			formatMoney(0) ?></td>
	<td>
		<a href="/users/<?= $user->user_name ?>/charges/new">New charge</a>
		&nbsp;&nbsp;&nbsp;
		<a href="/users/<?= $user->user_name ?>/charges">View charges</a>
	</td>
</tr>