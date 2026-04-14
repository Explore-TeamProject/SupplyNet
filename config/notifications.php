<?php
// Function to fetch unread notifications for a specific user and role
function getNotifications($conn, $user_id, $role) {
    if (!$conn || !$user_id || !$role) return ['count' => 0, 'list' => []];
    
    $notifications = [];
    $unread_count = 0;
    
    // Fetch notifications targeting either the specific UserID or the generic Role
    $query = "
        SELECT NotificationID, Message, CreatedAt, IsRead
        FROM Notifications 
        WHERE (UserID = ? OR Role = ?) 
        ORDER BY CreatedAt DESC 
        LIMIT 5
    ";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("is", $user_id, $role);
        $stmt->execute();
        $res = $stmt->get_result();
        while($row = $res->fetch_assoc()) {
            if (!$row['IsRead']) $unread_count++;
            $notifications[] = $row;
        }
        $stmt->close();
    }
    
    return [
        'count' => $unread_count,
        'list' => $notifications
    ];
}

// Function to add a notification
function addNotification($conn, $message, $user_id = null, $role = null) {
    $query = "INSERT INTO Notifications (UserID, Role, Message) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("iss", $user_id, $role, $message);
        $stmt->execute();
        $stmt->close();
    }
}

// Global hook if a user is logged in
if (isset($_SESSION['UserID']) && isset($_SESSION['Role'])) {
    $notif_user_id = $_SESSION['UserID'];
    $notif_role = $_SESSION['Role'];
    
    // Global mark as read handler
    if (isset($_GET['mark_read'])) {
        $upd = "UPDATE Notifications SET IsRead = 1 WHERE (UserID = ? OR Role = ?) AND IsRead = 0";
        if($stmt = $conn->prepare($upd)) {
            $stmt->bind_param("is", $notif_user_id, $notif_role);
            $stmt->execute();
            $stmt->close();
        }
        // Redirect to same URL without the mark_read param
        $url = strtok($_SERVER["REQUEST_URI"], '?');
        header("Location: " . $url);
        exit();
    }
    
    $notif_data = getNotifications($conn, $notif_user_id, $notif_role);
} else {
    $notif_data = ['count' => 0, 'list' => []];
}
?>
