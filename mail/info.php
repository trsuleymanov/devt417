<?php

?>
Бла бла бла <br />
<?= (isset($aData['test_field']) ? $aData['test_field'] : '') ?>
<?= (isset($aData['xz']) ? $aData['xz'] : '') ?>

<?php if(isset($aData['test_field2'])) {
    echo "Жил был код, и было в коде тестовое поле ".$aData['test_field2']."<br />";
}
