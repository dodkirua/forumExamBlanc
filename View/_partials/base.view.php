<?php
include './View/_partials/header.php';
if (isset($var['title'])){
    echo "<h1>" . $var['title'] . "</h1>";
}
include './View/_partials/menu.php';
/* @var string $html value of render of controller */
?>
<div id="principal">
    <div id="display">
        <?= $html ?>
    </div>

<?php
include './View/_partials/footer.php';
?>
