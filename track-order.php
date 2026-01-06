<?php
session_start();
include_once('includes/dbconnection.php');
?>
<head>
    <title>Shahi Punjabi Restaurant | Track Order</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .review-slider-section {
            padding: 50px 0;
            background-color: #f8f9fa;
        }

        .review-slider-section img {
            object-fit: cover;
            border: 2px solid rgb(73, 73, 73);
        }

        .review-slider-section p {
            font-size: 18px;
            max-width: 700px;
        }

        /* Change carousel control icon color */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
    background-size: 100% 100%;
    filter: invert(0%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(0%) contrast(100%);
    /* This makes it BLACK */
    }

    </style>
</head>

<?php include_once('header.php'); ?>

<section>
    <div class="block">
        <div class="fixed-bg" style="background-image: url(assets/images/topbg.jpg);"></div>
        <div class="page-title-wrapper text-center">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="page-title-inner">
                    <h1 itemprop="headline">Food Reviews</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="bread-crumbs-wrapper">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" title="" itemprop="url">Home</a></li>
            <li class="breadcrumb-item">Food Reviews</li>
        </ol>
    </div>
</div>

<!-- Review Slider Section -->
<section class="review-slider-section">
    <div class="container">
        <div class="text-center mb-4">
            <h2><b>What Our Customers Say</b></h2>
        </div>
        <br>

        <div id="reviewCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                //include_once('includes/dbconnection.php');

                $query = mysqli_query($con, "SELECT * FROM review ORDER BY id DESC");
                $active = true;

                while ($row = mysqli_fetch_array($query)) {
                    $name = htmlspecialchars($row['name']);
                    $image = htmlspecialchars($row['image']);
                    $review = htmlspecialchars($row['message']);
                    $rating = intval($row['rate']);
                ?>
                    <div class="carousel-item <?php if ($active) { echo 'active'; $active = false; } ?>">
                        <div class="d-flex flex-column align-items-center">
                            <img src="assets/images/<?php echo $image; ?>" class="rounded-circle mb-3" width="80" height="80" alt="User">
                            <p class="text-center">"<?php echo $review; ?>"</p>
                            <div class="text-warning">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $rating) {
                                        echo '<i class="bi bi-star-fill"></i>';
                                    } elseif ($i - 0.5 == $rating) {
                                        echo '<i class="bi bi-star-half"></i>';
                                    } else {
                                        echo '<i class="bi bi-star"></i>';
                                    }
                                }
                                ?>
                            </div>
                            <h6 class="mt-2">— <?php echo $name; ?></h6>
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
</main>
<?php
include_once('footer.php');
include_once('includes/signin.php');
include_once('includes/signup.php');
?>
