<?php
$name = "";
$email = "";
$password = "";
$phone = "";
$image = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["name"]))
        $name = $_POST["name"];
    if (isset($_POST["email"]))
        $email = $_POST["email"];
    if (isset($_POST["password"]))
        $password = $_POST["password"];
    if (isset($_POST["phone"]))
        $phone = $_POST["phone"];
    if(!empty($name) && !empty($email) && !empty($password) && !empty($phone)) {
        try {
            $fileName = uniqid() . ".jpg";
            $fileSave = $_SERVER["DOCUMENT_ROOT"] . "/uploads/" . $fileName;
            move_uploaded_file($_FILES["image"]["tmp_name"], $fileSave);
            include $_SERVER["DOCUMENT_ROOT"] . "/connection_database.php";
            if(isset($dbh)) {
                $sql = "INSERT INTO users (name, image, phone, password, email) VALUES(?, ?, ?, ?, ?);";
                $sth = $dbh->prepare($sql);
                $sth->execute([$name, $fileName, $phone, $password, $email]);
                $dbh = null;
                header('Location: /');
                exit;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
?>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/head.php"; ?>

    <div class="container">
        <h1 class="text-center">Register</h1>
        <form enctype="multipart/form-data" class="row col-md-8 offset-md-2 g-3" method="post">
            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>">
            </div>
            <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="itstep@gmail.com" value="<?php echo $email; ?>">
            </div>
            <div class="col-12">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="38(067)43 24 344" value="<?php echo $phone; ?>">
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Image File</label>
                <input name="image" class="form-control" type="file" id="image">
            </div>
            <a href="/" class="btn btn-dark col-6">Main</a>
            <button type="submit" class="btn btn-primary col-6">Register</button>
        </form>
    </div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/footer.php"; ?>