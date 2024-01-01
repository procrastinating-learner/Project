<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$username = $_SESSION['username'];

include 'CategoryManager.php';
include 'ProductManager.php';
include 'Product.php';
include 'Category.php';
include 'DbConnection.php';

$categoryManager = new CategoryManager();
$productManager = new ProductManager();
$categories = $categoryManager->getCategories();
?>
<?php include 'head.php'; ?>

<body>
    <?php include 'icons.php'; ?>
    <?php include 'navbar.php'; ?>
    <section id="billboard" class="position-relative overflow-hidden" style="padding-top: 8rem;">
        <section>
            <div class="row gx-0 d-block d-lg-flex flickity flickity-lg-none" data-flickity="{&quot;watchCSS&quot;: true}">
                <h3 class="mx-3 mb-3">Our Categories</h3>


                <?php if (!empty($categories)) {
                    foreach ($categories as $category) {
                        $image = strtolower(str_replace(' ', '_', $category->getCategoryName()));
                        $image .= ".jpg";
                ?>
                        <!-- Item -->
                        <div class="categoryItem col-12 col-md-6 col-lg-4 d-flex flex-column bg-cover" style="background-image: url(images/<?php echo $image; ?>); background-size: cover;">
                            <div class="card bg-transparent text-white text-center" style="min-height: 470px;">
                                <div class="card-body mt-auto mb-n11 py-8">

                                    <!-- Heading -->
                                    <h1 class="mb-0 fw-bolder text-black">
                                        <?php echo $category->getCategoryName(); ?>
                                    </h1>

                                </div>

                            </div>
                        </div>
                <?php }
                }  ?>

            </div>
        </section>

    </section>
    <section id="company-services" class="padding-large bg-light-blue">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 pb-3">
                    <div class="icon-box d-flex">
                        <div class="icon-box-icon pe-3 pb-3">
                            <svg class="cart-outline">
                                <use xlink:href="#cart-outline" />
                            </svg>
                        </div>
                        <div class="icon-box-content">
                            <h3 class="card-title text-uppercase text-dark">Free delivery</h3>
                            <p>Enjoy free and timely delivery on all your orders.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-3">
                    <div class="icon-box d-flex">
                        <div class="icon-box-icon pe-3 pb-3">
                            <svg class="quality">
                                <use xlink:href="#quality" />
                            </svg>
                        </div>
                        <div class="icon-box-content">
                            <h3 class="card-title text-uppercase text-dark">Quality guarantee</h3>
                            <p>Our products come with a guarantee of high quality and durability.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-3">
                    <div class="icon-box d-flex">
                        <div class="icon-box-icon pe-3 pb-3">
                            <svg class="price-tag">
                                <use xlink:href="#price-tag" />
                            </svg>
                        </div>
                        <div class="icon-box-content">
                            <h3 class="card-title text-uppercase text-dark">Daily offers</h3>
                            <p>Explore our daily offers and save on your favorite products.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-3">
                    <div class="icon-box d-flex">
                        <div class="icon-box-icon pe-3 pb-3">
                            <svg class="shield-plus">
                                <use xlink:href="#shield-plus" />
                            </svg>
                        </div>
                        <div class="icon-box-content">
                            <h3 class="card-title text-uppercase text-dark">100% secure payment</h3>
                            <p>Shop with confidence knowing your payments are secure and protected.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="mobile-products" class="product-store position-relative padding-large padding-top">
        <div class="container">
            <div class="row">
                <div class="display-header d-flex justify-content-between pb-3">
                    <h2 class="display-7 text-dark text-uppercase">
                        <?php echo $categories[0]->getCategoryName(); ?> Products</h2>

                </div>
                <div class="swiper product-swiper">
                    <div class="swiper-wrapper">
                        <?php
                        $productsFirstCat = $productManager->getProductsByCategoryId($categories[0]->getCategoryId());

                        foreach ($productsFirstCat as $productFirstCat) {
                            $productId = $productFirstCat->getProductId();
                            $productDetailsLink = "product_details.php?id=$productId";
                        ?>
                            <div class="swiper-slide">
                                <div class="product-card position-relative">
                                    <div class="image-holder">
                                        <img src="<?php echo $productFirstCat->getImage(); ?>" alt="product-item" style="height:400px; width:300px;">
                                    </div>
                                    <div class="cart-concern position-absolute">
                                        <div class="cart-button d-flex">
                                            <a href="<?php echo $productDetailsLink; ?>" class="btn btn-medium btn-black">View Product<svg class="cart-outline">
                                                    <use xlink:href="#cart-outline"></use>
                                                </svg></a>
                                        </div>
                                    </div>
                                    <div class="card-detail d-flex justify-content-between align-items-baseline pt-3">
                                        <h3 class="card-title text-uppercase">
                                            <a ref="<?php echo $productDetailsLink; ?>"><?php echo $productFirstCat->getName(); ?></a>
                                        </h3>
                                        <span class="item-price text-primary"><?php echo $productFirstCat->getPrice(); ?>MAD</span>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination position-absolute text-center"></div>
    </section>
    <section id="clothing" class="product-store position-relative padding-large no-padding-top">
        <div class="container">
            <div class="row">
                <div class="display-header d-flex justify-content-between pb-3">
                    <h2 class="display-7 text-dark text-uppercase">
                        <?php echo $categories[1]->getCategoryName(); ?> Products</h2>

                </div>
                <div class="swiper clothing-swiper">
                    <div class="swiper-wrapper">
                        <?php
                        $productsSecondCat = $productManager->getProductsByCategoryId($categories[1]->getCategoryId());

                        foreach ($productsSecondCat as $productSecondCat) {
                            $productId = $productSecondCat->getProductId();
                            $productDetailsLink = "product_details.php?id=$productId";
                        ?>
                            <div class="swiper-slide">
                                <div class="product-card position-relative">
                                    <div class="image-holder">
                                        <img src="<?php echo $productSecondCat->getImage(); ?>" alt="product-item" style="height:400px; width:300px;">
                                    </div>
                                    <div class="cart-concern position-absolute">
                                        <div class="cart-button d-flex">
                                            <a href="<?php echo $productDetailsLink; ?>" class="btn btn-medium btn-black">View Product<svg class="cart-outline">
                                                    <use xlink:href="<?php echo $productDetailsLink; ?>cart-outline"></use>
                                                </svg></a>
                                        </div>
                                    </div>
                                    <div class="card-detail d-flex justify-content-between align-items-baseline pt-3">
                                        <h3 class="card-title text-uppercase">
                                            <a href="<?php echo $productDetailsLink; ?>"><?php echo $productSecondCat->getName(); ?></a>
                                        </h3>
                                        <span class="item-price text-primary"><?php echo $productSecondCat->getPrice(); ?>MAD</span>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination position-absolute text-center"></div>
    </section>
    <section id="garden" class="product-store position-relative padding-large padding-top">
        <div class="container">
            <div class="row">
                <div class="display-header d-flex justify-content-between pb-3">
                    <h2 class="display-7 text-dark text-uppercase">
                        <?php echo $categories[2]->getCategoryName(); ?> Products</h2>

                </div>
                <div class="swiper garden-swiper">
                    <div class="swiper-wrapper">

                        <?php
                        $productsThirdCat = $productManager->getProductsByCategoryId($categories[2]->getCategoryId());

                        foreach ($productsThirdCat as $productThirdCat) {
                            $productId = $productThirdCat->getProductId();
                            $productDetailsLink = "product_details.php?id=$productId";
                        ?>
                            <div class="swiper-slide">
                                <div class="product-card position-relative">
                                    <div class="image-holder">
                                        <img src="<?php echo $productThirdCat->getImage(); ?>" alt="product-item" style="height:400px; width:300px;">
                                    </div>
                                    <div class="cart-concern position-absolute">
                                        <div class="cart-button d-flex">
                                            <a href="<?php echo $productDetailsLink; ?>" class="btn btn-medium btn-black">View Product<svg class="cart-outline">
                                                    <use xlink:href="#cart-outline"></use>
                                                </svg></a>
                                        </div>
                                    </div>
                                    <div class="card-detail d-flex justify-content-between align-items-baseline pt-3">
                                        <h3 class="card-title text-uppercase">
                                            <a href="<?php echo $productDetailsLink; ?>"><?php echo $productThirdCat->getName(); ?></a>
                                        </h3>
                                        <span class="item-price text-primary"><?php echo $productThirdCat->getPrice(); ?>MAD</span>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination position-absolute text-center"></div>
    </section>
    <button class="btn btn-primary btn-floating fixed-bottom mr-3 mb-3" style="display: flex;justify-content: center;align-items: center;width: 3rem; margin-left:auto;" id="scrollToTopBtn" onclick="scrollToTop()"><img src="./images/arrow.svg" alt="svg" /></button>

    <?php include 'footer.php'; ?>