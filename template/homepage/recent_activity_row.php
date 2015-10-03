<tr>
	<td><?= timeAgo($recent_activity["date"]) ?></td>
	<td>
		<a href="/charges/<?= $recent_activity['charge_id']?>">
			<?= $recent_activity["user_name"] ?> added a new charge for:
			<?= $recent_activity["description"] ?>
			(<?= formatMoney($recent_activity["amount"]) ?>).
		</a>
	</td>
</tr>
