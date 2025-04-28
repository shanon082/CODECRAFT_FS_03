<?php
session_start();

require_once("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $name = $_POST['coordinator_name'];
    $contact = $_POST['coordinator_contact'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO coordinators (username, coordinator_contact, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $contact, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>
            alert('Coordinator added successfully');
            window.location.href = 'Admin_Coordinator_dashboard.php';
        </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Handle update/delete form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['update']) || isset($_POST['delete']))) {
    $id = $_POST['id'];
    $action = isset($_POST['update']) ? 'update' : 'delete';

    if ($action === 'update') {
        $new_name = $_POST['coordinator_name'];
        $new_contact = $_POST['coordinator_contact'];
        $new_email = $_POST['email'];
        $new_password = $_POST['password'];

        // Check if the password field is not empty
        if (!empty($new_password)) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update all fields including the password
            $stmt = $conn->prepare("UPDATE coordinators SET username = ?, coordinator_contact = ?, email = ?, password = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $new_name, $new_contact, $new_email, $hashed_password, $id);
        } else {
            // Update all fields except the password
            $stmt = $conn->prepare("UPDATE coordinators SET username = ?, coordinator_contact = ?, email = ? WHERE id = ?");
            $stmt->bind_param("sssi", $new_name, $new_contact, $new_email, $id);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Coordinator updated successfully!'); window.location.href = 'Admin_Coordinator_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error updating coordinator: " . addslashes($stmt->error) . "');</script>";
        }
        $stmt->close();
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM coordinators WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<script>alert('Coordinator deleted successfully!'); window.location.href = 'Admin_Coordinator_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error deleting coordinator: " . addslashes($stmt->error) . "');</script>";
        }
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="script.js"></script> <!-- Include script.js -->
    <title>Manage Coordinator - Final Management System</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    body {
        background: linear-gradient(135deg, #e6f0fa 0%, #f7f9fc 100%);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .main-content {
        margin-left: 250px;
        padding: 40px;
        flex-grow: 1;
        min-height: 100vh;
        animation: fadeIn 0.8s ease-out;
    }

    .content-header {
        margin-bottom: 30px;
        padding: 0 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        animation: fadeInUp 0.6s ease-out;
    }

    .content-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a1a1a;
    }

    .add-btn {
        display: inline-block;
        padding: 12px 24px;
        background: linear-gradient(45deg, #00aaff, #007bff);
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        font-size: 1rem;
        border: none;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 170, 255, 0.3);
        cursor: pointer;
    }

    .add-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 170, 255, 0.4);
    }

    .table-container {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        animation: fadeInUp 0.6s ease-out 0.2s;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        font-size: 0.95rem;
        color: #333;
    }

    th {
        background: #f7f9fc;
        font-weight: 600;
        color: #1a1a1a;
        border-bottom: 2px solid #eee;
    }

    td {
        border-bottom: 1px solid #eee;
    }

    tr:hover {
        background: #f0f2f5;
    }

    .action-btn {
        padding: 8px 15px;
        background: #00aaff;
        color: #fff;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        background: #007bff;
        transform: translateY(-2px);
    }

    /* Modal Styles (Add and Edit) */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 2000;
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.3s ease-out;
    }

    .modal-content {
        background: #ffffff;
        border-radius: 12px;
        padding: 30px;
        width: 400px;
        max-width: 90%;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        position: relative;
        animation: slideInUp 0.4s ease-out;
    }

    .modal-content h3 {
        font-size: 1.8rem;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 20px;
        text-align: center;
    }

    .modal-content form {
        display: flex;
        flex-direction: column;
    }

    .modal-content input {
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: border-color 0.3s ease;
    }

    .modal-content input:focus {
        border-color: #00aaff;
        box-shadow: 0 0 8px rgba(0, 170, 255, 0.2);
        outline: none;
    }

    .modal-content .btn-group {
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .modal-content input[type="submit"],
    .modal-content button {
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 45%;
    }

    .modal-content input[type="submit"] {
        background: linear-gradient(45deg, #00aaff, #007bff);
        color: #fff;
        box-shadow: 0 4px 10px rgba(0, 170, 255, 0.3);
    }

    .modal-content input[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 170, 255, 0.4);
    }

    .modal-content button {
        background: #d32f2f;
        color: #fff;
        height: 48px;
        box-shadow: 0 4px 10px rgba(211, 47, 47, 0.3);
    }

    .modal-content input[name="delete"] {
        background: red;
    }

    .modal-content button[name="back"] {
        background: #666;
        width: 100%;
    }

    .modal-content button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

    .close-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 1.5rem;
        color: #666;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .close-btn:hover {
        color: #1a1a1a;
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-content {
            margin-left: 0;
            padding: 20px;
        }

        .content-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .content-header h2 {
            font-size: 2rem;
        }

        .modal-content {
            width: 90%;
            padding: 20px;
        }
    }

    @media (max-width: 480px) {
        .content-header h2 {
            font-size: 1.8rem;
        }

        .add-btn {
            padding: 10px 20px;
            font-size: 0.95rem;
        }

        th,
        td {
            font-size: 0.9rem;
            padding: 10px;
        }

        .modal-content h3 {
            font-size: 1.5rem;
        }

        .modal-content input,
        .modal-content input[type="submit"],
        .modal-content button {
            font-size: 0.9rem;
            padding: 10px;
            width: 100%;
        }
    }
