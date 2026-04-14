<style>
    /* New Dark Footer Styles following image spec */
    .footer-custom {
        background-color: #0b110e;
        color: #8c9b92;
        padding: 5rem 0 2rem;
        font-family: 'Inter', sans-serif;
        border-top: 1px solid #1a251f;
        margin-top: auto;
    }

    @media (max-width: 768px) {
        .footer-custom {
            padding: 3rem 0 2rem;
            text-align: center;
        }

        .footer-brand {
            justify-content: center;
        }

        .footer-contact-item {
            justify-content: center;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .footer-social-icon-group {
            justify-content: center;
        }

        .trusted-by-box {
            justify-content: center;
            text-align: left;
        }
    }

    .footer-custom h6 {
        color: #ffffff;
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 1.5rem;
    }

    .footer-custom a.text-decoration-none {
        color: #8c9b92;
        transition: color 0.3s ease;
        font-size: 0.9rem;
        text-decoration: none;
    }

    .footer-custom a.text-decoration-none:hover {
        color: #1cc88a;
    }

    .footer-social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border: 1px solid #1a251f;
        border-radius: 8px;
        color: #8c9b92;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .footer-social-icon:hover {
        border-color: #1cc88a;
        color: #1cc88a;
        background-color: rgba(28, 200, 138, 0.1);
    }

    .trusted-by-box {
        background-color: #111a14;
        border: 1px solid #1a251f;
        border-radius: 12px;
        padding: 1.25rem;
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    .trusted-by-box i {
        color: #1cc88a;
        font-size: 1.2rem;
        background: rgba(28, 200, 138, 0.1);
        padding: 10px;
        border-radius: 8px;
    }

    .footer-contact-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 18px;
        font-size: 0.9rem;
    }

    .footer-contact-item i {
        color: #1cc88a;
        margin-top: 5px;
        font-size: 1.1rem;
    }

    .footer-brand i {
        color: #fff;
        background: #1cc88a;
        padding: 6px;
        border-radius: 8px;
        font-size: 1.2rem;
    }

    /* Universal Stacked Table for Dashboards */
    @media (max-width: 768px) {
        .table-responsive-stack thead {
            display: none;
        }

        .table-responsive-stack tr {
            display: block;
            margin-bottom: 1.5rem;
            border: 1px solid #e3e6f0;
            border-radius: 0.75rem;
            background: #fff;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            overflow: hidden;
        }

        .table-responsive-stack td {
            display: block;
            text-align: left !important;
            border: none !important;
            padding: 1rem 1.25rem !important;
            position: relative;
            border-bottom: 1px solid #f8f9fc !important;
        }

        .table-responsive-stack td::before {
            content: attr(data-label);
            display: block;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.65rem;
            color: #4e73df;
            margin-bottom: 0.25rem;
            opacity: 0.8;
        }

        .table-responsive-stack td:last-child {
            border-bottom: none !important;
        }

        .table-responsive-stack .ps-4 {
            padding-left: 1.25rem !important;
        }
    }
</style>
<footer class="footer-custom">
    <div class="container-fluid px-4 px-lg-5">
        <div class="row g-5">
            <!-- Col 1 -->
            <div class="col-lg-4 col-md-12">
                <div class="d-flex align-items-center mb-4 footer-brand">
                    <i class="fas fa-cubes me-2"></i>
                    <h4 class="text-white fw-bold mb-0 ms-1">SupplyNet</h4>
                </div>
                <p class="mb-5 text-sm pe-lg-4" style="font-size: 0.9rem; line-height: 1.6;">
                    Streamlining your supply chain operations from end-to-end with intelligent tracking, real-time
                    analytics, and seamless cross-departmental coordination.
                </p>
                <div class="footer-contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>IMIT, Cuttack, Odisha, India</div>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-phone-alt ms-1 text-center" style="width: 14px;"></i>
                    <div>+91 (XXX) XXX-XXXX</div>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-envelope ms-1 text-center" style="width: 14px;"></i>
                    <div>contact@supplynet.io</div>
                </div>
                <div class="d-flex gap-2 mt-5 footer-social-icon-group">
                    <a href="#" class="footer-social-icon"><i class="fas fa-globe"></i></a>
                    <a href="#" class="footer-social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="footer-social-icon"><i class="fas fa-at"></i></a>
                    <a href="#" class="footer-social-icon"><i class="fas fa-hashtag"></i></a>
                </div>
            </div>

            <!-- Col 2 -->
            <div class="col-lg-2 col-md-4 ms-lg-auto">
                <h6 class="mb-4 mt-4 mt-md-0">Quick Links</h6>
                <?php
                // Include trailing slash in basePath if not empty for cleaner links
                $basePath = (strpos($_SERVER['REQUEST_URI'], '/SupplyNet') !== false) ? '/SupplyNet/' : '';
                ?>
                <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
                    <li><a href="<?php echo $basePath; ?>index.php" class="text-decoration-none">Home</a></li>
                    <li><a href="<?php echo $basePath; ?>features.php" class="text-decoration-none">Features</a></li>
                    <li><a href="<?php echo $basePath; ?>about.php" class="text-decoration-none">Our Story</a></li>
                    <li><a href="<?php echo $basePath; ?>contact.php" class="text-decoration-none">Contact</a></li>
                    <li><a href="<?php echo $basePath; ?>DeveloperTeam.php" class="text-decoration-none">Developer
                            Team</a></li>
                </ul>
            </div>

            <!-- Col 3 -->
            <div class="col-lg-2 col-md-4">
                <h6 class="mb-4 mt-4 mt-md-0">Resources</h6>
                <ul class="list-unstyled d-flex flex-column gap-3 mb-4">
                    <li><a href="#" class="text-decoration-none">Documentation</a></li>
                    <li><a href="<?php echo $basePath; ?>login.php" class="text-decoration-none">Login</a></li>
                    <li><a href="<?php echo $basePath; ?>register.php" class="text-decoration-none">Register</a></li>
                </ul>

                <h6 class="mb-4">Legal</h6>
                <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
                    <li><a href="<?php echo $basePath; ?>Policy.php#privacy" class="text-decoration-none">Privacy Policy</a></li>
                    <li><a href="<?php echo $basePath; ?>Policy.php" class="text-decoration-none">Terms of Service</a></li>
                </ul>
            </div>

            <!-- Col 4 -->
            <div class="col-lg-3 col-md-4">
                <div class="trusted-by-box mt-4 mt-lg-0">
                    <i class="fas fa-shield-alt"></i>
                    <div>
                        <div class="text-white fw-bold mb-1" style="font-size: 0.9rem; letter-spacing: 0.5px;">TRUSTED
                            BY</div>
                        <div class="small">500+ businesses<br>across 12 countries</div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="mt-5 mb-4" style="border-color: #1a251f; opacity: 1;">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0" style="font-size: 0.8rem;">&copy; <?php echo date('Y'); ?> SupplyNet. All rights
                    reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <p class="mb-0" style="font-size: 0.8rem;">IMIT, Cuttack</p>
            </div>
        </div>
    </div>
</footer>