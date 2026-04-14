<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['UserID']) || strtolower($_SESSION['Role']) !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$admin_name = $_SESSION['UserName'] ?? 'Administrator';

// Handling Actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';
    $target_user_id = intval($_POST['user_id'] ?? 0);
    
    // Safety check - cannot approve or reject yourself
    if ($target_user_id > 0 && $target_user_id !== $_SESSION['UserID']) {
        if ($action === 'approve') {
            $stmt = $conn->prepare("UPDATE Users SET approval_status='approved', IsActive=1 WHERE UserID=? AND Role='admin'");
            $stmt->bind_param("i", $target_user_id);
            $stmt->execute();
        } elseif ($action === 'reject') {
            $stmt = $conn->prepare("UPDATE Users SET approval_status='rejected', IsActive=0 WHERE UserID=? AND Role='admin'");
            $stmt->bind_param("i", $target_user_id);
            $stmt->execute();
        } elseif ($action === 'delete') {
            $stmt = $conn->prepare("UPDATE Users SET markasdeleted=1 WHERE UserID=? AND Role='admin'");
            $stmt->bind_param("i", $target_user_id);
            $stmt->execute();
        }
        header("Location: admin_approvals.php");
        exit();
    }
}

// Fetch all admins
$admins = [];
$search_query = "";
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search_term = $conn->real_escape_string(trim($_GET['search']));
    $search_query = " AND (u.UserName LIKE '%$search_term%' OR u.Email LIKE '%$search_term%') ";
}

