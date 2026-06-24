<?php
include "connect.php";

$search = $_GET['search'] ?? '';

$stmt = $conn->prepare("
    SELECT id, username, specialty, bio, phone_number, profile_pic
    FROM users
    WHERE role = 'fundi'
    AND (
        username LIKE ?
        OR specialty LIKE ?
        OR bio LIKE ?
    )
");

$term = "%$search%";
$stmt->bind_param("sss", $term, $term, $term);

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        $image = !empty($row['profile_pic'])
            ? "uploads/" . $row['profile_pic']
            : "uploads/default.png";

        echo "
        <div class='fundi-card'>
            <img src='{$image}' alt='Profile'>
            <h3>{$row['username']}</h3>
            <p><strong>Specialty:</strong> {$row['specialty']}</p>
            <p>{$row['bio']}</p>
            <p>📞 {$row['phone_number']}</p>
        </div>
        ";
    }

} else {

    echo "
    <div class='no-results'>
        <h3>🔍 No Fundis Found</h3>
        <p>No registered fundi matches '<strong>" . htmlspecialchars($search) . "</strong>'</p>
    </div>
    ";
}

$stmt->close();
$conn->close();
?>