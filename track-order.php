<?php
session_start();
include_once('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shahi Punjabi Restaurant | Food Reviews</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .review-slider-section {
            padding: 50px 0;
            background-color: #f8f9fa;
        }
        .review-slider-section img {
            object-fit: cover;
            border: 2px solid #444;
        }
        .review-slider-section p {
            font-size: 18px;
            max-width: 700px;
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(0%) brightness(0%);
        }
    </style>
</head>

<body>

<?php include_once('header.php'); ?>

<section>
    <div class="block">
        <div class="fixed-bg" style="background-image: url(assets/images/topbg.jpg);"></div>
        <div class="page-title-wrapper text-center">
            <h1>Food Reviews</h1>
        </div>
    </div>
</section>

<div class="bread-crumbs-wrapper">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Food Reviews</li>
        </ol>
    </div>
</div>

<section class="review-slider-section">
    <div class="container">

        <div class="text-center mb-4">
            <h2><b>What Our Customers Say</b></h2>
        </div>

        <div id="reviewCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $query = mysqli_query($con, "SELECT * FROM review ORDER BY id DESC");
                $active = true;

                while ($row = mysqli_fetch_assoc($query)) {
                ?>
                <div class="carousel-item <?= $active ? 'active' : '' ?>">
                    <?php $active = false; ?>
                    <div class="text-center">
                        <img src="assets/images/<?= htmlspecialchars($row['image']) ?>"
                             class="rounded-circle mb-3" width="80" height="80">
                        <p>"<?= htmlspecialchars($row['message']) ?>"</p>
                        <div class="text-warning">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                echo $i <= (int)$row['rate']
                                    ? '<i class="bi bi-star-fill"></i>'
                                    : '<i class="bi bi-star"></i>';
                            }
                            ?>
                        </div>
                        <h6>— <?= htmlspecialchars($row['name']) ?></h6>
                    </div>
                </div>
                <?php } ?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#reviewCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#reviewCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</section>

<?php include_once('footer.php'); ?>

</body>
</html>
