<? require_once "template/shared/header.php"; ?>
<h2>Charge #<?= "$charge->charge_id" ?></h2>
Charge for user: <?= "$user_name" ?>
<br>
<table>
    <tr>
        <th>Date</th>
        <th>Description</th>
        <th>Amount</th>
    </tr>
    <tr>
        <td><?= epochToString($charge->charge_date) ?></td>
        <td><?= $charge->description ?></td>
        <td><?= formatMoney($charge->amount) ?></td>
    </tr>
</table>

<input id="delete-button" type="button" value="Delete" />

<script type="text/javascript" src="/assets/js/charges/edit.js?bust=<?= $cache_version ?>"></script>
<? require_once "template/shared/footer.php"; ?>