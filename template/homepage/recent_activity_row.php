<tr>
	<td><?= timeAgo($recent_activity["date"]) ?></td>
	<td>
		<a href="/charges/<?= $recent_activity['charge_id']?>">
			<b><?= $recent_activity["user_name"] ?></b> added a new charge for:
			<b><?= $recent_activity["description"] ?></b>
			(<?= formatMoney($recent_activity["amount"]) ?>).
		</a>
	</td>
</tr>
