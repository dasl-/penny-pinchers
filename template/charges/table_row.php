<tr>
    <td><?= formatDate($charge->charge_date) ?></td>
    <td><?= $charge->description ?></td>
    <td><?= formatMoney($charge->amount) ?></td>
    <td><a href="/charges/<?= $charge->charge_id ?>" class="action"><?= $action_name ?></a></td>
</tr>