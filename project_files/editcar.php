<?php
include_once 'includes/config.php';
include_once 'includes/functions.php';

$allOwnersArray = selectExistingOwners($pdo);
$allDriveTypes = selectAttributes($pdo, 'table_drive_type');
$allFuelTypes = selectAttributes($pdo, 'table_fuel_type');
$allTransTypes = selectAttributes($pdo, 'table_trans_type');
$allBodyStyles = selectAttributes($pdo, 'table_body_style');

$currentCarId = $_GET['carid'];

$carInfo = selectSingleCar($pdo, $currentCarId);

foreach ($carInfo as $key => &$value) {
    if ($value == 0 || $value == '' || $value == '0000-00-00') {
        if ($key === 'cars_img') {
            $value = 'car-placeholder.webp'; 
        } else { 
            $value = '';  
        } 
    }
}

if(isset($_POST['update-car'])) {
    sanitizeInput();
    $carEditStatus = editExistingCar($pdo);
}

include_once 'includes/header.php';
?>

<div class="container main-content mt-5">

    <h1 class="text-center fw-bold mb-5">Redigera bil</h1>

    <a href='index.php' class='btn btn-secondary mt-2 mb-4 me-1'>Tillbaka</a>

    <?php
    if(isset($carEditStatus)) {
        echo $carEditStatus;
        header("Refresh: 5");
    }
    ?>

    <p class="fst-italic mt-2"><span class="text-danger">*</span> anger obligatoriska fält</p>

    <h2 class="h4 mb-3">Bildata:</h2>
    
    <form action="" method="post" enctype="multipart/form-data">    

        <div class="form-check">
            <input class="form-check-input border border-secondary-subtle" type="checkbox" id="sale-status" name="sale-status" value="sold" <?php if($carInfo['cars_sale_status'] == 1) {echo "checked";} ?>>
            <label for="sale-status" class="form-check-label">Bilen är såld</label><br><br>
        </div>

        <label for="existing-customer" class="form-label"><span class="text-danger">*</span> Bilens ägare:</label><br>
        <select class="form-select" name="existing-customer" id="existing-customer" required="required">
            <option value="">Välj ägare</option>
            <?php
            populateOwnerField($allOwnersArray, $carInfo);
            ?>
        </select><br>


        <div class="row">
            <div class="col">
                <label for="car-img" class="form-label"> Ange ny bild:</label><br>
                <input class="form-control" type="file" id="car-img" name="car-img"><br>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <label for="brand" class="form-label"><span class="text-danger">*</span> Märke:</label><br>
                <input class="form-control" type="text" id="brand" name="brand" placeholder="" value="<?php echo $carInfo['cars_brand'] ?>" required="required"><br>
            </div>
            <div class="col-sm-4">  
                <label for="model" class="form-label"><span class="text-danger">*</span> Modell:</label><br>
                <input class="form-control" type="text" id="model" name="model" placeholder="" value="<?php echo $carInfo['cars_model'] ?>" required="required"><br>
            </div>
            <div class="col-sm-4">  
                <label for="year" class="form-label"><span class="text-danger">*</span> Årsmodell:</label><br>
                <input class="form-control" type="text" id="year" name="year" placeholder="" value="<?php echo $carInfo['cars_model_year'] ?>" required="required"><br>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <label for="license" class="form-label"><span class="text-danger">*</span> Registernummer:</label><br>
                <input class="form-control" type="text" id="license" name="license" placeholder="ABC-123" value="<?php echo $carInfo['cars_license'] ?>" required="required"><br>
            </div>
            <div class="col-sm-4">  
                <label for="mileage" class="form-label"><span class="text-danger">*</span> Miltal (km):</label><br>
                <input class="form-control" type="text" id="mileage" name="mileage" placeholder="" value="<?php echo $carInfo['cars_mileage'] ?>" required="required"><br>
            </div>
            <div class="col-sm-4">  
                <label for="price" class="form-label"><span class="text-danger">*</span> Pris (€):</label><br>
                <input class="form-control" type="text" id="price" name="price" placeholder="" value="<?php echo $carInfo['cars_price'] ?>" required="required"><br>
            </div>
        </div>

        <label for="inspection" class="form-label">Senaste besiktningen:</label><br>
        <input class="form-control" type="date" id="inspection" name="inspection" value="<?php echo $carInfo['cars_inspection_date'] ?>"><br>

        <label for="weight" class="form-label">Vikt (kg):</label><br>
        <input class="form-control" type="text" id="weight" name="weight" placeholder="" value="<?php echo $carInfo['cars_weight'] ?>"><br>        

        <label for="displacement" class="form-label">Slagvolym (l):</label><br>
        <input class="form-control" type="text" id="displacement" name="displacement" placeholder="" value="<?php echo $carInfo['cars_displacement'] ?>"><br>

        <label for="power" class="form-label">Effekt (hk):</label><br>
        <input class="form-control" type="text" id="horsepower" name="horsepower" placeholder="" value="<?php echo $carInfo['cars_hp'] ?>"><br>

        <label for="consumption" class="form-label">Genomsnittlig förbrukning (l/100 km):</label><br>
        <input class="form-control" type="text" id="consumption" name="consumption" value="<?php echo $carInfo['cars_consumption'] ?>"><br>

        <label for="emissions" class="form-label">CO2-utsläpp (g/km):</label><br>
        <input class="form-control" type="text" id="emissions" name="emissions" value="<?php echo $carInfo['cars_emissions'] ?>"><br>


        <div class="row">
            <div class="col-sm-6 col-md-3">
                <label for="fuel" class="form-label"><span class="text-danger">*</span> Drivmedel:</label><br>
                <select class="form-select" name="fuel" id="fuel" required="required">
                    <option value="">Välj drivmedel</option>
                    <?php
                    populateAttributeField($allFuelTypes, $carInfo);
                    ?>
                </select><br>
            </div>
            <div class="col-sm-6 col-md-3">  
                <label for="drive-type" class="form-label"><span class="text-danger">*</span> Drivsystem:</label><br>
                <select class="form-select" name="drive-type" id="drive-type" required="required">
                    <option value="">Välj drivsystem</option>
                    <?php
                    populateAttributeField($allDriveTypes, $carInfo);
                    ?>
                </select><br>
            </div>
            <div class="col-sm-6 col-md-3">  
                <label for="trans-type" class="form-label"><span class="text-danger">*</span> Växellåda:</label><br>
                <select class="form-select" name="trans-type" id="trans-type" required="required">
                    <option value="">Välj växellåda</option>
                    <?php
                    populateAttributeField($allTransTypes, $carInfo);
                    ?>
                </select><br>
            </div>
            <div class="col-sm-6 col-md-3">  
                <label for="body-style" class="form-label"><span class="text-danger">*</span> Karossform:</label><br>
                <select class="form-select" name="body-style" id="body-style" required="required">
                    <option value="">Välj karossform</option>
                    <?php
                    populateAttributeField($allBodyStyles, $carInfo);
                    ?>
                </select><br>
            </div>
        </div>

        <label for="additional-info" class="form-label">Ytterligare info:</label><br>
        <textarea class="form-control" id="additional-info" name="additional-info" rows="5" cols="30"><?php echo $carInfo['cars_description'] ?></textarea><br>

        <input class="btn btn-primary" type="submit" name="update-car" value="Skicka">
    </form>


	<div class="row">
		<div class="col-4">
		</div>
	</div>

</div>



<?php
include_once 'includes/footer.php';
?>