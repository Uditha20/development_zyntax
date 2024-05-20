<?php

require_once '../headers/header.php'
?>

<div class="grid-container">
    <!-- Header -->
    <header class="header">
        <div class="menu-icon" onclick="openSidebar()">
            <i class="bi bi-list"></i>
        </div>
    </header>
    <!-- sidebar -->
    <aside id="sidebar">
        <div class="sidebar-title">
            <div class="sidebar-brand">
                <img src="../../img/logo.png" alt="" class="img-fluid">
            </div>
            <span onclick="closeSidebar()"><i class="bi bi-x-lg"></i></span>
        </div>
        <ul class="sidebar-list">
            <li class="sidebar-list-item">
                <a href="#">
                    <i class="bi bi-speedometer"></i> <u>Dashboard</u>
                </a>
            </li>
            <li class="sidebar-list-item">
                <a href="#" class="dropdown-toggle">
                    <i class="bi bi-people"></i> Candidates
                </a>
                <ul class="list-unstyled mx-4 collapse" id="candidateSubmenu">
                    <li class="mt-2">
                        <a href="../pages/registrtion.php">View</a>
                    </li>
                    <li class="mt-2">
                        <a href="../pages/candidate/registrtion.php">Create</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-list-item">
                <a href="#" class="dropdown-toggle">
                <i class="bi bi-collection"></i> Category
                </a>
                <ul class="list-unstyled mx-4 collapse" id="CategorySubmenu">
                    <li class="mt-2">
                        <a href="../pages/registrtion.php">View</a>
                    </li>
                    <li class="mt-2">
                        <a href="../pages/category/category.php">Create</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-list-item">
                <a href="#" class="dropdown-toggle">
                <i class="bi bi-card-heading"></i> Job Title
                </a>
                <ul class="list-unstyled mx-4 collapse" id="jobTitleSubmenu">
                    <li class="mt-2">
                        <a href="../pages/registrtion.php">View</a>
                    </li>
                    <li class="mt-2">
                        <a href="../pages/job_title/jobTitle.php">Create</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-list-item">
                <a href="#" class="dropdown-toggle">
                    <i class="bi bi-buildings"></i> Company
                </a>
                <ul class="collapse list-unstyled mx-4" id="CompanySubmenu">
                    <li class="mt-2">
                        <a href="#">View</a>
                    </li>
                    <li class="mt-2">
                        <a href="../pages/company/createForm.php">Create</a>
                    </li>
                </ul>

            </li>
            <li class="sidebar-list-item">
                <a  href="#" class="dropdown-toggle">
                    <i class="bi bi-list-ol"></i> Job Orders
                </a>
                <ul class="collapse list-unstyled mx-4" id="JobOrders">
                    <li class="mt-2">
                        <a href="#">View</a>
                    </li>
                    <li class="mt-2">
                        <a href="../pages/jobOrder/createJob.php">Create</a>
                    </li>
                    <li class="mt-2">
                        <a href="#">Assign job</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-list-item">
                <a href="#" data-bs-toggle="collapse" data-bs-target="#Status" aria-expanded="false" class="dropdown-toggle">
                    <i class="bi bi-app-indicator"></i> Status
                </a>
                <ul class="collapse list-unstyled mx-4" id="Status">
                    <li class="mt-2">
                        <a href="#">Assign State</a>
                    </li>
                    <li class="mt-2">
                        <a href="#">Interview</a>
                    </li>
                    <li class="mt-2">
                        <a href="#">Select State</a>
                    </li>
                    <li class="mt-2">
                        <a href="#">Visa Received</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-list-item">
                <a href="#" target="_blank">
                    <i class="bi bi-credit-card-2-back"></i> Payments
                </a>
            </li>
            <li class="sidebar-list-item">
                <a href="#" target="_blank">
                    <i class="bi bi-book"></i> Reports
                </a>
            </li>

        </ul>
    </aside>
    <!-- main section -->
    <main class="main-container">

    </main>
</div>
<?php
require_once '../headers/footer.php'
?>
<script>
$(document).ready(function() {
    // Initially hide the submenu
    $('#candidateSubmenu').hide();
    $('#CompanySubmenu').hide();
    $('#JobOrders').hide();
    $('#CategorySubmenu').hide();
    $('#jobTitleSubmenu').hide();

    
    
    // Toggle the submenu on click
    $('.dropdown-toggle').click(function(e) {
        e.preventDefault();  
        var submenu = $(this).next('ul');  
        submenu.slideToggle();  
    });
});
</script>
<script>
    $(document).ready(function() {
     
        // $('.main-container').load('card.php');       
        $('.list-unstyled a').click(function(e) {
            e.preventDefault(); 
            var page = $(this).attr('href');
            $('.main-container').load(page); 
        });
    });
</script>

<script src="../js/scripts.js"></script>