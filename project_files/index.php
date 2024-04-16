<?php
include_once 'includes/config.php';	
include_once 'includes/functions.php';

$allDriveTypes = selectAttributes($pdo, 'table_drive_type');
$allFuelTypes = selectAttributes($pdo, 'table_fuel_type');
$allTransTypes = selectAttributes($pdo, 'table_trans_type');
$allBodyStyles = selectAttributes($pdo, 'table_body_style');

$carsArray;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$carsArray = filterCars($pdo);
	if (isset($_POST['sort-by']) && !empty($_POST['sort-by'])) {
		$carsArray = sortCars($carsArray, $_POST['sort-by']);
	}
} else {
	$carsArray = selectAllCars($pdo);
}

include_once 'includes/header.php';
?>

<div class="container mt-5">
	<?php
	//var_dump($_POST);
	?>
	<p>Sökresultat: <?php echo count($carsArray);?> st</p>

	<form action="" method="post">
		<div class="row mb-3 g-4">

			<div class="col-sm-6 col-md-3">
				<label for="fuel" class="form-label">Drivmedel</label><br> 
				<select class="form-select" onchange="this.form.submit();" name="fuel" id="fuel">
					<option value="">Välj drivmedel</option>
					<?php
					populateAttributeField($allFuelTypes);
					?>
				</select>
				<a href='addattributes.php?option=fueltype' class='btn btn-warning fw-semibold my-2'>Lägg till</a><br>
				<a href='listattributes.php?option=fueltype' class='btn btn-warning fw-semibold'>Redigera/Ta bort</a><br>
			</div>

			<div class="col-sm-6 col-md-3">  
				<label for="drive-type" class="form-label">Drivsystem</label><br>
				<select class="form-select" onchange="this.form.submit();" name="drive-type" id="drive-type">
					<option value="">Välj drivsystem</option>
					<?php
					populateAttributeField($allDriveTypes);
					?>
				</select>
				<a href='addattributes.php?option=drivetype' class='btn btn-warning fw-semibold my-2'>Lägg till</a><br>
				<a href='listattributes.php?option=drivetype' class='btn btn-warning fw-semibold'>Redigera/Ta bort</a><br>
			</div>

			<div class="col-sm-6 col-md-3">  
				<label for="trans-type" class="form-label">Växellåda</label><br>
				<select class="form-select" onchange="this.form.submit();" name="trans-type" id="trans-type">
					<option value="">Välj växellåda</option>
					<?php
					populateAttributeField($allTransTypes);
					?>
				</select>
				<a href='addattributes.php?option=transtype' class='btn btn-warning fw-semibold my-2'>Lägg till</a><br>
				<a href='listattributes.php?option=transtype' class='btn btn-warning fw-semibold'>Redigera/Ta bort</a><br>
			</div>

			<div class="col-sm-6 col-md-3">  
				<label for="body-style" class="form-label">Karossform</label><br>
				<select class="form-select" onchange="this.form.submit();" name="body-style" id="body-style">
					<option value="">Välj karossform</option>
					<?php
					populateAttributeField($allBodyStyles);
					?>
				</select>
				<a href='addattributes.php?option=bodystyle' class='btn btn-warning fw-semibold my-2'>Lägg till</a><br>
				<a href='listattributes.php?option=bodystyle' class='btn btn-warning fw-semibold'>Redigera/Ta bort</a><br>

			</div>

		</div>

		<div class="row">
			<div class="col-sm-6 col-md-4 col-lg-3 col-xxl-2 mt-2">
			<label for="body-style" class="form-label">Sortera enligt:</label><br>
				<select class="form-select" onchange="this.form.submit();" name="sort-by" id="sort-by">
					<option value="">Sortera</option>
					<option value="price_asc" <?php if(isset($_POST['sort-by']) && $_POST['sort-by'] == 'price_asc') echo 'selected'; ?> >Pris (stigande)</option>
					<option value="price_desc" <?php if(isset($_POST['sort-by']) && $_POST['sort-by'] == 'price_desc') echo 'selected'; ?> >Pris (fallande)</option>
					<option value="model_year_asc" <?php if(isset($_POST['sort-by']) && $_POST['sort-by'] == 'model_year_asc') echo 'selected'; ?> >Årsmodell (stigande)</option>
					<option value="model_year_desc" <?php if(isset($_POST['sort-by']) && $_POST['sort-by'] == 'model_year_desc') echo 'selected'; ?> >Årsmodell (fallande)</option>
					<option value="mileage_asc" <?php if(isset($_POST['sort-by']) && $_POST['sort-by'] == 'mileage_asc') echo 'selected'; ?> >Miltal (stigande)</option>
					<option value="mileage_desc" <?php if(isset($_POST['sort-by']) && $_POST['sort-by'] == 'mileage_desc') echo 'selected'; ?> >Miltal (fallande)</option>
				</select><br>

			</div>
		</div>

	</form>

	<div class="row gx-3 gx-md-4 gy-3 gy-md-4">

		<?php
			populateCarField($carsArray);
		?>

	</div>
</div>



<?php
include_once 'includes/footer.php';
?>