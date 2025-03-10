<!DOCTYPE html>
<html lang="en">

<head prefix="">
    <meta charset="UTF-8" />
    <title>
        Home page
    </title>

    <!-- TODO: Robots no index -->
    <meta name="robots" content="noindex,nofollow" />

    <!-- TODO: Allow http req with no network -->





    <!-- Open Graph meta -->
    <meta property="og:site_name" content="Home page">
    <meta property="og:title" content="S" />
    <meta property="og:description" content="" />
    <meta property="og:locale" content="en">
    <meta property="og:locale:alternate" content="uk" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:image:secure_url" content="" />
    <meta property="og:image:width" content="32" />
    <meta property="og:image:height" content="32" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="" />

    <!-- Fix IOS zoom to input on focus -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no , maximum-scale=1.0, user-scalable=no" /> -->
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no,height=device-height" />
    <meta content="true" name="HandheldFriendly" />
    <meta content="width" name="MobileOptimized" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="it-rating" content="" />
    <meta name="theme-color" content="#ffffff">

    <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>">

    <!-- [if IE]>
  <meta http-equiv="X-UA-Compatible" content="IE = edge" />
  <![endif] -->

    <link rel="canonical" href="">
    <link rel="icon" type="image/png" href="<?= base_url() ?>assets/themes/default/favicons/favicon.png" />
    <link rel="manifest" href="<?= base_url() ?>assets/themes/default/manifest.json" />
    <!-- inject:splash screens -->
    <link rel="apple-touch-startup-image"
        media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)"
        href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-1242x2688.png" />
    <link rel="apple-touch-startup-image"
        media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)"
        href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-828x1792.png" />
    <link rel="apple-touch-startup-image"
        media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)"
        href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-1125x2436.png" />
    <link rel="apple-touch-startup-image"
        media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3)"
        href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-1242x2208.png" />
    <link rel="apple-touch-startup-image"
        media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)"
        href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-750x1334.png" />
    <link rel="apple-touch-startup-image"
        media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)"
        href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-640x1136.png" />
    <link rel="apple-touch-startup-image"
        media="(device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2)"
        href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-1620x2160.png" />
    <link rel="apple-touch-startup-image"
        media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)"
        href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-2048x2732.png" />
    <link rel="apple-touch-startup-image"
        media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)"
        href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-1668x2388.png" />
    <link rel="apple-touch-startup-image"
        media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)"
        href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-1668x2224.png" />
    <link rel="apple-touch-startup-image"
        media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)"
        href="<?= base_url() ?>assets/themes/default/launch-screens/launch-screen-1536x2048.png" />
    <!-- endinject:splash screens -->

    <!-- inject:font preload -->
    <!-- endinject:font preload -->

    <link rel="stylesheet" href="<?= base_url() ?>assets/themes/default/css/app.min.css" />
    <!-- [if lt IE 9]>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
  <![endif]            -->
</head>

