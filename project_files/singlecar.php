<?php
include_once 'includes/config.php';	
include_once 'includes/functions.php';

$allDriveTypes = selectAttributes($pdo, 'table_drive_type');
$allFuelTypes = selectAttributes($pdo, 'table_fuel_type');
$allTransTypes = selectAttributes($pdo, 'table_trans_type');
$allBodyStyles = selectAttributes($pdo, 'table_body_style');

$currentCarId = $_GET['carid'];

$carInfo = selectSingleCar($pdo, $currentCarId);

// Replace with a placeholder if no value has been given
foreach ($carInfo as $key => &$value) {
    if ($value == 0 || $value == '' || $value == '0000-00-00') {
        if ($key === 'cars_img') {
            $value = 'car-placeholder.webp'; 
        } else { 
            $value = '-';  
        } 
    }
}

include_once 'includes/header.php';
//var_dump($carInfo);
?>

<div class="container main-content">

<a href='index.php' class='btn btn-secondary mt-3 mb-4 me-1'>Tillbaka</a>

    <div class="row d-flex justify-content-center mt-3">
        <div class="col-md-9 d-flex flex-column justify-content-center">
            <img src='img/<?php echo $carInfo['cars_img'] ?>' class='img-fluid' alt='...'>
        </div>
    </div>
    
    
    <div class="row d-flex justify-content-center">
        <div class="col">
            <h1 class="text-center mt-3 mb-4">
                <?php 
                    $formatedPriceNumber = number_format($carInfo['cars_price'], 0, ',', ' '); 
                    echo "<span class='fw-bold d-flex'>{$carInfo['cars_brand']} {$carInfo['cars_model']} <span class='ms-auto'>{$formatedPriceNumber} €</span></span>"; 
                ?>
            </h1>
        </div>
    </div>


    <div class="row d-lg-none mt-2 gy-0 gx-5">
        <div class="col-md-6">
            <span class="d-flex fw-bold">Årsmodell <span class="fw-normal ms-auto"><?php echo $carInfo['cars_model_year'] ?></span></span>
            <span class="d-flex fw-bold">Växelåda <span class="fw-normal ms-auto"><?php echo $carInfo['transtype'] ?></span></span>
            <span class="d-flex fw-bold">Miltal <span class="fw-normal ms-auto"><?php echo $carInfo['cars_mileage'] ?> km</span></span>
            <span class="d-flex fw-bold">Drivmedel <span class="fw-normal ms-auto"><?php echo $carInfo['fueltype'] ?></span></span>
            <span class="d-flex fw-bold">Registernummer <span class="fw-normal ms-auto"><?php echo $carInfo['cars_license'] ?></span></span>
            <span class="d-flex fw-bold">Drivsystem <span class="fw-normal ms-auto"><?php echo $carInfo['drivetype'] ?></span></span>
            <span class="d-flex fw-bold">Effekt (hk) <span class="fw-normal ms-auto"><?php echo $carInfo['cars_hp'] ?></span></span>
        </div>
        <div class="col-md-6">
            <span class="d-flex fw-bold">Snittförbrukning <span class="fw-normal ms-auto"><?php echo $carInfo['cars_consumption']; if($carInfo['cars_consumption'] !== '-'){echo ' l/100 km';} ?></span></span>
            <span class="d-flex fw-bold">Vikt <span class="fw-normal ms-auto"><?php echo $carInfo['cars_weight']; if($carInfo['cars_weight'] !== '-'){echo ' km';} ?></span></span>
            <span class="d-flex fw-bold">Slagvolym <span class="fw-normal ms-auto"><?php echo $carInfo['cars_displacement']; if($carInfo['cars_displacement'] !== '-'){echo ' l';} ?></span></span>
            <span class="d-flex fw-bold">CO2-utsläpp <span class="fw-normal ms-auto"><?php echo $carInfo['cars_emissions']; if($carInfo['cars_emissions'] !== '-'){echo ' g/km';} ?></span></span>
            <span class="d-flex fw-bold">Senaste besiktningen <span class="fw-normal ms-auto"><?php echo $carInfo['cars_inspection_date'] ?></span></span>
            <span class="d-flex fw-bold">Karossform <span class="fw-normal ms-auto"><?php echo $carInfo['bodystyle'] ?></span></span>
        </div>
    </div>

    <div class="row d-none d-lg-flex mt-2 gy-1 gx-5">
        <div class="col-lg-4">
            <span class="d-flex fw-bold">Årsmodell <span class="fw-normal ms-auto"><?php echo $carInfo['cars_model_year'] ?></span></span>
            <span class="d-flex fw-bold">Växelåda <span class="fw-normal ms-auto"><?php echo $carInfo['transtype'] ?></span></span>
            <span class="d-flex fw-bold">Miltal <span class="fw-normal ms-auto"><?php echo $carInfo['cars_mileage'] ?> km</span></span>
            <span class="d-flex fw-bold">Drivmedel <span class="fw-normal ms-auto"><?php echo $carInfo['fueltype'] ?></span></span>
            <span class="d-flex fw-bold">Registernummer <span class="fw-normal ms-auto"><?php echo $carInfo['cars_license'] ?></span></span>
        </div>
        <div class="col-lg-4">
            <span class="d-flex fw-bold">Drivsystem <span class="fw-normal ms-auto"><?php echo $carInfo['drivetype'] ?></span></span>
            <span class="d-flex fw-bold">Effekt (hk) <span class="fw-normal ms-auto"><?php echo $carInfo['cars_hp'] ?></span></span>
            <span class="d-flex fw-bold">Snittförbrukning <span class="fw-normal ms-auto"><?php echo $carInfo['cars_consumption']; if($carInfo['cars_consumption'] !== '-'){echo ' l/100 km';} ?></span></span>
            <span class="d-flex fw-bold">Vikt<span class="fw-normal ms-auto"><?php echo $carInfo['cars_weight']; if($carInfo['cars_weight'] !== '-'){echo ' km';} ?></span></span>
            <span class="d-flex fw-bold">Slagvolym <span class="fw-normal ms-auto"><?php echo $carInfo['cars_displacement']; if($carInfo['cars_displacement'] !== '-'){echo ' l';} ?></span></span>
        </div>
        <div class="col-lg-4">
            <span class="d-flex fw-bold">CO2-utsläpp <span class="fw-normal ms-auto"><?php echo $carInfo['cars_emissions']; if($carInfo['cars_emissions'] !== '-'){echo ' g/km';} ?></span></span>
            <span class="d-flex fw-bold">Senaste besiktningen <span class="fw-normal ms-auto"><?php echo $carInfo['cars_inspection_date'] ?></span></span>
            <span class="d-flex fw-bold">Karossform <span class="fw-normal ms-auto"><?php echo $carInfo['bodystyle'] ?></span></span>
        </div>
    </div>

    <h2 class="h4 mt-5">Ytterligare information:</h2>
    <p class="mt-3">
        <?php 
            if ($carInfo['cars_description'] == "-") {
                echo "<span class='fst-italic'>Ingen information har angetts ...</span>";
            } else {
                echo $carInfo['cars_description'];
            }
        ?>
    </p>
    

</div>


<?php
include_once 'includes/footer.php';
?>