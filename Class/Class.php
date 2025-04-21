<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once __DIR__ . '/Connect.php';

function saveImage($file, $path)
{
    // Check if the file was uploaded without errors
    if (isset($file) && $file['error'] == 0) {
        $uploadDir = '../Assets/uploads/' . $path . '/'; // Directory to save the image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif']; // Allowed file types
        $fileType = $file['type'];

        // Check if the file type is allowed
        if (in_array($fileType, $allowedTypes)) {
            $fileName = uniqid() . '_' . basename($file['name']); // Generate a unique file name
            $uploadPath = $uploadDir . $fileName;

            // Create the upload directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Move the uploaded file to the upload directory
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                return $uploadPath; // Return the file path
            } else {
                throw new Exception("Failed to move uploaded file.");
            }
        } else {
            throw new Exception("Invalid file type. Only JPEG, PNG, and GIF are allowed.");
        }
    } else {
        throw new Exception("No file uploaded or there was an error uploading the file.");
    }
}

class HDC
{
    function create_hdc($_post, $_files, $path)
    {
        $conn = new Connect();
        $conn = $conn->conn;

        if ($_files['image']['name'] != '' && $_files['image']['size'] != 0) {
            $imagePath = saveImage($_files['image'], $path); // Save the image and get the file path
        }

        // Prepare SQL query to insert all required columns
        $sql = "INSERT INTO hdc (
                    titlename, firstname, lastname, hoscode_id, department_id, email, tel, urlpage, promblemdetail,
                    promlem1, promlem2, promlem3, promlem4, promlem5, promlem6, otherProblem,
                    image, detail
                ) VALUES (
                    :titlename, :firstname, :lastname, :hoscode_id, :department_id, :email, :tel, :urlpage, :promblemdetail,
                    :promlem1, :promlem2, :promlem3, :promlem4, :promlem5, :promlem6, :otherProblem,
                    :image, :detail
                )";

        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':titlename', $_post['titlename']);
        $stmt->bindParam(':firstname', $_post['firstname']);
        $stmt->bindParam(':lastname', $_post['lastname']);
        $stmt->bindParam(':hoscode_id', $_post['hoscode_id']);
        $stmt->bindParam(':department_id', $_post['department_id']);
        $stmt->bindParam(':email', $_post['email']);
        $stmt->bindParam(':tel', $_post['tel']);
        $stmt->bindParam(':urlpage', $_post['urlpage']);
        $stmt->bindParam(':promblemdetail', $_post['promblemdetail']);
        $stmt->bindParam(':promlem1', $_post['promlem1']);
        $stmt->bindParam(':promlem2', $_post['promlem2']);
        $stmt->bindParam(':promlem3', $_post['promlem3']);
        $stmt->bindParam(':promlem4', $_post['promlem4']);
        $stmt->bindParam(':promlem5', $_post['promlem5']);
        $stmt->bindParam(':promlem6', $_post['promlem6']);
        $stmt->bindParam(':otherProblem', $_post['otherProblem']);
        $stmt->bindParam(':image', $imagePath);
        $stmt->bindParam(':detail', $_post['detail']);

        // Execute the query
        if ($stmt->execute()) {
            return true;
        } else {
            // Log error if execution fails
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Database error: " . $errorInfo[2]);
        }
    }
    function get_hdc_count()
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;

            $stmt = $conn->prepare("SELECT * FROM hdc");
            $stmt->execute();
            $result = $stmt->rowCount();

            return $result;
        } catch (Exception $e) {
            throw new Exception("Error fetching HDC count: " . $e->getMessage());
        }
    }

    function get_hdc_all()
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;

            $stmt = $conn->prepare("SELECT * FROM hdc h INNER JOIN hoscode  hc ON h.hoscode_id = hc.hoscode_id INNER JOIN department d ON h.department_id = d.department_id");
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            throw new Exception("" . $e->getMessage());
        }
    }

    function get_hdc_byid($id)
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;
            $stmt = $conn->prepare("SELECT * FROM hdc INNER JOIN hoscode hc ON hdc.hoscode_id = hc.hoscode_id INNER JOIN department d ON hdc.department_id = d.department_id WHERE hdc_id = :hdc_id");
            $stmt->bindParam(":hdc_id", $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            throw new Exception("" . $e->getMessage());
        }
    }

    function change_status($status, $hdc_id)
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;

            $stmt = $conn->prepare("UPDATE hdc SET status = :status WHERE hdc_id = :hdc_id");
            $stmt->bindParam(":hdc_id", $hdc_id);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    function add_finish_detail($_post, $hdc_id)
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;
            $stmt = $conn->prepare("UPDATE hdc SET finish_detail = :finish_detail WHERE hdc_id = :hdc_id");
            $stmt->bindParam(":finish_detail", $_post["finish_detail"]);
            $stmt->bindParam(":hdc_id", $hdc_id);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}

