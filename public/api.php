<?php

// header('Access-Control-Allow-Origin: *');

$servername = "localhost";
$username = "stevedia_rsvp";
$password = "gyp!WyNREk*dB2J2";
$dbname = "stevedia_rsvp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {

	header("Content-Type:application/json");

	if (isset($_GET['id']) && $_GET['id']!="") {

		$id = $_GET['id'];
		
		$sql = "SELECT * FROM guests WHERE id=?";
		$stmt = $conn->prepare($sql); 
		$stmt->bind_param("s", $id);
		$stmt->execute();

		$result = $stmt->get_result();

		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);

			echo json_encode($row);

		}
		else {
			http_response_code(404);
		}

		$stmt->close();

	}
	else {
		http_response_code(400);
	}
}

else if ($method === 'PUT') {

	header("Content-Type:application/json");

	$data = json_decode(file_get_contents("php://input"), true);

	if ($data["id"]!="") {

		$sql = "UPDATE guests SET email = ?, accepts = ?, firstName = ?, lastName = ?, meal = ?, dietaryNotes = ?, alcoholPref = ?, hasGuest = ?, guestFirstName = ?, guestLastName = ?, guestMeal = ?, guestDietaryNotes = ?, guestAlcoholPref = ?, hasChildren = ?, child1FirstName = ?, child1LastName = ?, child1Meal = ?, child1DietaryNotes = ?, child2FirstName = ?, child2LastName = ?, child2Meal = ?, child2DietaryNotes = ? WHERE id=?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sssssssssssssssssssssss", $data["email"], $data["accepts"], $data["firstName"], $data["lastName"], $data["meal"], $data["dietaryNotes"], $data["alcoholPref"], $data["hasGuest"], $data["guestFirstName"], $data["guestLastName"], $data["guestMeal"], $data["guestDietaryNotes"], $data["guestAlcoholPref"], $data["hasChildren"], $data["child1FirstName"], $data["child1LastName"], $data["child1Meal"], $data["child1DietaryNotes"], $data["child2FirstName"], $data["child2LastName"], $data["child2Meal"], $data["child2DietaryNotes"], $data["id"]);

		$stmt->execute();

		$stmt->close();

		echo json_encode($data);

	}
	else {
		http_response_code(400);
	}
}

else if ($method === 'POST') {

	header("Content-Type:application/json");

	$data = json_decode(file_get_contents("php://input"), true);

	if ($data["name"]!="" && $data["email"]!="" && $data["location"]!="") {

		$sql = "INSERT INTO guestCollect (name, email, location) VALUES (?, ?, ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sss", $data["name"], $data["email"], $data["location"]);

		$stmt->execute();

		$stmt->close();

		echo json_encode($data);

	}
	else {
		http_response_code(400);
	}
}

$conn->close();

?>