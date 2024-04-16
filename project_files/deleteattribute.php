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

if (isset($_POST['delete-attribute'])) {
    sanitizeInput();
    $deleteAttributeStatus = deleteAttribute($pdo, $attributeTable, $keys, $currentAttributeId, $currentOption);
}
if (isset($_POST['cancel-delete'])) {
    header("Location: listattributes.php?option={$currentOption}");
	exit();
}

include_once 'includes/header.php';
?>

<div class="container mt-5">

    <h1 class="text-center fw-bold mb-5">Ta bort alternativ i "<?php echo $optionName ?>"</h1>
    
    <a href="listattributes.php?option=<?php echo $currentOption ?>" class="btn btn-secondary mt-2 mb-4 me-1">Tillbaka</a>

    <?php
    if(isset($editAttributeStatus)) {
        echo $editAttributeStatus;
    }
    ?>

    
    <form action="" method="post">
        <label for="edited-attribute" class="form-label"> Är du säker på att du vill ta bort alternativet "<span class="fw-bold"><?php echo $attributeData[$currentAttributeRow][$keys[1]]; ?></span>"?</label><br>
        <input class="btn btn-danger me-1" type="submit" name="delete-attribute" value="Ta bort"> <input class="btn btn-warning" type="submit" name="cancel-delete" value="Avbryt">
    </form>
</div>

<?php
include_once 'includes/footer.php';
?>