class Web
{
    function create_web($_post, $_files, $path)
    {
        $conn = new Connect();
        $conn = $conn->conn;

        if ($_files['image']['name'] != '' && $_files['image']['size'] != 0) {
            $imagePath = saveImage($_files['image'], $path); // Save the image and get the file path
        }
        // Prepare SQL query to insert all required columns
        $sql = "INSERT INTO web (
                    titlename, firstname, lastname, hoscode_id, department_id, email, tel, urlpage, problemdetail,
                    promlem1, promlem2, promlem3, promlem4, promlem5, promlem6, otherProblem,
                    image, detail
                ) VALUES (
                    :titlename, :firstname, :lastname, :hoscode_id, :department_id, :email, :tel, :urlpage, :problemdetail,
                    :promlem1, :promlem2, :promlem3, :promlem4, :promlem5, :promlem6, :otherProblem,
                    :image, :detail
                )";

        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':titlename', $_post['titlename']);
        $stmt->bindParam(':firstname', $_post['firstname']);
        $stmt->bindParam(':lastname', $_post['lastname']);
        $stmt->bindParam(':hoscode_id', $_post['hoscode_id']);
        $stmt->bindParam(':department_id', $_post['department_id']);
        $stmt->bindParam(':email', $_post['email']);
        $stmt->bindParam(':tel', $_post['tel']);
        $stmt->bindParam(':urlpage', $_post['urlpage']);
        $stmt->bindParam(':problemdetail', $_post['problemdetail']);
        $stmt->bindParam(':promlem1', $_post['promlem1']);
        $stmt->bindParam(':promlem2', $_post['promlem2']);
        $stmt->bindParam(':promlem3', $_post['promlem3']);
        $stmt->bindParam(':promlem4', $_post['promlem4']);
        $stmt->bindParam(':promlem5', $_post['promlem5']);
        $stmt->bindParam(':promlem6', $_post['promlem6']);
        $stmt->bindParam(':otherProblem', $_post['otherProblem']);
        $stmt->bindParam(':image', $imagePath);
        $stmt->bindParam(':detail', $_post['detail']);

        // Execute the query
        if ($stmt->execute()) {
            return true;
        } else {
            // Log error if execution fails
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Database error: " . $errorInfo[2]);
        }
    }

    function get_web_count()
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;

            $stmt = $conn->prepare("SELECT * FROM web");
            $stmt->execute();
            $result = $stmt->rowCount();

            return $result;
        } catch (Exception $e) {
            throw new Exception("Error fetching HDC count: " . $e->getMessage());
        }
    }

    function get_web_all()
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;
            $stmt = $conn->prepare("SELECT * FROM web w INNER JOIN hoscode h ON w.hoscode_id = h.hoscode_id INNER JOIN department d ON w.department_id = d.department_id");
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    function get_web_byid($web_id)
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;
            $stmt = $conn->prepare("SELECT * FROM web w INNER JOIN hoscode h ON w.hoscode_id = h.hoscode_id INNER JOIN department d ON w.department_id = d.department_id WHERE web_id = :web_id");
            $stmt->bindParam(':web_id', $web_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    function change_status($status, $web_id)
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;
            $stmt = $conn->prepare('UPDATE web SET status = :status WHERE web_id = :web_id');
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':web_id', $web_id);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            throw new Exception('' . $e->getMessage());
        }
    }

    function add_finish_detail($_post, $web_id)
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;
            $stmt = $conn->prepare("UPDATE web SET finish_detail = :finish_detail WHERE web_id = :web_id");
            $stmt->bindParam(":finish_detail", $_post["finish_detail"]);
            $stmt->bindParam(":web_id", $web_id);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}

