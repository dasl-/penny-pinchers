<? require_once 'template/shared/header.php'; ?>
    <h2>Sorry there are no thoughts 
    <? if (isset($charge_description)) {
        echo 'for ' . $charge_description;
    }?>
    </h2>
<? require_once "template/shared/footer.php"; ?>