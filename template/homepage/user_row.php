<tr>
    <td><a href="/users/<?= $user->user_name ?>"><?= $user->user_name ?></a></td>
    <td><?= isset($total_charges_by_user_id[$user->user_id]) ?
            formatMoney($total_charges_by_user_id[$user->user_id]) :
            formatMoney(0) ?></td>
    <td>
    	<?
    		if ($logged_in_user->user_id === $user->user_id) {
    	?>
        		<a href="/charges/new" class="action">New charge</a>&nbsp;&nbsp;&nbsp;
        <?
        	}
        ?>
        <a href="/users/<?= $user->user_name ?>/charges" class="action">View charges</a>
    </td>
</tr>