class Report
{
    function create_report($_post, $_files, $path)
    {
        $conn = new Connect();
        $conn = $conn->conn;
        if ($_files['image']['name'] != '' && $_files['image']['size'] != 0) {
            $imagePath = saveImage($_files['image'], $path);
        }

        $stmt = $conn->prepare("INSERT INTO report (titlename, firstname, lastname, hoscode_id, department_id, email, tel, reportname, reporttypedate, reportdatedetail, PDF, Excel, CSV, reporttype, reporttypedetail, reportdate, emailback, image, reportdetail) 
        VALUES (:titlename, :firstname, :lastname, :hoscode_id, :department_id, :email, :tel, :reportname, :reporttypedate, :reportdatedetail, :PDF, :Excel, :CSV, :reporttype, :reporttypedetail, :reportdate, :emailback, :image, :reportdetail)");
        $stmt->bindParam(':titlename', $_post['titlename']);
        $stmt->bindParam(':firstname', $_post['firstname']);
        $stmt->bindParam(':lastname', $_post['lastname']);
        $stmt->bindParam(':hoscode_id', $_post['hoscode_id']);
        $stmt->bindParam(':department_id', $_post['department_id']);
        $stmt->bindParam(':email', $_post['email']);
        $stmt->bindParam(':tel', $_post['tel']);
        $stmt->bindParam(':reportname', $_post['reportname']);
        $stmt->bindParam(':reporttypedate', $_post['reporttypedate']);
        $stmt->bindParam(':reportdatedetail', $_post['reportdatedetail']);
        $stmt->bindParam(':reporttype', $_post['reporttype']);
        $stmt->bindParam(':reporttypedetail', $_post['reporttypedetail']);
        $stmt->bindParam(':PDF', $_post['PDF']);
        $stmt->bindParam(':Excel', $_post['Excel']);
        $stmt->bindParam(':CSV', $_post['CSV']);
        $stmt->bindParam(':reporttype', $_post['reporttype']);
        $stmt->bindParam(':reporttypedetail', $_post['reporttypedetail']);
        $stmt->bindParam(':reportdate', $_post['reportdate']);
        $stmt->bindParam(':emailback', $_post['emailback']);
        $stmt->bindParam(':image', $imagePath);
        $stmt->bindParam('reportdetail', $_post['reportdetail']);

        if ($stmt->execute()) {
            return true;
        } else {
            $error_info = $stmt->errorInfo();
            throw new Exception("Database error: " . $error_info[2]);
        }
    }

    function get_report_count()
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;

            $stmt = $conn->prepare("SELECT * FROM report");
            $stmt->execute();
            $result = $stmt->rowCount();

            return $result;
        } catch (Exception $e) {
            throw new Exception("Error fetching HDC count: " . $e->getMessage());
        }
    }

    function get_report_all()
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;
            $stmt = $conn->prepare("SELECT * FROM report r INNER JOIN hoscode h ON r.hoscode_id = h.hoscode_id INNER JOIN department d ON r.department_id = d.department_id");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    function get_report_byid($id)
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;
            $stmt = $conn->prepare("SELECT * FROM report r INNER JOIN hoscode h ON r.hoscode_id = h.hoscode_id INNER JOIN department d ON r.department_id = d.department_id WHERE r.report_id = :report_id");
            $stmt->bindParam(":report_id", $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            throw new Exception("" . $e->getMessage());
        }
    }

    function change_status($status, $id)
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;
            $stmt = $conn->prepare("UPDATE report SET status = :status WHERE report_id = :report_id");
            $stmt->bindParam(":report_id", $id);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    function add_finish_detail($id, $_post)
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;
            $stmt = $conn->prepare("UPDATE report SET finish_detail = :finish_detail WHERE report_id = :report_id");
            $stmt->bindParam(":report_id", $id);
            $stmt->bindParam(":finish_detail", $_post['finish_detail']);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }
}

