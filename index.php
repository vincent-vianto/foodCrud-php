<?php
include('action.php')
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Food CRUD</title>
</head>

<body class="mt-3">
    <div class="container">
        <h1 class="text-center font-weight-bold">Food CRUD with Pagination</h1>
        <button type="button" class="btn btn-primary mt-3 mb-5" data-toggle="modal" data-target="#modalAdd">
            Add Food Here
        </button>

        <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Food</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="action.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Enter Name Food Here" required>
                            </div>
                            <div class="form-group">
                                <input type="number" name="stock" class="form-control" min="0" placeholder="How Much Food Stock" required>
                            </div>
                            <div class="form-group">
                                <input type="number" name="price" class="form-control" min="0" placeholder="How Much the Price" required>
                            </div>
                            <div class="form-group">
                                <input type="file" name="image" class="custom-file" required>
                            </div>
                            <div class="form-group">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <input type="submit" name="save" class="btn btn-primary" value="Save">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $dataPerPage = 6;
        $sql = "SELECT * FROM Food";
        $totaldata = mysqli_num_rows($conn->query($sql));
        $totalpage = ceil($totaldata / $dataPerPage);

        $page = isset($_GET['pages']) ? $_GET['pages'] : 1;

        $data = ($page * $dataPerPage) - $dataPerPage;
        $query = "SELECT * FROM Food LIMIT $data,$dataPerPage";
        $result = $conn->query($query);
        ?>

        <div class="row">
            <? while($row=$result->fetch_assoc()){?>
            <div class="col-md-4 col-sm-12">
                <div class="card mb-4" style="width: 100%;height: 350px;">
                    <div class="view overlay">
                        <img class="card-img-top" style="width:100%; height:170px" src="<?= $row['photo'] ?>">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"><b><?= $row['name']; ?></b></h4>
                        <p class="card-text"> Stock : <?= $row['stock']; ?> pcs
                            <br>
                            Price : Rp <?= number_format($row['price'], 0, ".", "."); ?>
                        </p>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit<?= $row['id'] ?>">Edit</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDel<?= $row['id'] ?>">Delete</button>
                    </div>
                </div>

                <div class="modal fade" id="modalDel<?= $row['id'] ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete the Food</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure want to delete this food?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a href="action.php?delete=<?= $row['id']; ?>" class="btn btn-danger mr-2">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit the Food</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="action.php" method="POST" enctype="multipart/form-data">
                                    <input name="id" type="hidden" value="<?= $row['id'] ?>">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Enter Name Food Here" value="<?= $row['name'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="number" name="stock" class="form-control" min="0" placeholder="How Much Food Stock" value="<?= $row['stock'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="number" name="price" class="form-control" min="0" placeholder="How Much the Price" value="<?= $row['price'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="oldimage" value="<?= $row['photo'] ?>">
                                        <input type="file" name="image" class="custom-file">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <input type="submit" name="update" class="btn btn-success" value="Edit">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?} ?>
        </div>

        <div class="text-center" style="font-size: 30px;">
            <? for($i=1; $i<=$totalpage; $i++){?>
            <? if ($i==$page){?>
            <a href="?pages=<?= $i ?>" class="font-weight-bold"><u><?= $i ?></u></a>
            <?} else{?>
            <a href="?pages=<?= $i ?>"><?= $i ?></a>
            <?}}?>
        </div>

    </div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</html>