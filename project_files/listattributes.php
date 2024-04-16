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

$attributeData = selectAttributes($pdo, $attributeTable);
$keys = array_keys($attributeData[0]);

include_once 'includes/header.php';
?>

<div class="container mt-5">

    <h1 class="text-center fw-bold mb-5">Redigera/ta bort alternativ i "<?php echo $optionName ?>"</h1>
    
    <a href='index.php' class='btn btn-secondary mt-2 mb-4 me-1'>Tillbaka</a>

    <?php
    if(isset($addAttributeStatus)) {
        echo $addAttributeStatus;
    }
    ?>

    <form action="" method="post">
        <label for="new-attribute" class="form-label"> Välj ett alternativ att redigera/ta bort:</label><br>
            <ul class="list-group">
                <?php
                $tableRow = 0;
                foreach($attributeData as $attribute) {
                    echo "<li class='list-group-item fw-bold'>
                    {$attribute[$keys[1]]}<br> 
                    <a href='editattribute.php?option={$currentOption}&attribute={$tableRow}' class='btn btn-warning mt-2 me-1'>Redigera</a>
                    <a href='deleteattribute.php?option={$currentOption}&attribute={$tableRow}' class='btn btn-danger mt-2'>Ta bort</a>
                    </li>";
                    $tableRow++;
                }
                ?>
            </ul>
    </form>
</div>

<?php
include_once 'includes/footer.php';
?>