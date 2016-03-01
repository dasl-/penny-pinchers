<? require_once "template/shared/header.php"; ?>

<?
    if ($logged_in_user->user_id === $user_id) {
?>
        <h2>Your Charges</h2>
<?
    } else {
?>
        <h2><?= "$user_name's Charges" ?></h2>
<?
    }
?>

<div>
    View charges for:
    <select id="month-select">
        <option <?= $month_number == 1 ? "selected" : "" ?> value="1">January</option>
        <option <?= $month_number == 2 ? "selected" : "" ?> value="2">February</option>
        <option <?= $month_number == 3 ? "selected" : "" ?> value="3">March</option>
        <option <?= $month_number == 4 ? "selected" : "" ?> value="4">April</option>
        <option <?= $month_number == 5 ? "selected" : "" ?> value="5">May</option>
        <option <?= $month_number == 6 ? "selected" : "" ?> value="6">June</option>
        <option <?= $month_number == 7 ? "selected" : "" ?> value="7">July</option>
        <option <?= $month_number == 8 ? "selected" : "" ?> value="8">August</option>
        <option <?= $month_number == 9 ? "selected" : "" ?> value="9">September</option>
        <option <?= $month_number == 10 ? "selected" : "" ?> value="10">October</option>
        <option <?= $month_number == 11 ? "selected" : "" ?> value="11">November</option>
        <option <?= $month_number == 12 ? "selected" : "" ?> value="12">December</option>
        <option <?= $month_number == -1 ? "selected" : "" ?> value="-1">All time</option>
    </select>
</div>

<table>
    <tr>
        <th>Date</th>
        <th>Description</th>
        <th>Amount</th>
        <th>Actions</th>
    </tr>
    <?
        foreach ($charges as $charge) {
            require 'template/charges/table_row.php';
        }
    ?>
</table>

<?
    if (empty($charges)) {
        echo "<p>No charges yet. Way to go!</p>";
    } else {
        $total_charges = formatMoney($total_charges);
        echo "<p>Total charges: $total_charges.</p>";
    }
?>

<?
    if ($logged_in_user->user_id === $user_id) {
?>
        <a href="/charges/new">Add a new charge</a>
<?
    }
?>

<script type="text/javascript" src="/assets/js/charges/list.js?bust=<?= $cache_version ?>"></script>
<? require_once "template/shared/footer.php"; ?>