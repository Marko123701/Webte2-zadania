<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once('config.php');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['day'])) {
            $day = $_GET['day'];
            read_menu_by_day($pdo, $day);
        } else {
            read_menu($pdo);
        }
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $put_vars);
        if (!isset($put_vars['id'])) {
            http_response_code(400);
            echo json_encode(array("message" => "Id parameter is required."));
            break;
        }

        if (!isset($put_vars['price'])) {
            http_response_code(400);
            echo json_encode(array("message" => "Price parameter is required."));
            break;
        }

        $price = filter_var($put_vars['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        if (!$price || $price <= 0) {
            http_response_code(400);
            echo json_encode(array("message" => "Invalid price value."));
            break;
        } else {
            $id = $put_vars['id'];
            $price = $put_vars['price'];
            modify_price($pdo, $id, $price);
        }

        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $delete_vars);
        if (!isset($put_vars['id'])) {
            http_response_code(400);
            echo json_encode(array("message" => "Id parameter is required."));
            break;
        }
        $id = $delete_vars['id'];
        delete_menu($pdo, $id);
        break;

    case 'POST':
        parse_str(file_get_contents("php://input"), $post_vars);

        // Validate required parameters
        if (!isset($post_vars['name']) || !isset($post_vars['price']) || !isset($post_vars['canteen'])) {
            http_response_code(400);
            echo json_encode(array("message" => "Missing required parameter(s)."));
            break;
        }

        // Validate price value
        $price = filter_var($post_vars['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        if (!$price || $price <= 0) {
            http_response_code(400);
            echo json_encode(array("message" => "Invalid price value."));
            break;
        }
        add_to_menu($pdo, $post_vars);
        break;
    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(['error' => 'Method Not Allowed']);
        break;
}

/**
 * READ from items
 * @param $pdo
 * @return void
 */
function read_menu($pdo)
{
    $stmt = $pdo->query('SELECT * FROM items');
    $menu = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($menu) {
        http_response_code(200); // OK
        echo json_encode($menu);
    } else {
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'Menu not found']);
    }
}

/**
 * READ item by given day from items
 * @param $pdo
 * @param $day
 * @return void
 */
function read_menu_by_day($pdo, $day)
{
    if (!isset($day)) {
        http_response_code(400);
        echo json_encode(array("message" => "Missing required parameter: day."));
        return;
    }

    $stmt = $pdo->prepare('SELECT * FROM items WHERE day = :day');
    $stmt->execute(['day' => $day]);
    $menu = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($menu) {
        http_response_code(200); // OK
        echo json_encode($menu);
    } else {
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'Menu not found for this day']);
    }
}

/**
 * Modify item price from items
 * @param $pdo
 * @param $id
 * @param $price
 * @return void
 */
function modify_price($pdo, $id, $price)
{
    $stmt = $pdo->prepare('UPDATE items SET price = :price WHERE id = :id');
    $result = $stmt->execute(['price' => $price, 'id' => $id]);

    if ($result) {
        http_response_code(200); // OK
        echo json_encode(['success' => 'Price updated']);
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Unable to update price']);
    }
}

/**
 * Delete item from items
 * @param $pdo
 * @param $id
 * @return void
 */
function delete_menu($pdo, $id)
{
    $stmt = $pdo->prepare('DELETE FROM items WHERE id = :id');
    $result = $stmt->execute(['id' => $id]);

    if ($result) {
        http_response_code(200); // OK
        echo json_encode(['success' => 'Menu deleted']);
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Unable to delete menu']);
    }
}

function add_to_menu($pdo, $post_vars)
{
    // Insert new item into database
    $stmt = $pdo->prepare('INSERT INTO items (day, name, price, canteen) VALUES (:day, :name, :price, :canteen)');
    $result = $stmt->execute(['day' => "Dayly Offer", 'name' => $post_vars['name'], 'price' => $post_vars['price'], 'canteen' => $post_vars['canteen']]);

    if ($result) {
        http_response_code(201); // Created
        echo json_encode(['success' => 'New item added']);
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Unable to add new item']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>