class Other
{
    function create_other($_post)
    {
        $conn = new Connect();
        $conn = $conn->conn;
        $stmt = $conn->prepare("INSERT INTO other (titlename, firstname, lastname, hoscode_id, department_id, email, tel, question)
        VALUES (:titlename, :firstname, :lastname, :hoscode_id, :department_id, :email, :tel, :question)");
        $stmt->bindParam(':titlename', $_post['titlename']);
        $stmt->bindParam(':firstname', $_post['firstname']);
        $stmt->bindParam(':lastname', $_post['lastname']);
        $stmt->bindParam(':hoscode_id', $_post['hoscode_id']);
        $stmt->bindParam(':department_id', $_post['department_id']);
        $stmt->bindParam(':email', $_post['email']);
        $stmt->bindParam(':tel', $_post['tel']);
        $stmt->bindParam(':question', $_post['question']);
        if ($stmt->execute()) {
            return true;
        } else {
            $error_info = $stmt->errorInfo();
            throw new Exception("Database error: " . $error_info[2]);
        }
    }
    function get_other_count()
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;

            $stmt = $conn->prepare("SELECT * FROM other");
            $stmt->execute();
            $result = $stmt->rowCount();

            return $result;
        } catch (Exception $e) {
            throw new Exception("Error fetching HDC count: " . $e->getMessage());
        }
    }

    function get_other_all()
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;
            $stmt = $conn->prepare("SELECT * FROM other o INNER JOIN hoscode h ON o.hoscode_id = h.hoscode_id INNER JOIN department d ON o.department_id = d.department_id");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    function get_other_byid($id)
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;
            $stmt = $conn->prepare("SELECT * FROM other o INNER JOIN hoscode h ON o.hoscode_id = h.hoscode_id INNER JOIN department d ON o.department_id = d.department_id WHERE o.other_id = :other_id");
            $stmt->bindParam(":other_id", $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    function change_status($status, $id)
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;
            $stmt = $conn->prepare("UPDATE other SET status = :status WHERE other_id = :other_id");
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":other_id", $id);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    function add_finish_detail($_post, $id)
    {
        try {
            $conn = new Connect();
            $conn = $conn->conn;
            $stmt = $conn->prepare("UPDATE other SET finish_detail = :finish_detail WHERE other_id = :other_id");
            $stmt->bindParam(":finish_detail", $_post['finish_detail']);
            $stmt->bindParam(":other_id", $id);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

}

class Admin
{
    function login($_post)
    {
        $conn = new Connect();
        $conn = $conn->conn;

        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = :username");
        $stmt->bindParam(":username", $_post["username"]);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            if (password_verify($_post["password"], $user["password"])) {
                $data = [];
                $listItem['admin_id'] = $user["admin_id"];
                $listItem["admin_name"] = $user["titlename"] . $user["firstname"] . " " . $user["lastname"];
                $listItem["admin_username"] = $user["username"];
                $listItem["admin_email"] = $user["email"];
                $data[] = $listItem;
                if ($user["status"] == "Y") {
                    return $data; // Password is correct, return user data
                } else {
                    return false;
                }
            } else {
                return false; // Password is incorrect
            }
        } else {
            return false; // User not found
        }
    }
    function register($_post)
    {

        $hashedPassword = password_hash($_post["password"], PASSWORD_DEFAULT);

        $conn = new Connect();
        $conn = $conn->conn;
        $checkusername = $conn->prepare("SELECT * FROM admin WHERE username = :username");
        $checkusername->bindParam(":username", $_post["username"]);
        $checkusername->execute();
        $checkusername = $checkusername->fetch(PDO::FETCH_ASSOC);
        if ($checkusername) {
            return "username_already"; // Username already exists
        } else {
            $stmt = $conn->prepare("INSERT INTO admin (username, password, titlename,firstname, lastname, email) VALUES (:username, :password, :titlename, :firstname, :lastname, :email)");
            $stmt->bindParam(":username", $_post["username"]);
            $stmt->bindParam(":password", $hashedPassword);
            $stmt->bindParam(":titlename", $_post["titlename"]);
            $stmt->bindParam(":firstname", $_post["firstname"]);
            $stmt->bindParam(":lastname", $_post["lastname"]);
            $stmt->bindParam(":email", $_post["email"]);
            if ($stmt->execute()) {
                return "success";
            } else {
                return "false"; // Registration failed
            }
        }
    }
}

class Hoscode
{
    function get_hoscode()
    {
        $conn = new Connect();
        $conn = $conn->conn;

        $hoscode = $conn->prepare("SELECT * FROM hoscode");
        $hoscode->execute();
        $result = $hoscode->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}

class Department
{
    function get_departments()
    {
        $conn = new Connect();
        $conn = $conn->conn;
        $department = $conn->prepare("SELECT * FROM department");
        $department->execute();
        $result = $department->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>