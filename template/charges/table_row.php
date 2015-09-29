<tr>
    <td><? echo $charge->charge_date; ?></td>
    <td><? echo $charge->description; ?></td>
    <td><? echo $charge->amount; ?></td>
    <td><a href="/charges/<? echo $charge->charge_id; ?>">Edit</a></td>
</tr>