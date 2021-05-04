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
		$stmt->bind_param("i", $id);
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

		$sql = "UPDATE guests SET email = ?, guest1FirstName = ?, guest1LastName = ?, guest1Meal = ?, guest1DietaryNotes = ?, guest1AlcoholPref = ? WHERE id=?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ssssssi", $data["email"], $data["guest1FirstName"], $data["guest1LastName"], $data["guest1Meal"], $data["guest1DietaryNotes"], $data["guest1AlcoholPref"], $data["id"]);

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