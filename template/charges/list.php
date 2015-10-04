<? require_once "template/shared/header.php"; ?>
<h2><?= "$user_name's Charges" ?></h2>

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
    }
?>

<?
    if ($logged_in_user->user_id === $user_id) {
?>
        <a href="/charges/new">Add a new charge</a>
<?
    }
?>


<script type="text/javascript" src="/assets/js/charges/new.js?bust=<?= $cache_version ?>"></script>
<? require_once "template/shared/footer.php"; ?>