<tr>
	<td><?= timeAgo($recent_activity["date"]) ?></td>
	<td><?= $recent_activity["user_name"] ?></td>
	<td><a href="/charges/<?= $recent_activity['charge_id']?>"><?= $recent_activity["description"] ?></a></td>
	<td><?= formatMoney($recent_activity["amount"]) ?></td>
</tr>
