<?php

?>
Бла бла бла <br />
<?= (isset($test_field) ? $test_field : '') ?>
<?= (isset($xz) ? $xz : '') ?>

<?php if(isset($test_field2)) {
    echo "Жил был код, и было в коде тестовое поле ".$test_field2."<br />";
}
