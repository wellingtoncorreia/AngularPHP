<?php
include 'config.php';

header("Access-Control-Allow-Origin: http://localhost:4200/");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        $users = [];
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        echo json_encode($users);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $username = $conn->real_escape_string($data->username);
        $email = $conn->real_escape_string($data->email);
        $password = password_hash($data->password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "User created successfully"]);
        } else {
            echo json_encode(["message" => "Error: " . $conn->error]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        $id = $conn->real_escape_string($data->id);
        $username = $conn->real_escape_string($data->username);
        $email = $conn->real_escape_string($data->email);

        $sql = "UPDATE users SET username='$username', email='$email' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "User updated successfully"]);
        } else {
            echo json_encode(["message" => "Error: " . $conn->error]);
        }
        break;

        case 'DELETE':
            $id = $conn->real_escape_string($_GET['id']);
        
            $sql = "DELETE FROM users WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["message" => "User deleted successfully"]);
            } else {
                echo json_encode(["message" => "Error: " . $conn->error]);
            }
            break;

    default:
        echo json_encode(["message" => "Method not allowed"]);
        break;
}

$conn->close();
?>
