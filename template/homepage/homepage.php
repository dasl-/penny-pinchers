<? require_once "template/shared/header.php"; ?>
<h2>Welcome to Austere October</h2>
<p>Losers have to chug 40s at the end of the month.</p>

<h2>Users</h2>
<table>
    <tr>
        <th>User Name</th>
        <th><abbr title="per person (divide by two for jalara)">Total Charges</abbr></th>
        <th>Actions</th>
    </tr>
    <?
        foreach ($users as $user) {
            require 'template/homepage/user_row.php';
        }
    ?>
</table>

<?
    if (empty($users)) {
        echo "<p>No users have registered yet.</p>";
    }
?>
<h2>Recent Activity</h2>
<table>
    <tr>
        <th>When</th>
        <th>What</th>
    </tr>
    <?
        foreach ($recent_activities as $recent_activity) {
            require 'template/homepage/recent_activity_row.php';
        }
    ?>
</table>

<h2>Thoughts</h2>
<a href="thoughts/new">New Thought</a>
<?
    foreach ($thoughts as $thought) {
        require 'template/homepage/thought.php';
    }
?>

<script type="text/javascript" src="/assets/js/homepage/homepage.js?bust=<?= $cache_version ?>"></script>
<? require_once "template/shared/footer.php"; ?>
