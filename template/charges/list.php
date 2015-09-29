<? require_once(__DIR__ . '/../shared/header.php'); ?>
<h2><? echo "$user_name's Charges"; ?></h2>
<table>
    <tr>
        <th>Date</th>
        <th>Description</th>
        <th>Amount</th>
        <th>Actions</th>
    </tr>
    <?
        foreach ($charges as $charge) {
            require __DIR__ . '/table_row.php';
        }
    ?>
</table>

<script type="text/javascript" src="/assets/js/charges/new.js?bust=<? echo $cache_version; ?>"></script>
<? require_once(__DIR__ . '/../shared/footer.php'); ?>