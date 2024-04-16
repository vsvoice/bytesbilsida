<?php
include_once 'includes/config.php';
include_once 'includes/functions.php';

$currentAttributeRow = $_GET['attribute'];
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

$attributeData = selectAttributes($pdo, $attributeTable);
$keys = array_keys($attributeData[0]);

$currentAttributeId = $attributeData[$currentAttributeRow][$keys[0]];

if (isset($_POST['edit-attribute'])) {
    sanitizeInput();
    $editAttributeStatus = editAttribute($pdo, $attributeTable, $keys, $currentAttributeId, $currentOption);
}
if (isset($_POST['cancel-edit'])) {
    header("Location: listattributes.php?option={$currentOption}");
	exit();
}

include_once 'includes/header.php';
?>

<div class="container mt-5">

    <h1 class="text-center fw-bold mb-5">Redigera alternativ i "<?php echo $optionName ?>"</h1>
    
    <?php
    if(isset($editAttributeStatus)) {
        echo $editAttributeStatus;
    }
    ?>

    <p>Aktuellt namn:<br> <span class="fw-bold"><?php echo $attributeData[$currentAttributeRow][$keys[1]]; ?></span></p>

    <form action="" method="post">
        <label for="edited-attribute" class="form-label"> Nytt namn:</label><br>
        <input class="form-control" type="text" id="edited-attribute" name="edited-attribute" placeholder=""><br>

        <input class="btn btn-primary me-1" type="submit" name="edit-attribute" value="Skicka"> <a href='listattributes.php?option=<?php echo $currentOption ?>' class='btn btn-warning me-1'>Avbryt</a>
    </form>
</div>

<?php
include_once 'includes/footer.php';
?>