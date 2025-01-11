<?php
require('../connection/db.php');

// Check if a student ID is provided
if (isset($_GET['id'])) {
    $studentID = intval($_GET['id']); // Get the student ID

    // Delete the student from the database
    $sql = "DELETE FROM students_v WHERE StudentID = $studentID";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Student deleted successfully.');
                window.location.href = '../admins_dashboard/v.php'; // Redirect to the list of students
              </script>";
    } else {
        echo "<script>
                alert('Error deleting student.');
                window.location.href = '../admins_dashboard/v.php'; // Redirect back to the list of students
              </script>";
    }
} else {
    echo "<script>
            alert('Invalid request.');
            window.location.href = '../admins_dashboaerd/v.php'; // Redirect back to the list of students
          </script>";
}

// Close database connection
mysqli_close($conn);
