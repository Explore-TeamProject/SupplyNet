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
    <title>Developer Team - SupplyNet</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" crossorigin="anonymous" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous">

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
            --shadow-sm: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.2);
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
            transition: all 0.3s ease;
        }

        .navbar-custom .navbar-brand {
            font-weight: 800;
            color: var(--primary-color) !important;
            font-size: 1.5rem;
        }

        .navbar-custom .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: color 0.3s ease;
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: var(--primary-color) !important;
        }

        .team-header {
            padding: 5rem 0;
            background: linear-gradient(135deg, rgba(78, 115, 223, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
            border-radius: 1rem;
            margin-bottom: 3rem;
            text-align: center;
        }

        .team-title {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(to right, #4e73df, #36b9cc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
            letter-spacing: -1px;
        }

        .team-subtitle {
            font-size: 1.25rem;
            max-width: 700px;
            margin: 0 auto;
            color: var(--secondary-color) !important;
        }

        .developer-card {
            border: none;
            border-radius: 1.25rem;
            background: var(--card-bg);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .developer-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .card-img-wrapper {
            width: 100%;
            height: 380px;
            position: relative;
            overflow: hidden;
            background-color: #f1f3f9;
        }

        .card-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
            transition: transform 0.6s ease;
        }

        .role-badge {
            position: absolute;
            top: 1.25rem;
            left: 1.25rem;
            z-index: 2;
            padding: 0.5rem 1rem;
            border-radius: 50rem;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .role-guider {
            color: #e74a3b;
        }

        .role-manager {
            color: #4e73df;
        }

        .role-member {
            color: #1cc88a;
        }

        .card-body {
            padding: 2rem;
            text-align: left;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .dev-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #3a3b45;
            margin-bottom: 0.5rem;
        }

        .dev-qualification {
            color: #858796;
            font-weight: 700;
            font-size: 0.95rem;
            margin-bottom: 1.25rem;
            letter-spacing: 0.3px;
        }

        .dev-description {
            font-size: 0.875rem;
            line-height: 1.6;
            color: #6e707e;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: auto;
            border-top: 1px solid #f1f3f9;
            padding-top: 1.25rem;
        }

        .social-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
        }

        .social-btn.linkedin {
            background: #0077b5;
            color: white;
        }

        .social-btn.github {
            background: #24292e;
            color: white;
        }

        .social-btn.email {
            background: #ea4335;
            color: white;
        }

        .social-btn:hover {
            transform: scale(1.15) rotate(5deg);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }
    </style>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/SupplyNet/favicon.ico">
    <!-- Global Preloader Style -->
    <style>
        #global-preloader {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: #ffffff;
            z-index: 99999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        .preloader-spinner {
            width: 50px; height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #4e73df;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>

<body>

<!-- Global Preloader -->
<div id="global-preloader">
    <div class="preloader-spinner"></div>
</div>
<script>
    window.addEventListener("load", function() {
        const preloader = document.getElementById("global-preloader");
        if (preloader) {
            preloader.style.opacity = "0";
            preloader.style.visibility = "hidden";
            setTimeout(function() {
                preloader.style.display = "none";
            }, 500);
        }
    });
</script>

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
                    <li class="nav-item"><a class="nav-link active"
                            href="<?php echo $basePath; ?>DeveloperTeam.php">Team</a></li>
                </ul>
                <div class=" d-flex align-items-center gap-3">
                    <a href="<?php echo $basePath; ?>login.php" class="text-decoration-none text-dark fw-bold">Login</a>
                    <a href="<?php echo $basePath; ?>register.php"
                        class="btn btn-primary rounded-pill px-4">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="team-header">
        <div class="container">
            <h1 class="team-title">Meet Our Team</h1>
            <p class="team-subtitle">The brilliant minds behind SupplyNet, working together to revolutionize
                supply chain management through technology and innovation.</p>

            <div class="row justify-content-center mt-5">
                <div class="col-lg-8">
                    <div class="p-4 rounded-4"
                        style="background: #ffffff; border: 1px solid rgba(0,0,0,0.05); box-shadow: var(--shadow);">
                        <h4 class="mb-3" style="color: var(--text-dark);"><i
                                class="fas fa-rocket me-2 text-primary"></i>Our Vision</h4>
                        <p class="mb-0" style="color: var(--secondary-color); line-height: 1.8;">
                            At SupplyNet, our mission is to simplify complex supply chain operations through elegant,
                            efficient, and scalable software solutions. Our team combines academic rigor with practical
                            development expertise to build a platform that empowers businesses to track, manage, and
                            optimize their inventory and sales with unprecedented clarity.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5 mb-5">
        <div class="row g-4 justify-content-center">
            <!-- Team Member 1: Dhaneshwar Mardi -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="developer-card">
                    <div class="role-badge role-guider">Project Guider</div>
                    <div class="card-img-wrapper">
                        <img src="protected-file.php?path=DhaneshwarMardi.jpg" alt="Dhaneshwar Mardi"
                            onerror="this.src='https://ui-avatars.com/api/?name=Dhaneshwar+Mardi&background=e74a3b&color=fff&size=800'">
                    </div>
                    <div class="card-body">
                        <h3 class="dev-name">Dhaneshwar Mardi</h3>
                        <div class="dev-qualification">Assistant Professor</div>

                        <p class="dev-description">
                            Dhaneshwar Mardi is the esteemed Project Guider at IMIT Cuttack. He provides strategic
                            leadership and technical mentorship, ensuring the SupplyNet project aligns with industry
                            benchmarks and academic excellence.
                        </p>

                        <div class="social-links">

                            <a href="mailto:dmardi@imit.ac.in" class="social-btn email" title="Email"><i
                                    class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Member 2: Abhijit Sahoo -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="developer-card">
                    <div class="role-badge role-manager">Project Manager/Backend Developer</div>
                    <div class="card-img-wrapper">
                        <img src="protected-file.php?path=AbhijitSahooabhi.jpeg" alt="Abhijit Sahoo"
                            onerror="this.src='https://ui-avatars.com/api/?name=Abhijit+Sahoo&background=4e73df&color=fff&size=800'">
                    </div>
                    <div class="card-body">
                        <h3 class="dev-name">Abhijit Sahoo</h3>
                        <div class="dev-qualification">Project Manager/Backend Developer</div>

                        <p class="dev-description">
                            Abhijit Sahoo combines strategic leadership with deep technical expertise as the Project
                            Manager and Lead Backend Developer. He is responsible for architecting robust server-side
                            systems, managing database integrity, and ensuring the platform's overall scalability.
                        </p>

                        <div class="social-links">
                            <a href="https://www.linkedin.com/in/abhijit-sahoo-abhi70303/" target="_blank"
                                class="social-btn linkedin" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="mailto:abhihors24@gmail.com" class="social-btn email" title="Email"><i
                                    class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Member 3: Pikesh Roul -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="developer-card">
                    <div class="role-badge role-member">Lead Developer</div>
                    <div class="card-img-wrapper">
                        <img src="protected-file.php?path=PikeshRoul.jpeg" alt="Pikesh Roul"
                            onerror="this.src='https://ui-avatars.com/api/?name=Pikesh+Roul&background=1cc88a&color=fff&size=800'">
                    </div>
                    <div class="card-body">
                        <h3 class="dev-name">Pikesh Roul</h3>
                        <div class="dev-qualification">Frontend Developer</div>

                        <p class="dev-description">
                            Pikesh Roul is the creative force behind SupplyNet's user interface as the Lead Frontend
                            Developer. He specializes in crafting modern, responsive, and highly interactive user
                            experiences, utilizing state-of-the-art web technologies to deliver a premium feel.
                        </p>

                        <div class="social-links">
                            <a href="https://www.linkedin.com/in/pikesh-roul-37b54a2b0/" target="_blank"
                                class="social-btn linkedin" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="mailto:pikeshroul1234@gmail.com" class="social-btn email" title="Email"><i
                                    class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Member 4: Debadata Rout -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="developer-card">
                    <div class="role-badge role-member">Database Developer</div>
                    <div class="card-img-wrapper">
                        <img src="protected-file.php?path=DebadataRout.jpeg" alt="Debadata Rout"
                            onerror="this.src='https://ui-avatars.com/api/?name=Debadata+Rout&background=1cc88a&color=fff&size=800'">
                    </div>
                    <div class="card-body">
                        <h3 class="dev-name">Debadata Rout</h3>
                        <div class="dev-qualification">Database Developer</div>

                        <p class="dev-description">
                            Debadata Rout is the creative force behind SupplyNet's user interface as the Lead Frontend
                            Developer. He specializes in crafting modern, responsive, and highly interactive user
                            experiences, utilizing state-of-the-art web technologies to deliver a premium feel.
                        </p>

                        <div class="social-links">
                            <a href="https://www.linkedin.com/in/debadata-rout/" target="_blank"
                                class="social-btn linkedin" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="mailto:routdebdata2003@gmail.com" class="social-btn email" title="Email"><i
                                    class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Member 5: Pabitra Ojha -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="developer-card">
                    <div class="role-badge role-member">Frontend Developer</div>
                    <div class="card-img-wrapper">
                        <img src="protected-file.php?path=PabitraOjha.png" alt="Pabitra Ojha"
                            onerror="this.src='https://ui-avatars.com/api/?name=Pabitra+Ojha&background=1cc88a&color=fff&size=800'">
                    </div>
                    <div class="card-body">
                        <h3 class="dev-name">Pabitra Ojha</h3>
                        <div class="dev-qualification">Frontend Developer</div>

                        <p class="dev-description">
                            Pabitra Ojha is the creative force behind SupplyNet's user interface as the Frontend
                            Developer. He specializes in crafting modern, responsive, and highly interactive user
                            experiences, utilizing state-of-the-art web technologies to deliver a premium feel.
                        </p>

                        <div class="social-links">
                            <a href="https://www.linkedin.com/in/pabitra-ojha/" target="_blank"
                                class="social-btn linkedin" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="mailto:pabitraojha60@gmail.com" class="social-btn email" title="Email"><i
                                    class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'config/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>

</html>