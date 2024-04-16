<?php
include_once 'includes/config.php';
include_once 'includes/functions.php';

$currentOption = $_GET['option'];

switch ($currentOption) {
    case 'fueltype':
        $optionName = 'Drivmedel';
        $attributeTable = 'table_fuel_type';
        break;
    case 'drivetype':
        $optionName = 'Drivsystem';
        $attributeTable = 'table_drive_type';
        break;
    case 'transtype':
        $optionName = 'Växellåda';
        $attributeTable = 'table_trans_type';
        break;
    case 'bodystyle':
        $optionName = 'Karossform';
        $attributeTable = 'table_body_style';
        break;
    default:
        break;
}

if (isset($_POST['add-attribute'])) {
    sanitizeInput();
    $addAttributeStatus = addAttribute($pdo, $attributeTable);
}

include_once 'includes/header.php';
?>

<div class="container mt-5">

    <h1 class="text-center fw-bold mb-5">Lägg till alternativ i "<?php echo $optionName ?>"</h1>
    
    <a href='index.php' class='btn btn-secondary mt-2 mb-4 me-1'>Tillbaka</a>

    <?php
    if(isset($addAttributeStatus)) {
        echo $addAttributeStatus;
    }
    ?>

    <form action="" method="post">
        <label for="new-attribute" class="form-label"> Namn på det nya alternativet:</label><br>
        <input class="form-control" type="text" id="new-attribute" name="new-attribute" placeholder="" required="required"><br>

        <input class="btn btn-primary me-1" type="submit" name="add-attribute" value="Skicka"> <a href='index.php' class='btn btn-warning me-1'>Avbryt</a>
    </form>
</div>

<?php
include_once 'includes/footer.php';
?>