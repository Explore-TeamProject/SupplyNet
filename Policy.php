<?php
include 'config/db.php';
// Include trailing slash in basePath if not empty for cleaner links
$basePath = (strpos($_SERVER['REQUEST_URI'], '/SupplyNet') !== false) ? '/SupplyNet/' : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Policies - SupplyNet</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --primary-bg: #f8f9fc;
            --card-bg: #ffffff;
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --text-dark: #3a3b45;
            --shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            --shadow-hover: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--primary-bg);
            color: var(--secondary-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar-custom {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .navbar-custom .navbar-brand {
            font-weight: 800;
            color: var(--primary-color) !important;
        }

        .navbar-custom .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            margin: 0 0.5rem;
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: var(--primary-color) !important;
        }

        .policy-header {
            padding: 5rem 0 4rem;
            text-align: center;
            background: linear-gradient(135deg, rgba(78, 115, 223, 0.08) 0%, rgba(255, 255, 255, 0) 100%);
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
        }

        .policy-title {
            font-size: 3rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 1rem;
            letter-spacing: -1px;
        }

        .policy-subtitle {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
            color: var(--secondary-color);
        }

        .policy-section {
            background: var(--card-bg);
            border-radius: 1.5rem;
            box-shadow: var(--shadow);
            padding: 3rem;
            margin-bottom: 3rem;
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #f1f3f9;
        }

        .section-icon {
            width: 60px;
            height: 60px;
            background: rgba(78, 115, 223, 0.1);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            font-size: 1.5rem;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0;
        }

        .policy-list {
            list-style: none;
            padding: 0;
        }

        .policy-item {
            margin-bottom: 2rem;
            padding-left: 1.5rem;
            position: relative;
        }

        .policy-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0.6rem;
            width: 8px;
            height: 8px;
            background: var(--primary-color);
            border-radius: 50%;
        }

        .policy-item h4 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
        }

        .policy-item p {
            line-height: 1.7;
            font-size: 0.95rem;
            color: var(--secondary-color);
        }

        .academic-theme .section-icon {
            background: rgba(28, 200, 138, 0.1);
            color: var(--success-color);
        }

        .academic-theme .policy-item::before {
            background: var(--success-color);
        }

        .sidebar-nav {
            position: sticky;
            top: 100px;
        }

        .nav-pill-custom {
            border-radius: 1rem;
            padding: 0.75rem 1.25rem;
            color: var(--text-dark);
            font-weight: 600;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            margin-bottom: 0.5rem;
        }

        .nav-pill-custom:hover {
            background: rgba(78, 115, 223, 0.05);
            color: var(--primary-color);
        }

        .nav-pill-custom.active {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom sticky-top shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $basePath; ?>index.php"><i
                    class="fas fa-cubes me-2"></i>SupplyNet</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="<?php echo $basePath; ?>index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $basePath; ?>features.php">Features</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $basePath; ?>contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $basePath; ?>about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $basePath; ?>DeveloperTeam.php">Team</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <a href="<?php echo $basePath; ?>login.php"
                        class="text-decoration-none text-dark fw-bold">Login</a>
                    <a href="<?php echo $basePath; ?>register.php"
                        class="btn btn-primary rounded-pill px-4">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="policy-header">
        <div class="container">
            <h1 class="policy-title">Our Policies</h1>
            <p class="policy-subtitle text-muted">Comprehensive guidelines governing our academic standards and
                professional corporate operations at SupplyNet.</p>
        </div>
    </header>

    <div class="container py-5">
        <div class="row g-5">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="sidebar-nav">
                    <a href="#academic" class="nav-pill-custom active">
                        <i class="fas fa-university"></i> Academic Policies
                    </a>
                    <a href="#corporate" class="nav-pill-custom">
                        <i class="fas fa-building"></i> Corporate Policies
                    </a>
                    <a href="#privacy" class="nav-pill-custom">
                        <i class="fas fa-shield-alt"></i> Data Privacy
                    </a>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-lg-9">
                <!-- Academic Policies -->
                <section id="academic" class="policy-section academic-theme">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h2 class="section-title">Academic Policies</h2>
                    </div>
                    <div class="policy-list">
                        <div class="policy-item">
                            <h4>1. Academic Integrity & Originality</h4>
                            <p>Students and contributors are expected to maintain the highest standards of academic
                                honesty. All project submissions, code, and documentation must be the original work of
                                the individual or team. Plagiarism of any form is strictly prohibited and will lead to
                                immediate disqualification.</p>
                        </div>
                        <div class="policy-item">
                            <h4>2. Attendance & Participation</h4>
                            <p>Consistent attendance is mandatory for all academic modules and project briefings. A
                                minimum of 75% attendance is required to qualify for evaluation. Active participation in
                                collaborative coding sessions and workshops is highly encouraged.</p>
                        </div>
                        <div class="policy-item">
                            <h4>3. Grading & Evaluation Scheme</h4>
                            <p>Performance is evaluated based on a multi-dimensional approach, including code quality,
                                documentation accuracy, problem-solving efficiency, and adherence to project timelines.
                                Peer reviews are an integral part of the final assessment.</p>
                        </div>
                        <div class="policy-item">
                            <h4>4. Submission Deadlines</h4>
                            <p>Punctuality is a core virtue. All academic assignments and milestones must be submitted
                                through the SupplyNet portal before the specified deadline. Late submissions may attract
                                a penalty unless a valid medical or emergency reason is provided in advance.</p>
                        </div>
                    </div>
                </section>

                <!-- Corporate Policies -->
                <section id="corporate" class="policy-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h2 class="section-title">Corporate Policies</h2>
                    </div>
                    <div class="policy-list">
                        <div class="policy-item">
                            <h4>1. Workplace Code of Conduct</h4>
                            <p>We foster a professional work environment built on mutual respect, inclusion, and
                                integrity. Any form of harassment, discrimination, or unprofessional behavior will be
                                dealt with according to the strict guidelines of our HR policy.</p>
                        </div>
                        <div class="policy-item">
                            <h4>2. Information Security & Confidentiality</h4>
                            <p>Team members are entrusted with sensitive supply chain data and proprietary technology.
                                Maintaining strict confidentiality of trade secrets, client data, and internal systems
                                is a non-negotiable condition of collaboration.</p>
                        </div>
                        <div class="policy-item">
                            <h4>3. Conflict of Interest</h4>
                            <p>All employees and developers must disclose any potential conflicts of interest that could
                                influence their judgment or actions within SupplyNet. Personal financial interests in
                                competing platforms must be declared immediately.</p>
                        </div>
                        <div class="policy-item">
                            <h4>4. Ethics in Technology</h4>
                            <p>Our technology must be used responsibly. We are committed to developing software that is
                                ethical, unbiased, and serves the greater good. Misuse of the platform for illicit
                                tracking or data manipulation is strictly forbidden.</p>
                        </div>
                    </div>
                </section>

                <!-- Data Privacy -->
                <section id="privacy" class="policy-section" style="border-left: 4px solid var(--info-color);">
                    <div class="section-header">
                        <div class="section-icon"
                            style="background: rgba(54, 185, 204, 0.1); color: var(--info-color);">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h2 class="section-title">Data Privacy & Security</h2>
                    </div>
                    <div class="policy-list">
                        <div class="policy-item">
                            <h4>Personal Data Protection</h4>
                            <p>SupplyNet collects minimal personal data required for system operation. We employ
                                encryption and secure hashing for all sensitive information. We never sell user data to
                                third parties.</p>
                        </div>
                        <div class="policy-item">
                            <h4>Data Retention</h4>
                            <p>System logs and operational data are retained for as long as necessary to provide
                                services and comply with legal obligations. Users can request their data to be purged
                                from our active systems at any time.</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'config/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Smooth scrolling for sidebar links
        document.querySelectorAll('.nav-pill-custom').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                document.querySelector(targetId).scrollIntoView({
                    behavior: 'smooth'
                });

                // Update active state
                document.querySelectorAll('.nav-pill-custom').forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Simple scrollspy to update active link on scroll
        window.addEventListener('scroll', () => {
            let current = '';
            document.querySelectorAll('section').forEach(section => {
                const sectionTop = section.offsetTop;
                if (pageYOffset >= sectionTop - 150) {
                    current = section.getAttribute('id');
                }
            });

            document.querySelectorAll('.nav-pill-custom').forEach(nav => {
                nav.classList.remove('active');
                if (nav.getAttribute('href') === '#' + current) {
                    nav.classList.add('active');
                }
            });
        });
    </script>

</body>

</html>