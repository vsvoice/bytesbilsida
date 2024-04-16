<?php

function selectAllCars($pdo) {
	//$allCarsArray = $pdo->query('SELECT * FROM table_cars')->fetchAll();
	$allCarsArray = $pdo->query("SELECT table_cars.*, table_drive_type.drive_type_name AS drivetype, table_fuel_type.fuel_type_name AS fueltype, table_trans_type.trans_type_name AS transtype, table_body_style.body_style_name AS bodystyle
	FROM table_cars
	LEFT JOIN table_drive_type ON table_cars.cars_drivetype_fk = table_drive_type.drive_type_id
	LEFT JOIN table_fuel_type ON table_cars.cars_fueltype_fk = table_fuel_type.fuel_type_id
	LEFT JOIN table_trans_type ON table_cars.cars_transtype_fk = table_trans_type.trans_type_id
	LEFT JOIN table_body_style ON table_cars.cars_body_style_fk = table_body_style.body_style_id
	WHERE cars_sale_status = 0")->fetchAll();
	return $allCarsArray;
}

function filterCars($pdo) {

	$where_conditions = array();

	// Check if any of the <select> elements were submitted
	if(isset($_POST['fuel']) && $_POST['fuel'] != '') {
		$fuelType = $_POST['fuel'];
		$where_conditions[] = "cars_fueltype_fk = '$fuelType'";
	}
	if(isset($_POST['drive-type']) && $_POST['drive-type'] != '') {
		$driveType = $_POST['drive-type'];
		$where_conditions[] = "cars_drivetype_fk = '$driveType'";
	}
	if(isset($_POST['trans-type']) && $_POST['trans-type'] != '') {
		$transType = $_POST['trans-type'];
		$where_conditions[] = "cars_transtype_fk = '$transType'";
	}
	if(isset($_POST['body-style']) && $_POST['body-style'] != '') {
		$bodyStyle = $_POST['body-style'];
		$where_conditions[] = "cars_body_style_fk = '$bodyStyle'";
	}
	$where_conditions[] = "cars_sale_status = '0'";
	
	// Build the WHERE clause
	$where_clause = '';
	if (!empty($where_conditions)) {
		$where_clause = "WHERE " . implode(" AND ", $where_conditions);
	}

	$filterQuery = "SELECT table_cars.*, table_drive_type.drive_type_name AS drivetype, table_fuel_type.fuel_type_name AS fueltype, table_trans_type.trans_type_name AS transtype, table_body_style.body_style_name AS bodystyle 
	FROM table_cars 
	LEFT JOIN table_drive_type ON table_cars.cars_drivetype_fk = table_drive_type.drive_type_id
	LEFT JOIN table_fuel_type ON table_cars.cars_fueltype_fk = table_fuel_type.fuel_type_id
	LEFT JOIN table_trans_type ON table_cars.cars_transtype_fk = table_trans_type.trans_type_id
	LEFT JOIN table_body_style ON table_cars.cars_body_style_fk = table_body_style.body_style_id 
	$where_clause";
	
	$filteredCarsArray = $pdo->query($filterQuery)->fetchAll();
	return $filteredCarsArray;
}

function sortCars($carArray, $sortBy) {
    switch ($sortBy) {
        case 'price_asc':
            $columnToSort = array_column($carArray, 'cars_price');
            array_multisort($columnToSort, SORT_ASC, $carArray);
            break;
        case 'price_desc':
            $columnToSort = array_column($carArray, 'cars_price');
            array_multisort($columnToSort, SORT_DESC, $carArray);
            break;
        case 'model_year_asc':
            $columnToSort = array_column($carArray, 'cars_model_year');
            array_multisort($columnToSort, SORT_ASC, $carArray);
            break;
        case 'model_year_desc':
            $columnToSort = array_column($carArray, 'cars_model_year');
            array_multisort($columnToSort, SORT_DESC, $carArray);
            break;
        case 'mileage_asc':
            $columnToSort = array_column($carArray, 'cars_mileage');
            array_multisort($columnToSort, SORT_ASC, $carArray);
            break;
        case 'mileage_desc':
            $columnToSort = array_column($carArray, 'cars_mileage');
            array_multisort($columnToSort, SORT_DESC, $carArray);
            break;
        default:
            $columnToSort = array_column($carArray, 'cars_id');
            array_multisort($columnToSort, SORT_DESC, $carArray);
            break;
    }
    return $carArray;
}

function populateCarField($carArray) {
	foreach ($carArray as $car) {
		$formatedPriceNumber = number_format($car['cars_price'], 0, ',', ' ');
		$carImageFileName = "car-placeholder.webp";

		if (!empty($car['cars_img'])) {
			$carImageFileName = $car['cars_img'];
		}
		echo "<div class='col-sm-6 col-lg-4 d-flex flex-align-stretch'>
		<div class='card' style=''>
			<img src='img/{$carImageFileName}' class='card-img-top' alt='...'>
			<div class='card-body d-flex flex-column'>
				<h5 class='card-title d-flex fw-bold'>{$car['cars_brand']} {$car['cars_model']} <span class='ms-auto'>{$car['cars_model_year']}</span></h5>
				<p class='card-text my-auto'>{$car['cars_mileage']} km | {$car['fueltype']} | {$car['drivetype']} | {$car['transtype']} | {$car['bodystyle']}</p>
				<p class='h5 fw-bold ms-auto mt-auto'>{$formatedPriceNumber} €</p>
				<div class='d-flex'> 
					<a href='editcar.php?carid={$car['cars_id']}' class='btn btn-warning fw-semibold'>REDIGERA</a>
					<a href='singlecar.php?carid={$car['cars_id']}' class='btn btn-primary fw-semibold ms-auto'>VISA BIL</a>
				</div>
			</div>
		</div>
	</div>";
	}
	return count($carArray);
}


function selectSingleCar($pdo, $currentId) {

	$stmt_getCarData = $pdo->prepare("SELECT table_cars.*, table_drive_type.drive_type_name AS drivetype, table_fuel_type.fuel_type_name AS fueltype, table_trans_type.trans_type_name AS transtype, table_body_style.body_style_name AS bodystyle
	FROM table_cars
	LEFT JOIN table_drive_type ON table_cars.cars_drivetype_fk = table_drive_type.drive_type_id
	LEFT JOIN table_fuel_type ON table_cars.cars_fueltype_fk = table_fuel_type.fuel_type_id
	LEFT JOIN table_trans_type ON table_cars.cars_transtype_fk = table_trans_type.trans_type_id
	LEFT JOIN table_body_style ON table_cars.cars_body_style_fk = table_body_style.body_style_id 
	WHERE cars_id = :id");
	$stmt_getCarData->bindParam(':id', $currentId, PDO::PARAM_INT);
	$stmt_getCarData->execute();
	return $stmt_getCarData->fetch();
}



function selectExistingOwners($pdo) {
	$allOwnersArray = $pdo->query('SELECT * FROM table_owner')->fetchAll();
	return $allOwnersArray;
}

function populateOwnerField($owners, $carInfo = NULL) {
	$counter = 1;
	foreach ($owners as $owner) {
		$selected = '';
		if ($carInfo['cars_owner_fk'] == $counter) {
			$selected = 'selected';
		}
		echo "<option value='{$owner['owner_id']}' {$selected}>{$owner['owner_fname']} {$owner['owner_lname']}</option>";
		$counter++;
	}
}


function sanitizeInput() {
	$_POST = array_map('trim', $_POST);
	$_POST = array_map('stripslashes', $_POST);
	$_POST = array_map('htmlspecialchars', $_POST);
}


function selectAttributes($pdo, $attributeTable) {
	$attributesQuery = "SELECT * FROM $attributeTable";
	$attributesArray = $pdo->query($attributesQuery)->fetchAll();
	return $attributesArray;
}



function populateAttributeField($attributes, $carInfo = NULL) {
	
	// Get the keys of the array so they can be accessed using index instead if key names
	$keys = array_keys($attributes[0]);

	$counter = 1;
	foreach ($attributes as $attribute) {
		$selected = '';
		if ($keys[0] === "fuel_type_id" && isset($_POST['fuel']) && $_POST['fuel'] == $counter 
		|| $keys[0] === "drive_type_id" && isset($_POST['drive-type']) && $_POST['drive-type'] == $counter 
		|| $keys[0] === "trans_type_id" && isset($_POST['trans-type']) && $_POST['trans-type'] == $counter 
		|| $keys[0] === "body_style_id" && isset($_POST['body-style']) && $_POST['body-style'] == $counter
		|| $keys[0] === "fuel_type_id" && isset($carInfo['cars_fueltype_fk']) && $carInfo['cars_fueltype_fk'] == $counter 
		|| $keys[0] === "drive_type_id" && isset($carInfo['cars_drivetype_fk']) && $carInfo['cars_drivetype_fk'] == $counter 
		|| $keys[0] === "trans_type_id" && isset($carInfo['cars_transtype_fk']) && $carInfo['cars_transtype_fk'] == $counter 
		|| $keys[0] === "body_style_id" && isset($carInfo['cars_body_style_fk']) && $carInfo['cars_body_style_fk'] == $counter) 
		{
			$selected = 'selected';
		}

		echo "<option value='{$attribute[$keys[0]]}' {$selected}>{$attribute[$keys[1]]}</option>";
		$counter++;
	}
}



function insertNewOwner($pdo) {
	$stmt_insertNewOwner = $pdo->prepare('INSERT INTO table_owner (owner_fname, owner_lname, owner_address, owner_zip, owner_city, owner_phone, owner_email) 
	VALUES 
	(:fname, :lname, :address, :zip, :city, :phone, :email)');
	$stmt_insertNewOwner->bindParam(':fname', $_POST['fname'], PDO::PARAM_STR);
	$stmt_insertNewOwner->bindParam(':lname', $_POST['lname'], PDO::PARAM_STR);
	$stmt_insertNewOwner->bindParam(':address', $_POST['address'], PDO::PARAM_STR);
	$stmt_insertNewOwner->bindParam(':zip', $_POST['zip'], PDO::PARAM_STR);
	$stmt_insertNewOwner->bindParam(':city', $_POST['city'], PDO::PARAM_STR);
	$stmt_insertNewOwner->bindParam(':phone', $_POST['phone'], PDO::PARAM_STR);
	$stmt_insertNewOwner->bindParam(':email', $_POST['email'], PDO::PARAM_STR);

	if($stmt_insertNewOwner->execute()) {
		return "<p class='text-success fst-italic'>Ägaren har sparats i systemet</p>";
	} else {
		return "<p class='text-danger fst-italic'>Något blev fel. Lyckades inte spara ägaren.</p>";
	}
}

function insertNewCar($pdo) {

	$imageError = validateImageUpload();

	if (!empty($imageError)) {
		return $imageError;
	}

	$stmt_insertNewCar = $pdo->prepare('INSERT INTO table_cars (cars_model, cars_brand, cars_mileage, cars_model_year, cars_price, cars_hp, cars_displacement, cars_license, cars_inspection_date, cars_consumption, cars_emissions, cars_weight, cars_description, cars_img, cars_owner_fk, cars_drivetype_fk, cars_fueltype_fk, cars_transtype_fk, cars_body_style_fk) 
	VALUES 
	(:model, :brand, :mileage, :model_year, :price, :hp, :displacement, :license, :inspection_date, :consumption, :emissions, :weight, :description, :car_img , :owner, :drivetype, :fueltype, :transtype, :bodystyle)');
	if (isset($_FILES["car-img"]["name"])) {
		$carImage = basename($_FILES["car-img"]["name"]);
		$stmt_insertNewCar->bindParam(':car_img', $carImage, PDO::PARAM_STR);
	}
	$stmt_insertNewCar->bindParam(':model', $_POST['model'], PDO::PARAM_STR);
	$stmt_insertNewCar->bindParam(':brand', $_POST['brand'], PDO::PARAM_STR);
	$stmt_insertNewCar->bindParam(':mileage', $_POST['mileage'], PDO::PARAM_INT);
	$stmt_insertNewCar->bindParam(':model_year', $_POST['year'], PDO::PARAM_STR);
	$stmt_insertNewCar->bindParam(':price', $_POST['price'], PDO::PARAM_STR);
	$stmt_insertNewCar->bindParam(':hp', $_POST['horsepower'], PDO::PARAM_INT);
	$stmt_insertNewCar->bindParam(':displacement', $_POST['displacement'], PDO::PARAM_STR);
	$stmt_insertNewCar->bindParam(':license', $_POST['license'], PDO::PARAM_STR);
	$stmt_insertNewCar->bindParam(':inspection_date', $_POST['inspection'], PDO::PARAM_STR);
	$stmt_insertNewCar->bindParam(':consumption', $_POST['consumption'], PDO::PARAM_STR);
	$stmt_insertNewCar->bindParam(':emissions', $_POST['emissions'], PDO::PARAM_INT);
	$stmt_insertNewCar->bindParam(':weight', $_POST['weight'], PDO::PARAM_INT);
	$stmt_insertNewCar->bindParam(':fueltype', $_POST['fuel'], PDO::PARAM_INT);
	$stmt_insertNewCar->bindParam(':drivetype', $_POST['drive-type'], PDO::PARAM_INT);
	$stmt_insertNewCar->bindParam(':transtype', $_POST['trans-type'], PDO::PARAM_INT);
	$stmt_insertNewCar->bindParam(':bodystyle', $_POST['body-style'], PDO::PARAM_INT);
	$stmt_insertNewCar->bindParam(':description', $_POST['additional-info'], PDO::PARAM_STR);
	$stmt_insertNewCar->bindParam(':owner', $_POST['existing-customer'], PDO::PARAM_INT);

	if($stmt_insertNewCar->execute()) {
		return "<p class='text-success fst-italic'>Bilen har sparats i systemet</p>";
	} else {
		return "<p class='text-danger fst-italic'>Något blev fel. Lyckades inte spara bilen.</p>";
	}
}

function validateImageUpload() {
	// Check if the image file exists and is uploaded successfully
	if(isset($_FILES["car-img"]["name"]) && !empty($_FILES["car-img"]["name"])) {
		$target_dir = "img/";
		$target_file = $target_dir . basename($_FILES["car-img"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["car-img"]["tmp_name"]);
		if($check === false) {
			return "<p class='text-danger fst-italic'>Bildfel. Filen är inte en bild.</p>";
		}

		// Check if file already exists
		if (file_exists($target_file)) {
			return "<p class='text-danger fst-italic'>Bildfel. Filen finns redan.</p>";
		}

		// Check file size
		if ($_FILES["car-img"]["size"] > 15000000) {
			return "<p class='text-danger fst-italic'>Bildfel. Filen är för stor.</p>";
		}

		// Allow certain file formats
		if(!in_array($imageFileType, ["jpg", "png", "jpeg", "gif", "webp"])) {
			return "<p class='text-danger fst-italic'>Bildfel. Enbart filtyperna JPG, JPEG, PNG, WEBP & GIF är tillåtna.</p>";
		}

		// Check if the file is uploaded successfully
		if (!move_uploaded_file($_FILES["car-img"]["tmp_name"], $target_file)) {
			return "<p class='text-danger fst-italic'>Bildfel. Ett fel inträffade vid filuppladdningen.</p>";
		}
	}/* else {
		// If no image file is uploaded, return an error
		return "<p class='text-danger fst-italic'>Ingen bild har laddats upp.</p>";
	}*/
}

function editExistingCar($pdo) {

	//var_dump($_FILES["car-img"]["name"]);

	$imageError = validateImageUpload();

	if (!empty($imageError)) {
		return $imageError;
	}

	if(isset($_POST['sale-status'])) {
		$saleStatus = TRUE;
	} else {
		$saleStatus = FALSE;
	}

	$stmt_editExistingCar = $pdo->prepare('
	UPDATE table_cars
	SET cars_model = :model, cars_brand = :brand, cars_mileage = :mileage, cars_model_year = :model_year, cars_price = :price, cars_hp = :hp, cars_displacement = :displacement, cars_license = :license, cars_inspection_date = :inspection_date, cars_consumption = :consumption, cars_emissions = :emissions, cars_weight = :weight, cars_description = :description, cars_img = :car_img, cars_owner_fk = :owner, cars_drivetype_fk = :drivetype, cars_fueltype_fk = :fueltype, cars_transtype_fk = :transtype, cars_body_style_fk = :bodystyle, cars_sale_status = :salestatus
	WHERE cars_id = :id');
	if (isset($_FILES["car-img"]["name"])) {
		$carImage = basename($_FILES["car-img"]["name"]);
		$stmt_editExistingCar->bindParam(':car_img', $carImage, PDO::PARAM_STR);
	}
	$stmt_editExistingCar->bindParam(':model', $_POST['model'], PDO::PARAM_STR);
	$stmt_editExistingCar->bindParam(':brand', $_POST['brand'], PDO::PARAM_STR);
	$stmt_editExistingCar->bindParam(':mileage', $_POST['mileage'], PDO::PARAM_INT);
	$stmt_editExistingCar->bindParam(':model_year', $_POST['year'], PDO::PARAM_STR);
	$stmt_editExistingCar->bindParam(':price', $_POST['price'], PDO::PARAM_STR);
	$stmt_editExistingCar->bindParam(':hp', $_POST['horsepower'], PDO::PARAM_INT);
	$stmt_editExistingCar->bindParam(':displacement', $_POST['displacement'], PDO::PARAM_STR);
	$stmt_editExistingCar->bindParam(':license', $_POST['license'], PDO::PARAM_STR);
	$stmt_editExistingCar->bindParam(':inspection_date', $_POST['inspection'], PDO::PARAM_STR);
	$stmt_editExistingCar->bindParam(':consumption', $_POST['consumption'], PDO::PARAM_STR);
	$stmt_editExistingCar->bindParam(':emissions', $_POST['emissions'], PDO::PARAM_INT);
	$stmt_editExistingCar->bindParam(':weight', $_POST['weight'], PDO::PARAM_INT);
	$stmt_editExistingCar->bindParam(':fueltype', $_POST['fuel'], PDO::PARAM_INT);
	$stmt_editExistingCar->bindParam(':drivetype', $_POST['drive-type'], PDO::PARAM_INT);
	$stmt_editExistingCar->bindParam(':transtype', $_POST['trans-type'], PDO::PARAM_INT);
	$stmt_editExistingCar->bindParam(':bodystyle', $_POST['body-style'], PDO::PARAM_INT);
	$stmt_editExistingCar->bindParam(':description', $_POST['additional-info'], PDO::PARAM_STR);
	$stmt_editExistingCar->bindParam(':owner', $_POST['existing-customer'], PDO::PARAM_INT);
	$stmt_editExistingCar->bindParam(':salestatus', $saleStatus, PDO::PARAM_BOOL);
	$stmt_editExistingCar->bindParam(':id', $_GET['carid'], PDO::PARAM_INT);

	if($stmt_editExistingCar->execute()) {
		return "<p class='text-success fst-italic'>Bilens info har uppdaterats i systemet</p>";
	} else {
		return "<p class='text-danger fst-italic'>Något blev fel. Lyckades inte uppdatera bilens info.</p>";
	}
}


function addAttribute($pdo, $attributeTable) {
	// Insert data into only the second column, not the first
	$stmt_addAttribute = $pdo->prepare("INSERT INTO $attributeTable VALUES (NULL, :new_attribute)");
	$stmt_addAttribute->bindParam(':new_attribute', $_POST['new-attribute'], PDO::PARAM_STR);

	if($stmt_addAttribute->execute()) {
		return "<p class='text-success fst-italic'>Alternativet har lagts till</p>";
	} else {
		return "<p class='text-danger fst-italic'>Något blev fel. Lyckades inte lägga till alternativet.</p>";
	}
}



function editAttribute($pdo, $attributeTable, $nameOfColumns, $attributeId, $currentOption) {
	if (empty($_POST['edited-attribute'])) {
		return "<p class='text-danger fst-italic'>Inget namn har angetts. Fyll i fältet för att redigera namnet.</p>";
	}
	$stmt_editAttribute = $pdo->prepare("UPDATE $attributeTable
	SET $nameOfColumns[1] = :attribute_name
	WHERE $nameOfColumns[0] = :id");
	$stmt_editAttribute->bindParam(':attribute_name', $_POST['edited-attribute'], PDO::PARAM_STR);
	$stmt_editAttribute->bindParam(':id', $attributeId, PDO::PARAM_INT);
	if($stmt_editAttribute->execute()) {
		header("Location: listattributes.php?option={$currentOption}");
		exit();
	} else {
		return "<p class='text-danger fst-italic'>Något blev fel. Lyckades inte byta namn på alternativet.</p>";
	}
}

function deleteAttribute($pdo, $attributeTable, $nameOfColumns, $attributeId, $currentOption) {
	/*if (empty($_POST['edited-attribute'])) {
		return "<p class='text-danger fst-italic'>Inget namn har angetts. Fyll i fältet för att redigera namnet.</p>";
	}*/
	$stmt_deleteAttribute = $pdo->prepare("DELETE FROM $attributeTable
	WHERE $nameOfColumns[0] = :id");
	$stmt_deleteAttribute->bindParam(':id', $attributeId, PDO::PARAM_INT);
	if($stmt_deleteAttribute->execute()) {
		header("Location: listattributes.php?option={$currentOption}");
		exit();
	} else {
		return "<p class='text-danger fst-italic'>Något blev fel. Lyckades inte ta bort alternativet.</p>";
	}
}















/*
function addOrder($pdo) {
	$stmt_insertCustomer = $pdo->prepare('INSERT INTO pizza_customers (cust_fname, cust_lname, cust_phone, cust_address, cust_zip, cust_city, cust_email) 
	VALUES 
	(:fname, :lname, :phone, :address, :zip, :city, :email)');
	$stmt_insertCustomer->bindParam(':fname', $_POST['fname'], PDO::PARAM_STR);
	$stmt_insertCustomer->bindParam(':lname', $_POST['lname'], PDO::PARAM_STR);
	$stmt_insertCustomer->bindParam(':phone', $_POST['phone'], PDO::PARAM_STR);
	$stmt_insertCustomer->bindParam(':address', $_POST['address'], PDO::PARAM_STR);
	$stmt_insertCustomer->bindParam(':zip', $_POST['zip'], PDO::PARAM_STR);
	$stmt_insertCustomer->bindParam(':city', $_POST['city'], PDO::PARAM_STR);
	$stmt_insertCustomer->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
	$stmt_insertCustomer->execute();
	//$user = $stmt_insertCustomer->fetch();

	$last_id = $pdo->lastInsertId();
	
	$stmt_insertOrder = $pdo->prepare('INSERT INTO pizza_orders (pizza_topping_1_fk, pizza_topping_2_fk, pizza_topping_3_fk, pizza_topping_4_fk, pizza_delivery, customer_fk, pizza_oregano, pizza_garlic, pizza_gluten, pizza_size_fk, order_info, order_status_fk) 
	VALUES 
	(:pizza_topping_1_fk, :pizza_topping_2_fk, :pizza_topping_3_fk, :pizza_topping_4_fk, :pizza_delivery, :customer_fk, :pizza_oregano, :pizza_garlic, :pizza_gluten, :pizza_size_fk, :order_info, 1)');
	$stmt_insertOrder->bindParam(':pizza_topping_1_fk', $_SESSION['topping1'], PDO::PARAM_INT);
	$stmt_insertOrder->bindParam(':pizza_topping_2_fk', $_SESSION['topping2'], PDO::PARAM_INT);
	$stmt_insertOrder->bindParam(':pizza_topping_3_fk', $_SESSION['topping3'], PDO::PARAM_INT);
	$stmt_insertOrder->bindParam(':pizza_topping_4_fk', $_SESSION['topping4'], PDO::PARAM_INT);
	$stmt_insertOrder->bindParam(':pizza_delivery', $_SESSION['delivery'], PDO::PARAM_BOOL);
	$stmt_insertOrder->bindParam(':customer_fk', $last_id, PDO::PARAM_INT);
	$stmt_insertOrder->bindParam(':pizza_oregano', $_SESSION['oregano'], PDO::PARAM_BOOL);
	$stmt_insertOrder->bindParam(':pizza_garlic', $_SESSION['garlic'], PDO::PARAM_BOOL);
	$stmt_insertOrder->bindParam(':pizza_gluten', $_SESSION['allergy1'], PDO::PARAM_BOOL);
	$stmt_insertOrder->bindParam(':pizza_size_fk', $_SESSION['size'], PDO::PARAM_INT);
	$stmt_insertOrder->bindParam(':order_info', $_SESSION['additional-info'], PDO::PARAM_STR);
	
	if($stmt_insertOrder->execute()) {
		return "Bestälningen lyckades";
	} else {
		return "Något blev fel";
	}
	
}

function updateOrderStatus($pdo) {
	$stmt_updateOrderStatus = $pdo->prepare("
	UPDATE pizza_orders 
	SET order_status_fk = :newStatus 
	WHERE pizza_id = :currentId");
	$stmt_updateOrderStatus->bindParam(':newStatus', $_POST['order-status']);
	$stmt_updateOrderStatus->bindParam(':currentId', $_POST['cust-id']);
	
	if($stmt_updateOrderStatus->execute()) {
		return "<p class='text-success fst-italic'>Uppdatering av beställningsstatus lyckades</p>";
	} else {
		return "<p>Något blev fel</p>";
	}
}

function selectNodeInfo($pdo, $currentId) {

	$stmt_getNodeData = $pdo->prepare('SELECT * FROM pizza_pages WHERE page_id = :id');
	$stmt_getNodeData->bindParam(':id', $currentId, PDO::PARAM_INT);
	$stmt_getNodeData->execute();
	return $stmt_getNodeData->fetch();
}

function editNode($pdo, $currentId) {
	$stmt_editNodeData = $pdo->prepare('
	UPDATE pizza_pages
	SET page_heading = :pheading, page_text = :ptext
	WHERE page_id = :id');
	$stmt_editNodeData->bindParam(':id', $currentId, PDO::PARAM_INT);
	$stmt_editNodeData->bindParam(':pheading', $_POST['heading'], PDO::PARAM_STR);
	$stmt_editNodeData->bindParam(':ptext', $_POST['page-text'], PDO::PARAM_STR);
	$stmt_editNodeData->execute();

	if($stmt_editNodeData->execute()) {
		return "<p class='text-success fst-italic'>Uppdatering av innehåll lyckades</p>";
	} else {
		return "<p>Något blev fel</p>";
	}

}
*/

?>