<? require_once "template/shared/header.php"; ?>
<h2>Charge #<? echo "$charge->charge_id"; ?></h2>
Charge for user: <? echo "$user_name" ?>
<br>
<table>
    <tr>
        <th>Date</th>
        <th>Description</th>
        <th>Amount</th>
    </tr>
    <tr>
        <td><? echo $charge->charge_date; ?></td>
        <td><? echo $charge->description; ?></td>
        <td><? echo $charge->amount; ?></td>
    </tr>
</table>

<input id="delete-button" type="button" value="Delete" />

<script type="text/javascript" src="/assets/js/charges/edit.js?bust=<? echo $cache_version; ?>"></script>
<? require_once "template/shared/footer.php"; ?>