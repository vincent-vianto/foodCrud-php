<?php
require('config.php');

if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $ext = end(explode('.', $image));
    $photo = 'uploads/' . $name . '.' . $ext;

    // parameter : move_uploaded_file(file, dest)
    // parameter file akan me-replace ke uploads/nama.ext
    // parameter dest untuk tujuan dan nama filenya
    move_uploaded_file($_FILES['image']['tmp_name'], $photo);

    $query = "INSERT INTO Food (name,stock,price,photo) VALUE ('$name','$stock','$price','$photo')";
    $result = $conn->query($query);

    header('location:index.php');
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "SELECT photo FROM Food WHERE id=$id";
    $result2 = $conn->query($sql);
    $row = $result2->fetch_assoc();
    $imagepath = $row['photo'];
    unlink($imagepath);

    $query = "DELETE FROM Food WHERE id=$id";
    $result = $conn->query($query);

    header('location:index.php');
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $oldimage = $_POST['oldimage'];

    if (isset($_FILES['image']['name']) && ($_FILES['image']['name'] != "")) {
        $new = $_FILES['image']['name'];
        unlink($oldimage);

        $ext = end(explode('.', $new));
        $photo = 'uploads/' . $name . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], $photo);
    } else {
        $photo = $oldimage;
    }

    $query = "UPDATE Food SET name='$name', stock='$stock', price='$price', photo='$photo' WHERE id='$id'";
    $result = $conn->query($query);

    header('location:index.php');
}
