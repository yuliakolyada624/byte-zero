<?= $this->extend('Admin/partials/main') ?>

<?= $this->section('content') ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?= $this->include('Admin/partials/menu') ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <?= $page_title ?> (med-test Theme TEST app/Views/med-test/Admin/) 
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end dropdown ms-2">
                                    <a class="text-muted dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                                <?php
                                $user = auth()->user();
                                //d($user);

                                if ($user) {
                                ?>
                                <div>
                                    <div class="mb-4 me-3">
                                        <i class="mdi mdi-account-circle text-primary h1"></i>
                                    </div>
                                
                                    <div>
                                        <h5>
                                            <?= $user->username ?>
                                        </h5>
                                        <p class="text-muted mb-1">
                                            <?= $user->email ?>
                                        </p>
                                        <p class="text-muted mb-0">Id no: #<?= $user->id ?></p>
                                        <p class="text-muted mb-1">
                                        Groups: <?php foreach($user->groups as $group){ echo $group.'; '; } ?>
                                            <?php /*
                                            if ($user->inGroup('admin')) {
                                                        // do something
                                                    }
                                             */
                                            ?>
                                        </p>
                                        <p class="text-muted mb-1">
                                        <?php    
                                        if (auth()->user()->can('system.access')) {
                                            echo "- Has system access <br/>";
                                        } 
                                        if (auth()->user()->can('admin.access')) {
                                            echo "- Has admin access <br/>";
                                        } 
                                        if (auth()->user()->can('supervisor.access')) {
                                            echo "- Has supervisor access <br/>";
                                        } 
                                        if (auth()->user()->can('traveler.access')) {
                                            echo "- Has traveler access <br/>";
                                        } 
                                        ?>
                                        </p>
                                        <p>
                                        Lang: 
                                        <?php
                                            $session = \Config\Services::session();
                                            $lang = $session->get('lang');
                                            echo $lang;

                                            // defaultLocale
                                            $conf = config('App');
                                            echo "<br /> def locale = ".$conf->defaultLocale;
                                        ?>
                                        </p>
                                    </div>
                                </div>
                                <?php
                                                                }
                                                                ?>
                            </div>
                            <?php /*                                   
                            <div class="card-body border-top">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div>
                                            <p class="fw-medium mb-2">Balance :</p>
                                            <h4>$ 6134.39</h4>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mt-4 mt-sm-0">
                                            <p class="fw-medium mb-2">Coin :</p>
                                            <div class="d-inline-flex align-items-center mt-1" id="tooltip-container">

                                                <a href="javascript: void(0);" class="m-1">
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-warning bg-soft text-warning font-size-18">
                                                            <i class="mdi mdi-bitcoin"></i>
                                                        </span>
                                                    </div>
                                                </a>
                                                <a href="javascript: void(0);" class="m-1">
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                            <i class="mdi mdi-ethereum"></i>
                                                        </span>
                                                    </div>
                                                </a>
                                                <a href="javascript: void(0);" class="m-1">
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-info bg-soft text-info font-size-18">
                                                            <i class="mdi mdi-litecoin"></i>
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="card-footer bg-transparent border-top">
                                <div class="text-center">
                                    <a href="#" class="btn btn-outline-light me-2 w-md">Deposit</a>
                                    <a href="#" class="btn btn-primary me-2 w-md">Buy / Sell</a>
                                </div>
                            </div>
                            */ ?>
                        </div>
                    </div>
                    <?php /*                                           
                    <div class="col-xl-8">
                        <div class="card">
                            <div>
                                <div class="row">
                                    <div class="col-lg-9 col-sm-8">
                                        <div class="p-4">
                                            <h5 class="text-primary">Welcome Back !</h5>
                                            <p>Skote Crypto Dashboard</p>

                                            <div class="text-muted">
                                                <p class="mb-1"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i> If several languages coalesce</p>
                                                <p class="mb-1"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i> Sed ut perspiciatis unde</p>
                                                <p class="mb-0"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i> It would be necessary</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-4 align-self-center">
                                        <div>
                                            <img src="/assets/images/crypto/features-img/img-1.png" alt="" class="img-fluid d-block">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="text-muted mb-4"><i class="mdi mdi-bitcoin h2 text-warning align-middle mb-0 me-3"></i> Bitcoin </p>

                                        <div class="row">
                                            <div class="col-6">
                                                <div>
                                                    <h5>$ 9134.39</h5>
                                                    <p class="text-muted text-truncate mb-0">+ 0.0012 ( 0.2 % ) <i class="mdi mdi-arrow-up ms-1 text-success"></i></p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div>
                                                    <div id="area-sparkline-chart-1" class="apex-charts"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="text-muted mb-4"><i class="mdi mdi-ethereum h2 text-primary align-middle mb-0 me-3"></i> Ethereum </p>

                                        <div class="row">
                                            <div class="col-6">
                                                <div>
                                                    <h5>$ 245.44</h5>
                                                    <p class="text-muted text-truncate mb-0">- 4.102 ( 0.1 % ) <i class="mdi mdi-arrow-down ms-1 text-danger"></i></p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div>
                                                    <div id="area-sparkline-chart-2" class="apex-charts"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="text-muted mb-4"><i class="mdi mdi-litecoin h2 text-info align-middle mb-0 me-3"></i> litecoin </p>

                                        <div class="row">
                                            <div class="col-6">
                                                <div>
                                                    <h5>$ 63.61</h5>
                                                    <p class="text-muted text-truncate mb-0">+ 1.792 ( 0.1 % ) <i class="mdi mdi-arrow-up ms-1 text-success"></i></p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div>
                                                    <div id="area-sparkline-chart-3" class="apex-charts"></div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    */ ?>
                </div>
                <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


        <?= $this->include('Admin/partials/footer') ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->



<?= $this->include('Admin/partials/right-sidebar') ?>

<?= $this->section('extra-js') ?>




<!-- crypto dash init js -->
<script src="<?=base_url()?>assets/js/pages/crypto-dashboard.init.js"></script>

<?= $this->endSection() ?>



<?= $this->endSection() ?>
