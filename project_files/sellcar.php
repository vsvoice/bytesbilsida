<?php
include_once 'includes/config.php';
include_once 'includes/functions.php';
//include_once 'includes/upload.php';

$allOwnersArray = selectExistingOwners($pdo);
$allDriveTypes = selectAttributes($pdo, 'table_drive_type');
$allFuelTypes = selectAttributes($pdo, 'table_fuel_type');
$allTransTypes = selectAttributes($pdo, 'table_trans_type');
$allBodyStyles = selectAttributes($pdo, 'table_body_style');

if(isset($_POST['submit-owner'])) {
    sanitizeInput();
    $ownerInsertStatus = insertNewOwner($pdo);
}
if(isset($_POST['sell-car'])) {
    sanitizeInput();
    $carInsertStatus = insertNewCar($pdo);
}

include_once 'includes/header.php';
?>

<div class="container main-content mt-5">

    <h1 class="text-center fw-bold mb-5">Sälj din bil</h1>

    <?php
    if(isset($carInsertStatus)) {
        echo $carInsertStatus;
    }
    if(isset($ownerInsertStatus)) {
        echo $ownerInsertStatus;
    }
    ?>

    <p class="fst-italic"><span class="text-danger">*</span> anger obligatoriska fält</p>

    <h2 class="h4 mb-3">Lägg till ny bilägare:</h2>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col">
                <label for="fname" class="form-label"><span class="text-danger">*</span> Förnamn:</label>
                <input class="form-control" type="text" id="fname" name="fname" placeholder="" required="required"><br>
            </div>
            <div class="col">
                <label for="lname" class="form-label"><span class="text-danger">*</span> Efternamn:</label><br>
                <input class="form-control" type="text" id="lname" name="lname" placeholder="" required="required"><br>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="address" class="form-label">Adress:</label><br>
                <input class="form-control" type="text" id="address" name="address" placeholder=""><br>
            </div>
            <div class="col">
                <label for="zip" class="form-label">Postnummer:</label><br>
                <input class="form-control" type="text" id="zip" name="zip" placeholder=""><br>
            </div>
            <div class="col">    
                <label for="city" class="form-label">Stad:</label><br>
                <input class="form-control" type="text" id="city" name="city" placeholder=""><br>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="phone" class="form-label">Telefonnummer:</label><br>
                <input class="form-control" type="text" id="phone" name="phone" placeholder=""><br>
            </div>
            <div class="col">    
                <label for="email" class="form-label">E-post:</label><br>
                <input class="form-control" type="text" id="email" name="email" placeholder=""><br>
            </div>
        </div>
        <input class="btn btn-primary" type="submit" name="submit-owner" value="Skicka">
    </form>


    <h2 class="h4 mt-5 mb-3">Lägg till ny bil:</h2>
    
    <form action="" method="post" enctype="multipart/form-data">    

        <label for="existing-customer" class="form-label"><span class="text-danger">*</span> Bilens ägare:</label><br>
        <select class="form-select" name="existing-customer" id="existing-customer" required="required">
            <option value="">Välj ägare</option>
            <?php
            populateOwnerField($allOwnersArray);
            ?>
        </select><br>


        <div class="row">
            <div class="col">
                <label for="car-img" class="form-label"><span class="text-danger">*</span> Bild:</label><br>
                <input class="form-control" type="file" id="car-img" name="car-img" required="required"><br><br>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <label for="brand" class="form-label"><span class="text-danger">*</span> Märke:</label><br>
                <input class="form-control" type="text" id="brand" name="brand" placeholder="" required="required"><br>
            </div>
            <div class="col-sm-4">  
                <label for="model" class="form-label"><span class="text-danger">*</span> Modell:</label><br>
                <input class="form-control" type="text" id="model" name="model" placeholder="" required="required"><br>
            </div>
            <div class="col-sm-4">  
                <label for="year" class="form-label"><span class="text-danger">*</span> Årsmodell:</label><br>
                <input class="form-control" type="text" id="year" name="year" placeholder="" required="required"><br>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <label for="license" class="form-label"><span class="text-danger">*</span> Registernummer:</label><br>
                <input class="form-control" type="text" id="license" name="license" placeholder="ABC-123" required="required"><br>
            </div>
            <div class="col-sm-4">  
                <label for="mileage" class="form-label"><span class="text-danger">*</span> Miltal (km):</label><br>
                <input class="form-control" type="text" id="mileage" name="mileage" placeholder="" required="required"><br>
            </div>
            <div class="col-sm-4">  
                <label for="price" class="form-label"><span class="text-danger">*</span> Pris (€):</label><br>
                <input class="form-control" type="text" id="price" name="price" placeholder="" required="required"><br>
            </div>
        </div>

        <label for="inspection" class="form-label">Senaste besiktningen:</label><br>
        <input class="form-control" type="date" id="inspection" name="inspection"><br>

        <label for="weight" class="form-label">Vikt (kg):</label><br>
        <input class="form-control" type="text" id="weight" name="weight" placeholder=""><br>        

        <label for="displacement" class="form-label">Slagvolym (l):</label><br>
        <input class="form-control" type="text" id="displacement" name="displacement" placeholder=""><br>

        <label for="power" class="form-label">Effekt (hk):</label><br>
        <input class="form-control" type="text" id="horsepower" name="horsepower" placeholder=""><br>

        <label for="consumption" class="form-label">Genomsnittlig förbrukning (l/100 km):</label><br>
        <input class="form-control" type="text" id="consumption" name="consumption"><br>

        <label for="emissions" class="form-label">CO2-utsläpp (g/km):</label><br>
        <input class="form-control" type="text" id="emissions" name="emissions"><br>


        <div class="row">
            <div class="col-sm-6 col-md-3">
                <label for="fuel" class="form-label"><span class="text-danger">*</span> Drivmedel:</label><br>
                <select class="form-select" name="fuel" id="fuel" required="required">
                    <option value="">Välj drivmedel</option>
                    <?php
                    populateAttributeField($allFuelTypes);
                    ?>
                </select><br>
            </div>
            <div class="col-sm-6 col-md-3">  
                <label for="drive-type" class="form-label"><span class="text-danger">*</span> Drivsystem:</label><br>
                <select class="form-select" name="drive-type" id="drive-type" required="required">
                    <option value="">Välj drivsystem</option>
                    <?php
                    populateAttributeField($allDriveTypes);
                    ?>
                </select><br>
            </div>
            <div class="col-sm-6 col-md-3">  
                <label for="trans-type" class="form-label"><span class="text-danger">*</span> Växellåda:</label><br>
                <select class="form-select" name="trans-type" id="trans-type" required="required">
                    <option value="">Välj växellåda</option>
                    <?php
                    populateAttributeField($allTransTypes);
                    ?>
                </select><br>
            </div>
            <div class="col-sm-6 col-md-3">  
                <label for="body-style" class="form-label"><span class="text-danger">*</span> Karossform:</label><br>
                <select class="form-select" name="body-style" id="body-style" required="required">
                    <option value="">Välj karossform</option>
                    <?php
                    populateAttributeField($allBodyStyles);
                    ?>
                </select><br>
            </div>
        </div>

        <label for="additional-info" class="form-label">Ytterligare info:</label><br>
        <textarea class="form-control" id="additional-info" name="additional-info" rows="5" cols="30"></textarea><br>

        <input class="btn btn-primary" type="submit" name="sell-car" value="Skicka">
    </form>


	<div class="row">
		<div class="col-4">
		</div>
	</div>

</div>



<?php
include_once 'includes/footer.php';
?>