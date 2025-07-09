<?php
$sidebar = $sidebar ?? [
    'first' => true,
    'last' => true
];
?>
<!doctype html>
<html lang="en">
    <head>
        <title><?= $this->renderSection('title') ?></title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <meta name="description" content="<?= $this->renderSection('description') ?>" />
        <meta name="keywords" content="<?= $this->renderSection('keywords') ?>" />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />

        <?= $this->renderSection('head') ?>
    </head>

    <body class="overflow-x-hidden">
        <header class="border-bottom position-sticky top-0 bg-body-tertiary">
            
            <!--Start Navbar-->
            <nav class="navbar">
                <div class="container-fluid gap-1 gap-sm-2 gap-md-3">

                    <!--Your Navigations Here-->
                    <?php $brand = $this->renderSection('brand') ?>
                    <?= $brand ?>
                    <?= $this->renderSection('navbar'); ?>
                    
                    <!--Hide sidebar buttons-->
                    <?php if ($sidebar['first']): ?>
                    <!--Primary Sidebar-->
                    <button data-toggle="hide" data-target="#primarySidebar" class="btn border d-none d-sm-block" type="button">
                        <i class="bi bi-layout-sidebar"></i>
                    </button>

                    <!--Primary Sidebar Button-->
                    <button class="btn border d-sm-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#primarySidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="bi bi-layout-sidebar-inset"></i>
                    </button>
                    <?php endif; ?>

                    <?php if($sidebar['last']): ?>
                    <!--Secondary Sidebar-->
                    <button data-toggle="hide" data-target="#secondarySidebar" class="btn border d-none d-xl-block" type="button">
                        <i class="bi bi-layout-sidebar-reverse"></i>
                    </button>
                    
                    <!--Secondary Sidebar Button-->
                    <button class="btn border d-xl-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#secondarySidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="bi bi-layout-sidebar-inset-reverse"></i>
                    </button>
                    <?php endif; ?>

                </div>
            </nav>
            <!--End Navbar-->

            <!-- place navbar here -->
        </header>

        <div class="container-fluid primary-layout p-0">
            <?php if ($sidebar['first']): ?>
                <div id="primarySidebar" class="sidebar offcanvas-sm offcanvas-start border-end overflow-hidden" tabindex="-1" aria-labelledby="offcanvasLabel">
                    <div class="offcanvas-header border-bottom">
                        <?= $brand ?>
                        <button type="button" class="btn-close shadow-none" data-bs-target="#primarySidebar" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body p-0 h-100 overflow-auto">
                        <?= $this->renderSection('firstSidebar') ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="main-content <?= $sidebar['last'] ? 'secondary-layout' : '' ?>">
                <main>
                    <?= $this->renderSection('content') ?>
                </main>

                <?php if ($sidebar['last']): ?>
                    <aside id="secondarySidebar" class="sidebar border-start offcanvas-end offcanvas-xl overflow-hidden" tabindex="-1" aria-labelledby="offcanvasLabel">
                        <div class="offcanvas-header border-bottom">
                            <?= $brand ?>
                            <button type="button" class="btn-close shadow-none" data-bs-target="#secondarySidebar" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body p-0 h-100 overflow-auto">
                            <?= $this->renderSection('lastSidebar') ?>
                        </div>
                    </aside>
                <?php endif; ?>
            </div>
        </div>
        
        <?= $this->renderSection('footer') ?>

        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
        <?= $this->renderSection('scripts') ?>
    </body>
</html>