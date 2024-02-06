$stmt = $koneksi->prepare("SELECT * FROM userlogin WHERE UserName = ?");
if ($stmt) {
    // Bind parameter
    $stmt->bind_param("s", $login_id);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch the row
    $RowData = $result->fetch_assoc();

    // Close statement
    $stmt->close();
} else {
    // Handle error if prepare fails
    echo "Prepare statement failed.";
}
// script lama
// $Edit = mysqli_query($koneksi,"SELECT * FROM userlogin WHERE UserName ='$login_id'");
// $RowData = mysqli_fetch_assoc($Edit);
