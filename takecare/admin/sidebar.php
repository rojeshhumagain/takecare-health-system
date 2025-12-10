<aside class="bg-primary text-white vh-100 position-fixed p-3" style="width: 250px;">
    <h4 class="mb-4"><i class="fas fa-cogs"></i> Admin Panel</h4>
    <ul class="nav flex-column gap-2">
        <li class="nav-item">
            <a class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">
                <i class="fas fa-home me-2"></i>Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'manage_user.php' ? 'active' : '' ?>" href="manage_user.php">
                <i class="fas fa-users me-2"></i>Manage Users
            </a>
        </li>
         <li class="nav-item">
            <a class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'manage_notice.php' ? 'active' : '' ?>" href="manage_notice.php">
                <i class="fas fa-bullhorn me-2"></i>Manage Notices
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'manage_doctor.php' ? 'active' : '' ?>" href="manage_doctor.php">
                <i class="fas fa-user-shield me-2"></i>Manage Doctor
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'view_appointment.php' ? 'active' : '' ?>" href="view_appointment.php">
                <i class="fas fa-calendar-check me-2"></i>View Appointments
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'manage_contact.php' ? 'active' : '' ?>" href="manage_contact.php">
                <i class="fas fa-calendar-check me-2"></i>Manage Contacts
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'manage_blog.php' ? 'active' : '' ?>" href="manage_blog.php">
                <i class="fas fa-calendar-check me-2"></i>Manage Blogs
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'manage_report.php' ? 'active' : '' ?>" href="manage_report.php">
                <i class="fas fa-calendar-check me-2"></i>Manage Reports
            </a>
        </li>
    </ul>
</aside>
<style>
    .nav-link {
        border-radius: 5px;
        transition: all 0.3s ease;
    }
    .nav-link:hover {
        background-color: #5a32a3;
        color: #fff !important;
    }
    .nav-link.active {
        background-color: #5a32a3;
        font-weight: bold;
    }
    @media (max-width: 768px) {
        aside {
            width: 100%;
            height: auto;
            position: relative;
        }
        .ms-250 {
            margin-left: 0 !important;
        }
    }
</style>