<? require_once "template/shared/header.php"; ?>
<h2>Welcome</h2>
Austere October: The Bad Beginning.

<h2>Users</h2>
<table>
    <tr>
        <th>User Name</th>
        <th>Total Charges</th>
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
        <th>User</th>
        <th>Description</th>
        <th>Amount</th>
    </tr>
    <?
        foreach ($recent_activities as $recent_activity) {
            require 'template/homepage/recent_activity_row.php';
        }
    ?>
</table>

<h2>Useful Links</h2>
<ul>
    <li>
        <a href="/users/new">Register new user</a>
    </li>
</ul>
<h2>Wish List</h2>
<ul>
    <li>Mobile UI that doesnt suck</li>
</ul>

<div class="flash-message-content test">
    test flash
</div>
<? require_once "template/shared/flash_message.php"; ?>
<script type="text/javascript" src="/assets/js/homepage/homepage.js?bust=<?= $cache_version ?>"></script>
<? require_once "template/shared/footer.php"; ?>