$res = $conn->query("
    SELECT u.*
    FROM Users u
    WHERE u.Role = 'admin' AND u.markasdeleted=0 AND u.UserID != '{$_SESSION['UserID']}' $search_query 
    ORDER BY CASE WHEN u.approval_status = 'pending' THEN 1 ELSE 2 END, u.CreatedAt DESC
");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $admins[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Approvals - SupplyNet Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary-color: #4e73df; --sidebar-width: 250px; }
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fc; overflow-x: hidden; }
        .sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; background: linear-gradient(180deg, #4e73df 10%, #224abe 100%); color: #fff; z-index: 1000; box-shadow: 2px 0 10px rgba(0,0,0,0.1); }
        .sidebar .brand { padding: 1.5rem 1rem; font-size: 1.25rem; font-weight: 800; text-align: center; text-transform: uppercase; letter-spacing: 0.05rem; border-bottom: 1px solid rgba(255,255,255,0.1); display: block; color: #fff; text-decoration: none; }
        .nav-item { padding: 0 1rem; margin-bottom: 0.5rem; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 1rem; border-radius: 0.5rem; font-weight: 600; transition: all 0.3s; }
        .nav-link:hover, .nav-link.active { color: #fff; background: rgba(255,255,255,0.15); transform: translateX(5px); }
        .nav-link i { margin-right: 0.75rem; width: 20px; text-align: center; }
        .main-wrapper { margin-left: var(--sidebar-width); flex-grow: 1; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: #fff; height: 70px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); display: flex; align-items: center; justify-content: space-between; padding: 0 2rem; }
        .topbar-user { font-weight: 600; color: #5a5c69; display: flex; align-items: center; gap: 0.5rem; }
        .topbar-user img { width: 35px; height: 35px; border-radius: 50%; border: 2px solid var(--primary-color); }
        .dashboard-content { padding: 1.5rem 2rem; }
        .card-custom { border: none; border-radius: 0.75rem; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); margin-bottom: 1.5rem; }
        .btn-action { margin-right: 0.25rem; padding: 0.25rem 0.6rem; font-size: 0.85rem; border-radius: 0.4rem; font-weight: 600; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s ease-in-out; }
            .sidebar.show-sidebar { transform: translateX(0); }
            .main-wrapper { margin-left: 0; width: 100%; }
            .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 999; cursor: pointer; }
            .sidebar-overlay.show { display: block; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <a href="index.php" class="brand"><i class="fas fa-cubes me-2"></i>SupplyNet<br><small class="text-white-50" style="font-size: 0.7rem;">Admin Panel</small></a>
    <div class="mt-4">
        <div class="nav-item"><a href="index.php" class="nav-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a></div>
        <div class="nav-item"><a href="user_management.php" class="nav-link"><i class="fas fa-users"></i> User Management</a></div>
        <div class="nav-item"><a href="admin_approvals.php" class="nav-link active"><i class="fas fa-user-shield"></i> Admin Approvals</a></div>
        <div class="nav-item"><a href="products_directory.php" class="nav-link"><i class="fas fa-box-open"></i> Products Directory</a></div>
        <div class="nav-item"><a href="orders_hub.php" class="nav-link"><i class="fas fa-truck-loading"></i> Orders Hub</a></div>
        <div class="nav-item"><a href="delivery_route.php" class="nav-link"><i class="fas fa-route"></i> Deliveries & Routes</a></div>
        <div class="nav-item"><a href="customer_feedback.php" class="nav-link"><i class="fas fa-comments"></i> Customer Feedback</a></div>
        <div class="nav-item"><a href="system_settings.php" class="nav-link"><i class="fas fa-cogs"></i> System Settings</a></div>
    </div>
</div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>
<div class="main-wrapper">
    <div class="topbar">
        <div class="d-flex align-items-center">
            <button class="btn btn-link d-md-none text-dark me-3" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <h4 class="m-0 fw-bold text-dark">Admin Approvals</h4>
        </div>
        <div class="d-flex align-items-center gap-4">
            <div class="dropdown d-inline-block">
                <a href="#" class="text-secondary position-relative dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none;">
                    <i class="fas fa-bell fs-5"></i>
                    <?php if(!empty($notif_data) && $notif_data['count'] > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                            <?php echo $notif_data['count']; ?>
                        </span>
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 py-0 dropdown-menu-notif" style="min-width: 320px; max-height: 400px; overflow-y: auto;">
                    <li class="dropdown-header bg-primary text-white fw-bold py-2 rounded-top d-flex justify-content-between align-items-center">
                        <span>Notifications</span>
                        <?php if(!empty($notif_data) && $notif_data['count'] > 0): ?>
                            <span class="badge bg-light text-primary rounded-pill"><?php echo $notif_data['count']; ?> New</span>
                        <?php endif; ?>
                    </li>
                    <?php if(empty($notif_data) || empty($notif_data['list'])): ?>
                        <li><a class="dropdown-item text-muted py-4 text-center" href="#"><i class="fas fa-bell-slash fs-4 d-block mb-2 opacity-50"></i>No new notifications</a></li>
                    <?php else: ?>
                        <?php foreach($notif_data['list'] as $n): ?>
                            <li class="border-bottom">
                                <a class="dropdown-item py-3 text-wrap <?php echo !$n['IsRead'] ? 'fw-bold bg-light' : ''; ?>" href="#" style="font-size: 0.85rem; line-height: 1.4; white-space: normal;">
                                    <div class="small text-muted mb-1 d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-clock me-1"></i><?php echo date('M d, h:i A', strtotime($n['CreatedAt'])); ?></span>
                                        <?php if(!$n['IsRead']): ?><span class="badge bg-danger p-1 border border-light rounded-circle" style="width: 8px; height: 8px;"></span><?php endif; ?>
                                    </div>
                                    <div class="text-dark"><?php echo htmlspecialchars($n['Message']); ?></div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <li><a class="dropdown-item text-center small text-primary fw-bold py-2 bg-light rounded-bottom text-decoration-none" href="?mark_read=true"><i class="fas fa-check-double me-1"></i>Mark all as read</a></li>
                </ul>
            </div>
            <div class="dropdown">
                <a class="text-decoration-none topbar-user dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <span class="d-none d-lg-inline"><?php echo htmlspecialchars($admin_name); ?></span>
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($admin_name); ?>&background=4e73df&color=fff" alt="Admin Profile">
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                    <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i> Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="../logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="card card-custom">
            <div class="card-header bg-white border-bottom py-3 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <h6 class="m-0 font-weight-bold text-primary" style="font-weight: 700;"><i class="fas fa-user-shield me-2"></i>Administrator Requests</h6>
                
                <form action="admin_approvals.php" method="GET" class="d-flex m-0" style="flex: 1; min-width: 300px; max-width: 450px;">
                    <div class="input-group shadow-sm" style="border-radius: 50rem; overflow: hidden; background: #fcfcfc; border: 1px solid #e3e6f0;">
                        <span class="input-group-text bg-transparent border-0 text-primary ps-3 pe-2"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control bg-transparent border-0 shadow-none ps-1" placeholder="Search admins..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" style="font-size: 0.9rem;">
                        <button class="btn btn-primary px-4" type="submit" style="font-weight: 600; letter-spacing: 0.03rem;">Search</button>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle border">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($admins)): ?>
                                <tr><td colspan="4" class="text-center py-4 text-muted">No other administrators found.</td></tr>
                            <?php else: ?>
                                <?php foreach($admins as $a): ?>
                                <tr>
                                    <td class="fw-semibold text-dark">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-weight:bold;">
                                                <?php echo strtoupper(substr($a['UserName'], 0, 1)); ?>
                                            </div>
                                            <?php echo htmlspecialchars($a['UserName']); ?>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($a['Email']); ?></td>
                                    <td>
                                        <?php if($a['approval_status'] == 'pending'): ?>
                                            <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Pending</span>
                                        <?php elseif($a['approval_status'] == 'rejected'): ?>
                                            <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Rejected</span>
                                        <?php else: ?>
                                            <span class="badge bg-success"><i class="fas fa-check me-1"></i>Approved</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <form action="admin_approvals.php" method="POST" class="d-inline mb-0">
                                            <input type="hidden" name="user_id" value="<?php echo $a['UserID']; ?>">
                                            
                                            <?php if($a['approval_status'] == 'pending' || $a['approval_status'] == 'rejected'): ?>
                                                <button title="Approve" type="submit" name="action" value="approve" class="btn btn-action btn-success"><i class="fas fa-check"></i> Approve</button>
                                            <?php endif; ?>
                                            
                                            <?php if($a['approval_status'] == 'pending' || $a['approval_status'] == 'approved'): ?>
                                                <button title="Reject" type="submit" name="action" value="reject" class="btn btn-action btn-outline-danger"><i class="fas fa-times"></i> Reject</button>
                                            <?php endif; ?>
                                            
                                            <button title="Delete Admin" type="submit" name="action" value="delete" class="btn btn-action btn-danger" onclick="return confirm('Are you sure you want to permanently delete this administrator?');"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include '../config/footer.php'; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var sidebarToggle = document.getElementById('sidebarToggle');
        var sidebar = document.querySelector('.sidebar');
        var sidebarOverlay = document.getElementById('sidebarOverlay');
        
        if(sidebarToggle && sidebar && sidebarOverlay) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show-sidebar');
                sidebarOverlay.classList.toggle('show');
            });
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('show-sidebar');
                sidebarOverlay.classList.remove('show');
            });
        }
    });
</script>
</body>
</html>
