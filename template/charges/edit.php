<? require_once "template/shared/header.php"; ?>
<h2>Charge #<?= "$charge->charge_id" ?></h2>
<?
    if ($logged_in_user->user_id === $charge->user_id) {
?>
        <p>Your charge</p>
<?
    } else {
?>
        <p>Charge for user: <?= "$charge_user_name" ?></p>
<?
    }
?>
<br>
<table>
    <tr>
        <th>Date</th>
        <th>Description</th>
        <th>Amount</th>
    </tr>
    <tr>
        <td><?= formatDate($charge->charge_date) ?></td>
        <td><?= $charge->description ?></td>
        <td><?= formatMoney($charge->amount) ?></td>
    </tr>
</table>

<?
    if ($logged_in_user->user_id === $charge->user_id) {
?>
        <input id="delete-button" type="button" value="Delete" />
<?
    }
?>

<script type="text/javascript" src="/assets/js/charges/edit.js?bust=<?= $cache_version ?>"></script>
<? require_once "template/shared/footer.php"; ?>