</style>

<body>
    <?php
    include("headerAdmin.php");
    ?>
    <div class="main-content">
        <div class="content-header">
            <h2>Coordinator</h2>
            <button class="add-btn" onclick="openModal('add')">Add Coordinator</button>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>email</th>
                        <th>role</th>
                        <th>created_at</th>
                        <th>change</th>

                    </tr>
                </thead>
                <tbody>
                    <?php include 'fetch_coordinatorz.php'; ?>
                </tbody>
            </table>
        </div>

    </div>
    <!-- add cordinator modal -->
    <div class="modal" id="addCoordinatorModal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">×</span>
            <h3>Add Coordinator</h3>
            <form action="Admin_Coordinator_dashboard.php" method="POST">
                <input type="text" name="coordinator_name" placeholder="Coordinator Name" required>
                <input type="text" name="coordinator_contact" placeholder="Coordinator Contact" required>
                <input type="text" name="email" placeholder="Coordinator email " required>
                <input type="text" name="password" placeholder="Coordinator password " required>
                <div class="btn-group">
                    <input type="submit" name="add" value="Add Coordinator">
                    <button type="button" onclick="closeModal()">Back</button>
                </div>
            </form>
        </div>
    </div>

    <!-- edit coordinator modal -->
    <div class="modal" id="editCoordinatorModal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">×</span>
            <h3>Edit Student</h3>
            <form action="Admin_Coordinator_dashboard.php" method="POST">
                <input type="text" name="id" id="edit_id" readonly>
                <input type="text" name="coordinator_name" id="edit_Coordinator_name" placeholder="Coordinator Name" required>
                <input type="text" name="coordinator_contact" id="edit_Coordinator_contact" placeholder="Coordinator Contact" required>
                <input type="email" name="email" id="edit_email" placeholder="Coordinator Email" required>
                <input type="password" name="password" id="edit_password" placeholder="Coordinator Password">
                <div class="btn-group">
                    <input type="submit" name="update" value="Update" onclick="return confirm('Are you sure you want to update this record?');">
                    <input type="submit" name="delete" value="Delete" style="background-color: red;" onclick="return confirm('Are you sure you want to delete this record?');">
                    <button type="button" name="back" onclick="closeModal()">Back</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function openModal(type, data = null) {
            if (type === 'add') {
                document.getElementById('addCoordinatorModal').style.display = 'flex';
            } else if (type === 'edit' && data) {
                const modal = document.getElementById('editCoordinatorModal');
                document.getElementById('edit_id').value = data.id;
                document.getElementById('edit_Coordinator_name').value = data.name;
                document.getElementById('edit_Coordinator_contact').value = data.contact;
                document.getElementById('edit_email').value = data.email;
                document.getElementById('edit_password').value = data.password;
                modal.style.display = 'flex';
            }
        }

        function closeModal() {
            document.getElementById('addCoordinatorModal').style.display = 'none';
            document.getElementById('editCoordinatorModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const addModal = document.getElementById('addCoordinatorModal');
            const editModal = document.getElementById('editCoordinatorModal');
            if (event.target === addModal || event.target === editModal) {
                closeModal();
            }
        };

        // Handle edit button clicks
        $(document).ready(function() {
            $('.edit-btn').click(function(e) {
                e.preventDefault();
                const data = {
                    id: $(this).data('id'),
                    name: $(this).data('name'),
                    contact: $(this).data('contact'),
                    email: $(this).data('email'),
                    password: $(this).data('password')
                };
                openModal('edit', data);
            });
        });
    </script>
</body>

</html>