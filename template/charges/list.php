<? require_once "template/shared/header.php"; ?>
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
            require 'template/charges/table_row.php';
        }
    ?>
</table>

<script type="text/javascript" src="/assets/js/charges/new.js?bust=<? echo $cache_version; ?>"></script>
<? require_once "template/shared/footer.php"; ?>