<body class="index-page js-index-page">
    <div class="wrapper">
        <header class="landing-header js-fixed-header ">
            <div class="container">
                <div class="landing-header-content">
                    <a href="<?= base_url() ?>">

                        <picture class="header__image">
                            <source srcset="<?= base_url() ?>assets/themes/default/img/./content/logo.webp"
                                type="image/webp" class="header__img " />
                            <img src="<?= base_url() ?>assets/themes/default/img/./content/logo.png" alt="img"
                                class="header__img " width="198" height="35" />
                        </picture>

                    </a>
                    <nav class="landing-header-nav">
                        <ul class="landing-header-nav-list">
                            <li class="landing-header-nav-item active">
                                <a href="#" class="landing-header-nav-item-link js-header-nav-item-link"
                                    data-target="home">About</a>
                            </li>
                            <li class="landing-header-nav-item">
                                <a href="#" class="landing-header-nav-item-link js-header-nav-item-link"
                                    data-target="steps-section">Our Process</a>
                            </li>
                            <li class="landing-header-nav-item">
                                <a href="#" class="landing-header-nav-item-link js-header-nav-item-link"
                                    data-target="provides-section">Our Service</a>
                            </li>
                            <li class="landing-header-nav-item">
                                <a href="#" class="landing-header-nav-item-link js-header-nav-item-link"
                                    data-target="preferences-section">Your Benefits</a>
                            </li>
                            <li class="landing-header-nav-item">
                                <a href="#" class="landing-header-nav-item-link js-header-nav-item-link"
                                    data-target="faq-section">FAQs</a>
                            </li>
                            <li class="landing-header-nav-item">
                                <a href="#" class="landing-header-nav-item-link js-header-nav-item-link"
                                    data-target="feedback-section">Contact Us</a>
                            </li>
                        </ul>
                    </nav>
                    <?php if(getenv('CI_ENVIRONMENT')!=='production'): ?>
                    <div class="landing-header-sign-buttons">
                        <a href="<?= base_url() ?>accounts/login" class="header-sign-in">Sign in</a>
                        <a href="<?= base_url() ?>accounts/register" class="header-register btn btn-primary">Register</a>
                    </div>
                    <?php endif; ?>
                    <button type="button" class="landing-header-burger-btn js-header-menu-trigger"
                        aria-label="Open header menu button">

                        <svg class="icon icon-burger ">
                            <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#burger" />
                        </svg>

                    </button>
                    <div class="landing-header-overlap-menu js-header-overlap-menu">

                        <picture class="header-overlap-menu__image">
                            <source srcset="<?= base_url() ?>assets/themes/default/img/./content/overlap-logo.webp"
                                type="image/webp" class="header-overlap-menu__img " />
                            <img src="<?= base_url() ?>assets/themes/default/img/./content/overlap-logo.png" alt="img"
                                class="header-overlap-menu__img " width="198" height="35" />
                        </picture>

                        <ul class="landing-header-overlap-menu-nav-list">
                            <li class="landing-header-overlap-menu-nav-item active">
                                <a class="landing-header-overlap-menu-nav-item-link js-header-nav-item-link"
                                    data-target="home">About</a>
                            </li>
                            <li class="landing-header-overlap-menu-nav-item">
                                <a class="landing-header-overlap-menu-nav-item-link js-header-nav-item-link"
                                    data-target="steps-section">Process</a>
                            </li>
                            <li class="landing-header-overlap-menu-nav-item">
                                <a class="landing-header-overlap-menu-nav-item-link js-header-nav-item-link"
                                    data-target="provides-section">Features</a>
                            </li>
                            <li class="landing-header-overlap-menu-nav-item">
                                <a class="landing-header-overlap-menu-nav-item-link js-header-nav-item-link"
                                    data-target="preferences-section">Benefits</a>
                            </li>
                            <li class="landing-header-overlap-menu-nav-item">
                                <a class="landing-header-overlap-menu-nav-item-link js-header-nav-item-link"
                                    data-target="faq-section">FAQs</a>
                            </li>
                            <li class="landing-header-overlap-menu-nav-item">
                                <a class="landing-header-overlap-menu-nav-item-link js-header-nav-item-link"
                                    data-target="feedback-section">Contact Us</a>
                            </li>
                        </ul>
                        <?php if(getenv('CI_ENVIRONMENT')!=='production'): ?>
                        <div class="landing-header-overlap-menu-sign-buttons">
                            <a href="<?= base_url() ?>accounts/login"
                                class="landing-header-overlap-menu-sign-in btn btn-white">Sign in</a>
                            <a href="<?= base_url() ?>accounts/register"
                                class="landing-header-overlap-menu-register btn btn-primary js-header-nav-item-link"
                                data-target="feedback-section">Register</a>
                        </div>
                        <?php endif; ?>
                        <button type="button"
                            class="landing-header-overlap-menu-close-btn js-header-overlap-menu-close-trigger">

                            <svg class="icon icon-close ">
                                <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#close" />
                            </svg>

                        </button>
                    </div>
                </div>
            </div>
        </header>

        <div class="content landing-content">
            <section class="global-section hero-section pt-header-height" id="home">
                <div class="container">
                    <div class="hero-section-wrap">
                        <div class="hero-section-content">
                            <h2 class="hero-section-title main-title">Welcome to the Future of Medical Record & Billing
                                Summarization</h2>
                            <p class="hero-section-subtitle global-subtitle">Save time, money and accelerate claims
                                resolution with Med-Test.AI's intelligent platform. Med-Test.AI provides automated
                                record and billing summarization services for law firms, insurance claims professionals,
                                and clinical experts, delivering concise, user-friendly summaries within hours to
                                facilitate swift and effective claim evaluation.</p>
                            <a href="#feedback-section" class="hero-section-button btn-primary btn js-feedback-trigger"
                                data-target="js-feedback-target">Request Demo</a>
                        </div>
                        <div class="hero-section-graph">

                            <picture class="hero-section-graph__image">
                                <source
                                    srcset="<?= base_url() ?>assets/themes/default/img/./content/homepage/hero-graph.webp"
                                    type="image/webp" class="hero-section-graph__img " />
                                <img src="<?= base_url() ?>assets/themes/default/img/./content/homepage/hero-graph.png"
                                    alt="img" class="hero-section-graph__img " width="457" height="571" />
                            </picture>

                        </div>
                    </div>
                </div>
            </section>
            <section class="global-section benefits-section">
                <div class="container">
                    <div class="benefits-section-wrap">
                        <h2 class="benefits-section-title hidden-title">Benefits</h2>
                        <div class="benefits-section-cards">
                            <div class="benefits-section-card">
                                <img src="<?= base_url() ?>assets/themes/default/svg/check-in-circle.svg"
                                    alt="check-icon" class="benefits-section-card__check-circle">
                                <span class="benefits-section-card-text">greater accuracy</span>
                            </div>
                            <div class="benefits-section-card">
                                <img src="<?= base_url() ?>assets/themes/default/svg/check-in-circle.svg"
                                    alt="check-icon" class="benefits-section-card__check-circle">
                                <span class="benefits-section-card-text">Expedite Claims Resolution</span>
                            </div>
                            <div class="benefits-section-card">
                                <img src="<?= base_url() ?>assets/themes/default/svg/check-in-circle.svg"
                                    alt="check-icon" class="benefits-section-card__check-circle">
                                <span class="benefits-section-card-text">faster reviews
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="global-section steps-section" id="steps-section">
                <div class="container with-flex">
                    <div class="steps-section-wrap js-section-wrap">
                        <h3 class="global-title steps-section-title">Med-Test.AI Simplifies The Process Of Medical
                            Record and Billing Summarization</h3>
                        <img src="<?= base_url() ?>assets/themes/default/svg/stat-line.svg" alt="steps line"
                            class="steps-section-image">
                        <ul class="steps-section__steps-list">
                            <li class="steps-section__steps-list-item m-w-337">
                                <span class="circle">01</span>
                                <span class="steps-section__steps-list-item__content">
                                    <span class="steps-section__steps-list-item__content-title">Cost savings vs. manual
                                        review</span>
                                    <span class="steps-section__steps-list-item__content-text">As medical records
                                        continue to grow in complexity, professionals are struggling to efficiently
                                        extract insights critical for cases or claims. Relying on manual review means
                                        wasting precious budget on outsourcing companies or sacrificing nights and
                                        weekends with tedious work.</span>
                                </span>
                            </li>
                            <li class="steps-section__steps-list-item m-w-283">
                                <span class="circle">02</span>
                                <span class="steps-section__steps-list-item__content">
                                    <span class="steps-section__steps-list-item__content-title">Time savings - hours
                                        <br>
                                        vs. days or months</span>
                                    <span class="steps-section__steps-list-item__content-text m-w-264">Even then,
                                        turnaround times stretch weeks if not months -
                                        <br>far too slow for time-sensitive decision-making. The summarization process
                                        remains not just frustrating, but deeply inefficient for everybody
                                        involved.</span>
                                </span>
                            </li>
                            <li class="steps-section__steps-list-item m-w-321">
                                <span class="circle">03</span>
                                <span class="steps-section__steps-list-item__content">
                                    <span class="steps-section__steps-list-item__content-title">Accuracy vs. manual
                                        reviews</span>
                                    <span class="steps-section__steps-list-item__content-text">Manual reviews, whether
                                        conducted in-house or by outsourcing firms, can contain inaccuracies that impact
                                        the assessment of a claim. For insurance professionals, law firms, and clinical
                                        experts, precise summarization of medical records and billing is essential for
                                        claim evaluation. Med-Test.AI offers a reliable solution. Our experts have
                                        developed an advanced AI to turn complicated records into simplified summaries
                                        in hours, not days.
                                    </span>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            <section class="global-section provides-section global-section-with-bg" id="provides-section">
                <div class="container">
                    <div class="provides-section-wrap js-section-wrap">
                        <h3 class="global-title provides-section-title">Med-Test.AI Changes Everything in Medical
                            Record Reviews, Processing, and Summarization</h3>
                        <p class="global-subtitle provides-section-subtitle">Med-Test.AI pioneers advanced medical
                            record processing and analysis. Our artificial intelligence platform acts as a dedicated
                            assistant absorbing the burden of complex documentation. The result? Faster turnarounds,
                            lower costs, and more accurate review outcomes for everyone.</p>

                        <p class="provides-section-title_small">Here’s what Med-Test.AI can do for you:
                        </p>

                        <ul class="provides-section-list global-section-list">
                            <li class="provides-section-list-item global-section-card-with-icon-item">
                                <img class="provides-section-list-item-icon global-section-card-with-icon-item__icon"
                                    src="<?= base_url() ?>assets/themes/default/svg/edit-file.svg"
                                    alt="Medical Billing & Record Summarization" width="60" height="60">
                                <span
                                    class="provides-section-list-item-title global-section-card-with-icon-item__title">Medical
                                    Billing & Record Summarization</span>
                                <span
                                    class="provides-section-list-item-text global-section-card-with-icon-item__text">Each
                                    report is meticulously reviewed by our legal team for precision and deduplication.
                                    Our AI targets specific injury-related data, ensuring you receive only the most
                                    relevant information.</span>
                            </li>
                            <li class="provides-section-list-item global-section-card-with-icon-item">
                                <img class="provides-section-list-item-icon global-section-card-with-icon-item__icon"
                                    src="<?= base_url() ?>assets/themes/default/svg/files-group.svg"
                                    alt="Custom Summarization With Human Validation" width="60" height="60">
                                <span
                                    class="provides-section-list-item-title global-section-card-with-icon-item__title">Custom
                                    Summarization With Human Validation</span>
                                <span
                                    class="provides-section-list-item-text global-section-card-with-icon-item__text">While
                                    our AI extracts accurate medical insights, we provide the human validation needed
                                    for your use cases. Our legal experts review and then approve AI outputs before
                                    delivering the data, ensuring you receive only the most relevant information.</span>
                            </li>
                            <li class="provides-section-list-item global-section-card-with-icon-item">
                                <img class="provides-section-list-item-icon global-section-card-with-icon-item__icon"
                                    src="<?= base_url() ?>assets/themes/default/svg/advanced-ocr.svg" alt="Advanced OCR"
                                    width="60" height="60">
                                <span
                                    class="provides-section-list-item-title global-section-card-with-icon-item__title">Advanced
                                    OCR</span>
                                <span
                                    class="provides-section-list-item-text global-section-card-with-icon-item__text">Our
                                    advanced Optical Character Recognition (OCR) capabilities provide searchable medical
                                    records at your fingertips. Our intelligent OCR technology makes locating specific
                                    information simple.</span>
                            </li>
                            <li class="provides-section-list-item global-section-card-with-icon-item">
                                <img class="provides-section-list-item-icon global-section-card-with-icon-item__icon"
                                    src="<?= base_url() ?>assets/themes/default/svg/time.svg"
                                    alt="Instant Medical Chronologies and Indexes" width="60" height="60">
                                <span
                                    class="provides-section-list-item-title global-section-card-with-icon-item__title">Instant
                                    Medical Chronologies and Indexes</span>
                                <span
                                    class="provides-section-list-item-text global-section-card-with-icon-item__text">Quickly
                                    grasp patient timelines, physician involvement, and location of key details in hours
                                    thanks to automatically generated chronologies and indexes to build contextual
                                    connections.</span>
                            </li>
                        </ul>
                        <?php if(getenv('CI_ENVIRONMENT')!=='production'): ?>
                        <a href="<?= base_url() ?>accounts/register"
                            class="btn btn-primary provides-section-btn">Experience Med-Test.AI Here</a>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
            <section class="global-section testimonials-section">
                <div class="container">
                    <div class="testimonials-section-wrap">
                        <h2 class="testimonials-section-title global-title">Our Client Testimonials: Real Stories, Real
                            Results!</h2>

                        <div class="swiper">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">

                                <div class="swiper-slide">
                                    <div class="testimonial-slide-wrap">
                                        <div class="testimonial-slide-img-wrap">

                                            <picture class="testimonial-slide__image">
                                                <source
                                                    srcset="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonial-1.webp"
                                                    type="image/webp" class="testimonial-slide__img " />
                                                <img src="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonial-1.jpg"
                                                    alt="img" class="testimonial-slide__img " width="120"
                                                    height="120" />
                                            </picture>

                                        </div>
                                        <div class="testimonial-slide-content">
                                            <div class="testimonial-slide-content-stars">

                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>

                                            </div>
                                            <div class="testimonial-slide-content-text">
                                                Using Med-Test.ai has been a game-changer for our firm, Smith & Wesson
                                                LLP. It's streamlined our case preparation process, allowing us to
                                                easily organize and analyze medical records. Our team can now quickly
                                                identify pertinent medical events, saving us countless hours. It's
                                                undeniably boosted our efficiency and effectiveness in handling medical
                                                malpractice cases.
                                            </div>
                                            <div class="testimonial-slide-content-footer">

                                                <picture class="testimonial-slide-content-footer__image">
                                                    <source
                                                        srcset="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonials/airbnb.webp"
                                                        type="image/webp"
                                                        class="testimonial-slide-content-footer__img airbnb" />
                                                    <img src="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonials/airbnb.png"
                                                        alt="img" class="testimonial-slide-content-footer__img airbnb"
                                                        width="" height="" />
                                                </picture>

                                                <div class="testimonial-slide-content-footer-info">
                                                    <div class="testimonial-slide-content-footer-name">Brian Smith</div>
                                                    <div class="testimonial-slide-content-footer-role">Founder & CEO
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-slide-wrap">
                                        <div class="testimonial-slide-img-wrap">

                                            <picture class="testimonial-slide__image">
                                                <source
                                                    srcset="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonial-2.webp"
                                                    type="image/webp" class="testimonial-slide__img " />
                                                <img src="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonial-2.jpg"
                                                    alt="img" class="testimonial-slide__img " width="120"
                                                    height="120" />
                                            </picture>

                                        </div>
                                        <div class="testimonial-slide-content">
                                            <div class="testimonial-slide-content-stars">

                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>

                                            </div>
                                            <div class="testimonial-slide-content-text">
                                                At Carter & Dane Legal, we've found Med-Test.ai to be an invaluable
                                                tool. It has significantly improved our ability to manage complex
                                                personal injury cases by providing a clear, chronological overview of
                                                medical events. This clarity has enhanced our negotiation power, leading
                                                to more favorable settlements for our clients.
                                            </div>
                                            <div class="testimonial-slide-content-footer">

                                                <picture class="testimonial-slide-content-footer__image">
                                                    <source
                                                        srcset="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonials/icon-2.webp"
                                                        type="image/webp"
                                                        class="testimonial-slide-content-footer__img icon-2" />
                                                    <img src="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonials/icon-2.png"
                                                        alt="img" class="testimonial-slide-content-footer__img icon-2"
                                                        width="" height="" />
                                                </picture>

                                                <div class="testimonial-slide-content-footer-info">
                                                    <div class="testimonial-slide-content-footer-name">Samuel Dane</div>
                                                    <div class="testimonial-slide-content-footer-role">Managing Director
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-slide-wrap">
                                        <div class="testimonial-slide-img-wrap">

                                            <picture class="testimonial-slide__image">
                                                <source
                                                    srcset="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonial-3.webp"
                                                    type="image/webp" class="testimonial-slide__img " />
                                                <img src="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonial-3.jpg"
                                                    alt="img" class="testimonial-slide__img " width="120"
                                                    height="120" />
                                            </picture>

                                        </div>
                                        <div class="testimonial-slide-content">
                                            <div class="testimonial-slide-content-stars">

                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>

                                            </div>
                                            <div class="testimonial-slide-content-text">
                                                The integration of Med-Test.ai into our practice at Levine Law Group
                                                has transformed how we approach litigation. Being able to swiftly sift
                                                through extensive medical data and establish a timeline has empowered us
                                                to build stronger cases. Our clients have benefitted immensely, and
                                                we've seen a noticeable improvement in our case outcomes.
                                            </div>
                                            <div class="testimonial-slide-content-footer">

                                                <picture class="testimonial-slide-content-footer__image">
                                                    <source
                                                        srcset="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonials/icon-3.webp"
                                                        type="image/webp"
                                                        class="testimonial-slide-content-footer__img icon-3" />
                                                    <img src="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonials/icon-3.png"
                                                        alt="img" class="testimonial-slide-content-footer__img icon-3"
                                                        width="" height="" />
                                                </picture>

                                                <div class="testimonial-slide-content-footer-info">
                                                    <div class="testimonial-slide-content-footer-name">Michael Levine
                                                    </div>
                                                    <div class="testimonial-slide-content-footer-role">Senior Partner
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-slide-wrap">
                                        <div class="testimonial-slide-img-wrap">

                                            <picture class="testimonial-slide__image">
                                                <source
                                                    srcset="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonial-4.webp"
                                                    type="image/webp" class="testimonial-slide__img " />
                                                <img src="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonial-4.jpg"
                                                    alt="img" class="testimonial-slide__img " width="120"
                                                    height="120" />
                                            </picture>

                                        </div>
                                        <div class="testimonial-slide-content">
                                            <div class="testimonial-slide-content-stars">

                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>

                                            </div>
                                            <div class="testimonial-slide-content-text">
                                                Gibson & Hughes Associates highly recommends Med-Test.ai. It's not just
                                                a tool but a vital asset for any law firm handling cases with extensive
                                                medical records. The software's ability to organize and present data has
                                                made our legal arguments more compelling, directly contributing to our
                                                high success rate.
                                            </div>
                                            <div class="testimonial-slide-content-footer">

                                                <picture class="testimonial-slide-content-footer__image">
                                                    <source
                                                        srcset="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonials/icon-4.webp"
                                                        type="image/webp"
                                                        class="testimonial-slide-content-footer__img icon-4" />
                                                    <img src="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonials/icon-4.png"
                                                        alt="img" class="testimonial-slide-content-footer__img icon-4"
                                                        width="" height="" />
                                                </picture>

                                                <div class="testimonial-slide-content-footer-info">
                                                    <div class="testimonial-slide-content-footer-name">James Hughes
                                                    </div>
                                                    <div class="testimonial-slide-content-footer-role">Senior Partner
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-slide-wrap">
                                        <div class="testimonial-slide-img-wrap">

                                            <picture class="testimonial-slide__image">
                                                <source
                                                    srcset="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonial-5.webp"
                                                    type="image/webp" class="testimonial-slide__img " />
                                                <img src="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonial-5.jpg"
                                                    alt="img" class="testimonial-slide__img " width="120"
                                                    height="120" />
                                            </picture>

                                        </div>
                                        <div class="testimonial-slide-content">
                                            <div class="testimonial-slide-content-stars">

                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>


                                                <svg class="icon icon-star filled">
                                                    <use
                                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#star" />
                                                </svg>

                                            </div>
                                            <div class="testimonial-slide-content-text">
                                                Med-Test.ai has been a remarkable addition to our resources at Apollo &
                                                Merrick Solicitors. Its intuitive design and functionality have made it
                                                incredibly easy to train staff and integrate into our daily operations.
                                                It has significantly reduced the time needed to prepare for trials,
                                                allowing us to focus more on our clients. Our team can't imagine working
                                                without it.
                                            </div>
                                            <div class="testimonial-slide-content-footer">

                                                <picture class="testimonial-slide-content-footer__image">
                                                    <source
                                                        srcset="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonials/icon-5.webp"
                                                        type="image/webp"
                                                        class="testimonial-slide-content-footer__img icon-5" />
                                                    <img src="<?= base_url() ?>assets/themes/default/img/./content/homepage/testimonials/icon-5.jpg"
                                                        alt="img" class="testimonial-slide-content-footer__img icon-5"
                                                        width="" height="" />
                                                </picture>

                                                <div class="testimonial-slide-content-footer-info">
                                                    <div class="testimonial-slide-content-footer-name">Robert Klein
                                                    </div>
                                                    <div class="testimonial-slide-content-footer-role">Partner</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-buttons">
                                <div class="swiper-button-prev">
                                    <svg class="icon icon-slide-arrow ">
                                        <use
                                            href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#slide-arrow" />
                                    </svg>
                                </div>
                                <div class="swiper-button-next">
                                    <svg class="icon icon-slide-arrow ">
                                        <use
                                            href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#slide-arrow" />
                                    </svg>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </section>
            <section class="global-section preferences-section global-section-with-bg" id="preferences-section">
                <div class="container">
                    <div class="preferences-section-wrap provides-section-wrap js-section-wrap">
                        <h3 class="global-title preferences-section-title">Forget Old Workflows
                            <br class="tablet">Med-Test.AI
                            Makes All The Difference
                        </h3>
                        <p class="global-subtitle preferences-section-subtitle">Med-Test.AI holds the key to
                            simplifying even the most complex medical recordreview process. We deliver consistent, rapid
                            insights at a fraction of current costs.</p>

                        <p class="preferences-section-title_small provides-section-title_small">With Med-Test.AI at
                            your fingertips you can:</p>

                        <ul class="preferences-section-list global-section-list">
                            <li class="preferences-section-list-item m-w-33 global-section-card-with-icon-item">
                                <img class="preferences-section-list-item-icon global-section-card-with-icon-item__icon"
                                    src="<?= base_url() ?>assets/themes/default/svg/user-verify.svg"
                                    alt="Increase Consistency" width="60" height="60">
                                <span
                                    class="preferences-section-list-item-title global-section-card-with-icon-item__title">Increase
                                    Consistency</span>
                                <span
                                    class="preferences-section-list-item-text global-section-card-with-icon-item__text">Med-Test.AI
                                    provides unbiased and objective summarizations. Every file is processed with the
                                    utmost precision, ensuring consistency across all case preparations.</span>
                            </li>
                            <li class="preferences-section-list-item m-w-33 global-section-card-with-icon-item">
                                <img class="preferences-section-list-item-icon global-section-card-with-icon-item__icon"
                                    src="<?= base_url() ?>assets/themes/default/svg/price-down.svg" alt="Cost Savings"
                                    width="60" height="60">
                                <span
                                    class="preferences-section-list-item-title global-section-card-with-icon-item__title">40-60%
                                    Cost Savings</span>
                                <span
                                    class="preferences-section-list-item-text global-section-card-with-icon-item__text">Reduces
                                    hours and expenses associated with manual reviews. By eliminating the need for
                                    costly outsourcing, Med-Test.AI offers a more economical alternative.</span>
                            </li>
                            <li class="preferences-section-list-item m-w-33 global-section-card-with-icon-item">
                                <img class="preferences-section-list-item-icon global-section-card-with-icon-item__icon"
                                    src="<?= base_url() ?>assets/themes/default/svg/increase-time.svg"
                                    alt="Increased Productivity" width="60" height="60">
                                <span
                                    class="preferences-section-list-item-title global-section-card-with-icon-item__title">Increased
                                    Productivity</span>
                                <span
                                    class="preferences-section-list-item-text global-section-card-with-icon-item__text">Accelerated
                                    task completion increases your team's capacity, allowing them to focus on critical
                                    aspects of case and claim management.</span>
                            </li>
                            <li class="preferences-section-list-item global-section-card-with-icon-item">
                                <img class="preferences-section-list-item-icon global-section-card-with-icon-item__icon"
                                    src="<?= base_url() ?>assets/themes/default/svg/like-with-stars.svg"
                                    alt="Rapid Review Times" width="60" height="60">
                                <span
                                    class="preferences-section-list-item-title global-section-card-with-icon-item__title">Rapid
                                    Review Times</span>
                                <span
                                    class="preferences-section-list-item-text global-section-card-with-icon-item__text">With
                                    reports returned in hours instead of days, Med-Test.AI empowers you to make quicker
                                    decisions and improves client communication.</span>
                            </li>
                            </li>
                            <li class="preferences-section-list-item global-section-card-with-icon-item">
                                <img class="preferences-section-list-item-icon global-section-card-with-icon-item__icon"
                                    src="<?= base_url() ?>assets/themes/default/svg/achieve.svg"
                                    alt="Medico-Legal Technology" width="60" height="60">
                                <span
                                    class="preferences-section-list-item-title global-section-card-with-icon-item__title">Medico-Legal
                                    Technology</span>
                                <span
                                    class="preferences-section-list-item-text global-section-card-with-icon-item__text">Our
                                    AI is finely tuned to the specific vocabulary and nuances of civil litigation,
                                    offering a level of accuracy that is unmatched in manual reviews.</span>
                            </li>
                        </ul>
                        <?php if(getenv('CI_ENVIRONMENT')!=='production'): ?>
                        <a href="<?= base_url() ?>accounts/register"
                            class="btn btn-primary provides-section-btn">Experience Med-Test.AI Here</a>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
            <section class="global-section advantages-section">
                <div class="container">
                    <div class="advantages-section-wrap">
                        <h2 class="advantages-section-title hidden-title">Advantages</h2>
                        <div class="advantages-section-cards">
                            <div class="advantages-section-card">
                                <div class="tablet-title">What If Comprehensive
                                    <br>Litigation Preparation Took Just Hours?
                                </div>
                                <div class="tablet-subtitle">Med-Test.AI can also be used in ALL phases of litigation,
                                    as well as
                                    <br>before the lawsuit is filed. These use cases include:
                                </div>
                                <div class="advantages-section-card-content">
                                    <h4 class="advantages-section-card-content-title">What If Comprehensive Litigation
                                        Preparation Took Just Hours?</h4>
                                    <p class="advantages-section-card-content-subtitle">Med-Test.AI can also be used in
                                        ALL phases of litigation, as well as before the lawsuit is filed. These use
                                        cases include:</p>
                                    <ul class="advantages-section-card-content-list">
                                        <li class="advantages-section-card-content-list-item">
                                            <span class="advantages-section-card-content-list-item__icon-wrap">
                                                <img src="<?= base_url() ?>assets/themes/default/svg/conversation.svg"
                                                    alt="conversation icon">
                                            </span>
                                            <span class="advantages-section-card-content-list-item__text">Deposition and
                                                Mediation Preparation</span>
                                        </li>
                                        <li class="advantages-section-card-content-list-item">
                                            <span class="advantages-section-card-content-list-item__icon-wrap">
                                                <img src="<?= base_url() ?>assets/themes/default/svg/hammer.svg"
                                                    alt="hammer icon">
                                            </span>
                                            <span class="advantages-section-card-content-list-item__text">Jury and Bench
                                                Trial Preparation</span>
                                        </li>
                                        <li class="advantages-section-card-content-list-item">
                                            <span class="advantages-section-card-content-list-item__icon-wrap">
                                                <img src="<?= base_url() ?>assets/themes/default/svg/weights.svg"
                                                    alt="conversation icon">
                                            </span>
                                            <span class="advantages-section-card-content-list-item__text">Non-Binding
                                                and Binding Arbitration</span>
                                        </li>
                                        <li class="advantages-section-card-content-list-item">
                                            <span class="advantages-section-card-content-list-item__icon-wrap">
                                                <img src="<?= base_url() ?>assets/themes/default/svg/letter.svg"
                                                    alt="conversation icon">
                                            </span>
                                            <span class="advantages-section-card-content-list-item__text">And Demand
                                                Letters</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="advantages-section-card-content__img-wrap">

                                    <picture class="advantages-section-card-content__image">
                                        <source
                                            srcset="<?= base_url() ?>assets/themes/default/img/./content/homepage/advantages-1.webp"
                                            type="image/webp" class="advantages-section-card-content__img " />
                                        <img src="<?= base_url() ?>assets/themes/default/img/./content/homepage/advantages-1.jpg"
                                            alt="img" class="advantages-section-card-content__img " width="557"
                                            height="505" />
                                    </picture>

                                </div>
                            </div>
                            <div class="advantages-section-card">
                                <div class="tablet-title">Start Using Med-Test.AITo Your Advantage</div>
                                <div class="tablet-subtitle mb-12">For too long, law firms, insurance claims
                                    professionals and clinical experts have shouldered the weight of agonizing record
                                    and billing summarization. But with Med-Test.AI, the future you imagined is finally
                                    here.</div>
                                <div class="tablet-subtitle-small">We put advanced automation in your hands to:</div>
                                <div class="advantages-section-card-content">
                                    <h4 class="advantages-section-card-content-title">Start Using Med-Test. AI To Your
                                        Advantage</h4>
                                    <p class="advantages-section-card-content-subtitle">For too long, law firms,
                                        insurance claims professionals and clinical experts have shouldered the weight
                                        of agonizing record and billing summarization. But with Med-Test.AI, the future
                                        you imagined is finally here.</p>
                                    <p class="advantages-section-card-content-list-title">We put advanced automation in
                                        your hands to:</p>
                                    <ul class="advantages-section-card-content-list">
                                        <li class="advantages-section-card-content-list-item">
                                            <span class="advantages-section-card-content-list-item__icon-wrap">
                                                <img src="<?= base_url() ?>assets/themes/default/svg/search-info.svg"
                                                    alt="search icon">
                                            </span>
                                            <span class="advantages-section-card-content-list-item__text">Accelerate
                                                insight extraction</span>
                                        </li>
                                        <li class="advantages-section-card-content-list-item">
                                            <span class="advantages-section-card-content-list-item__icon-wrap">
                                                <img src="<?= base_url() ?>assets/themes/default/svg/increase-time.svg"
                                                    alt="time icon">
                                            </span>
                                            <span class="advantages-section-card-content-list-item__text">Expedite
                                                evaluation claims processing</span>
                                        </li>
                                        <li class="advantages-section-card-content-list-item">
                                            <span class="advantages-section-card-content-list-item__icon-wrap">
                                                <img src="<?= base_url() ?>assets/themes/default/svg/weights.svg"
                                                    alt="conversation icon">
                                            </span>
                                            <span class="advantages-section-card-content-list-item__text">And transform
                                                visibility</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="advantages-section-card-content__img-wrap">

                                    <picture class="advantages-section-card-content__image">
                                        <source
                                            srcset="<?= base_url() ?>assets/themes/default/img/./content/homepage/advantages-2.webp"
                                            type="image/webp" class="advantages-section-card-content__img " />
                                        <img src="<?= base_url() ?>assets/themes/default/img/./content/homepage/advantages-2.jpg"
                                            alt="img" class="advantages-section-card-content__img " width="557"
                                            height="442" />
                                    </picture>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="global-section faq-section" id="faq-section">
                <div class="container">
                    <div class="faq-section-wrap js-section-wrap">
                        <h3 class="global-title faq-section-title">Frequently Asked Questions</h3>
                        <p class="global-subtitle faq-section-subtitle">Common questions about Med-Test.AI are answered
                            here.</p>
                        <div class="faq-section-accordion js-faq-section-accordion">
                            <button type="button" class="faq-section-accordion-item js-faq-section-accordion-item">
                                <div class="faq-section-accordion-item-heading">
                                    <div class="text">What is the turnaround time for medical record and billing
                                        summaries?</div>

                                    <svg class="icon icon-arrow ">
                                        <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#arrow" />
                                    </svg>

                                </div>
                                <div class="faq-section-accordion-item-body">
                                    <div class="faq-section-accordion-item-body__content">
                                        Med-Test.AI is capable of processing medical summaries within the same day,
                                        often within just a few hours. Nearly all summaries are completed within 24
                                        hours. Medical billing summaries require even less time, as they involve few
                                        documents to review and are less complex.
                                    </div>
                                </div>
                            </button>
                            <button type="button" class="faq-section-accordion-item js-faq-section-accordion-item">
                                <div class="faq-section-accordion-item-heading">
                                    <div class="text">What security measures does Med-Test.AI have in place for medical
                                        records and billing?</div>

                                    <svg class="icon icon-arrow ">
                                        <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#arrow" />
                                    </svg>

                                </div>
                                <div class="faq-section-accordion-item-body">
                                    <div class="faq-section-accordion-item-body__content">
                                        Med-Test.AI is SOC2 certified, demonstrating our commitment to top-tier
                                        security measures. Our stringent security measures ensure we are safeguarding
                                        your data at all times.
                                    </div>
                                </div>
                            </button>
                            <button type="button" class="faq-section-accordion-item js-faq-section-accordion-item">
                                <div class="faq-section-accordion-item-heading">
                                    <div class="text">What type of claims can Med-Test.AI platform summarize?</div>

                                    <svg class="icon icon-arrow ">
                                        <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#arrow" />
                                    </svg>

                                </div>
                                <div class="faq-section-accordion-item-body">
                                    <div class="faq-section-accordion-item-body__content">
                                        Med-Test.AI platform can process the following types of claims: bodily injury;
                                        disability; medical malpractice; and workers compensation. Please contact us if
                                        you have a separate type of claim and we will be happy to determine if we may be
                                        of assistance.
                                    </div>
                                </div>
                            </button>
                            <button type="button" class="faq-section-accordion-item js-faq-section-accordion-item">
                                <div class="faq-section-accordion-item-heading">
                                    <div class="text">Why should my company/firm choose Med-Test.AI for medical and
                                        billing summaries?</div>

                                    <svg class="icon icon-arrow ">
                                        <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#arrow" />
                                    </svg>

                                </div>
                                <div class="faq-section-accordion-item-body">
                                    <div class="faq-section-accordion-item-body__content">
                                        Med-Test.AI was established by a lawyer with experience in personal injury law,
                                        representing both insurance defense firms and plaintiffs. Today, our team
                                        includes legal professionals, former claims adjusters, and AI engineers, all
                                        working together to customize summarizes to meet our clients' specific
                                        requirements. Our team is well-versed in both the insurance and legal sectors,
                                        ensuring that our summaries are effectively utilized in claims assessments,
                                        demand letters, depositions, mediations, arbitrations, and court trials. By
                                        leveraging our advanced AI platform, we aim to enhance consistency and
                                        productivity, saving our clients both time and money.
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
            <section class="global-section feedback-section global-section-with-bg-reverse" id="feedback-section">
                <div class="container">
                    <div class="feedback-section-wrap js-section-wrap">
                        <h3 class="feedback-section-title global-title">Get in touch</h3>
                        <h3 class="feedback-section-subtitle global-subtitle">Have questions? We’re ready to assist!
                        </h3>
                        <div class="feedback-section-form-wrap">
                            <form type="POST" action="<?= base_url() ?>landing/send-form" class="feedback-section-form js-feedback-section-form">
                                <div class="feedback-section-form-field form-field radio-group-field">
                                    <div class="feedback-section-form-field__title">Select topic of interest (optional):
                                    </div>
                                    <div class="feedback-section-form__radio-group">
                                        <label class="feedback-section-form__radio-label">
                                            <input type="radio" value="schedule_a_demo" name="topic_of_interest"
                                                id="schedule_a_demo" class="js-feedback-target">
                                            Schedule a demo
                                        </label>
                                        <label class="feedback-section-form__radio-label">
                                            <input type="radio" value="sales" name="topic_of_interest" id="sales">
                                            Sales
                                        </label>
                                        <label class="feedback-section-form__radio-label">
                                            <input type="radio" value="onboarding" name="topic_of_interest"
                                                id="onboarding">
                                            Onboarding
                                        </label>
                                        <label class="feedback-section-form__radio-label">
                                            <input type="radio" value="billing" name="topic_of_interest" id="billing">
                                            Billing
                                        </label>
                                        <label class="feedback-section-form__radio-label">
                                            <input type="radio" value="support" name="topic_of_interest" id="support">
                                            Support
                                        </label>
                                    </div>
                                </div>
                                <div class="feedback-section-form-field form-field col-6">
                                    <label for="first_name">First name*</label>
                                    <input type="text" name="first_name" id="first_name" class="js-feedback-input form-control"
                                        data-validation="true">
                                    <div class="invalid-feedback">Required field</div>
                                </div>
                                <div class="feedback-section-form-field form-field col-6">
                                    <label for="last_name">Last name*</label>
                                    <input type="text" name="last_name" id="last_name" class="js-feedback-input form-control"
                                        data-validation="true">
                                    <div class="invalid-feedback">Required field</div>
                                </div>
                                <div class="feedback-section-form-field form-field">
                                    <label for="email">Your email*</label>
                                    <input type="email" name="email" id="email" class="js-feedback-input form-control"
                                        data-validation="true">
                                    <div class="invalid-feedback">Required field</div>
                                </div>
                                <div class="feedback-section-form-field form-field">
                                    <label for="message">Write message*</label>
                                    <textarea name="message" id="message" class="js-feedback-input form-control"
                                        data-validation="true"></textarea>
                                    <div class="invalid-feedback">Required field</div>
                                </div>

                                <div class="feedback-section-form-footer">
                                    <div class="note">*Mandatory field</div>
                                    <button type="submit" class="btn btn-primary">Send message</button>
                                </div>
                            </form>
                            <div class="feedback-section-form-backface">

                                <svg class="icon icon-check-success ">
                                    <use
                                        href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#check-success" />
                                </svg>

                                <h3 class="feedback-section-form-backface-title">Thank you!
                                    <br>Your form has been successfully submitted.
                                </h3>
                                <p class="feedback-section-form-backface-subtitle">A member of our support team will
                                    contact you within one business day.</p>
                                <button type="button"
                                    class="feedback-section-form-backface-btn btn btn-primary">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>


        <footer class='landing-footer'>
            <div class="container">
                <div class="landing-footer-wrap">
                    <div class="landing-footer-rights">

                        <picture class="footer-rights__image">
                            <source srcset="<?= base_url() ?>assets/themes/default/img/./content/footer-logo.webp"
                                type="image/webp" class="footer-rights__img " />
                            <img src="<?= base_url() ?>assets/themes/default/img/./content/footer-logo.png" alt="img"
                                class="footer-rights__img " width="183" height="33" />
                        </picture>

                        <div class="landing-footer-rights-text">© 2023-<?=date('Y')?> Med-Test. All rights reserved.</div>
                    </div>
                    <div class="landing-footer-links">
                        <a href="#" class="landing-footer-link">Privacy Policy</a>
                        <a href="#" class="landing-footer-link">Cookie Settings</a>
                        <a href="#" class="landing-footer-link">24/7 Support</a>
                        <a href="mailto:support@med-test.ai" class="landing-footer-link">support@med-test.ai</a>
                    </div>

                    <picture class="footer-hippa__image">
                        <source srcset="<?= base_url() ?>assets/themes/default/img/./content/footer-landing-logo.webp"
                            type="image/webp" class="footer-hippa__img " />
                        <img src="<?= base_url() ?>assets/themes/default/img/./content/footer-landing-logo.png"
                            alt="img" class="footer-hippa__img " width="209" height="60" />
                    </picture>

                    <div class="landing-footer-rights-text-mobile">© 2023-<?=date('Y')?> Med-Test. All rights reserved.</div>
                </div>
            </div>
        </footer>
    </div>
    <script src="<?= base_url() ?>assets/themes/default/js/vendor.js"></script>
    <script src="<?= base_url() ?>assets/themes/default/js/main.js"></script>

    <script>
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
				}
			});
		</script>
</body>
</html>