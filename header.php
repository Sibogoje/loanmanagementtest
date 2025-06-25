 <!-- ======= Header ======= -->
 <header id="header" class="header fixed-top d-flex align-items-center">
 <?php $id  = $_SESSION['id']; ?>
<div class="d-flex align-items-center justify-content-between">
  <a href="home.php" class="logo d-flex align-items-center">
    <img src="logo.png" alt="">
    <span class="d-none d-lg-block">Umcenge Sacco</span>
  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->

<div class="search-bar">
  <form class="search-form d-flex align-items-center" method="POST" action="#">
    <input type="text" name="query" placeholder="Search" title="Enter search keyword">
    <button type="submit" title="Search"><i class="bi bi-search"></i></button>
  </form>
</div><!-- End Search Bar -->

<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

    <li class="nav-item d-block d-lg-none">
      <a class="nav-link nav-icon search-bar-toggle " href="#">
        <i class="bi bi-search"></i>
      </a>
    </li><!-- End Search Icon-->

    <li class="nav-item dropdown">

      <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-bell"></i>
        <span class="badge bg-primary badge-number">0</span>
      </a><!-- End Notification Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">


        <li class="notification-item">
          <i class="bi bi-exclamation-circle text-warning"></i>
          <div>
            <h4>Test Notification</h4>
            <p>Testing </p>
            <p>30 min. ago</p>
          </div>
        </li> 

        <li>
          <hr class="dropdown-divider">
        </li>
        <li class="dropdown-footer">
          <a href="#">Show all notifications</a>
        </li>

      </ul><!-- End Notification Dropdown Items -->

    </li><!-- End Notification Nav -->

    <li class="nav-item dropdown">

      <a class="nav-link nav-icon" href="messages.php" >
        <i class="bi bi-chat-left-text"></i>
        <span class="badge bg-success badge-number">0</span>
      </a><!-- End Messages Icon -->


    </li><!-- End Messages Nav -->

    <li class="nav-item dropdown pe-3">

      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <img src="assets/img/avatar.jpg" alt="Profile" class="rounded-circle">
        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['name']; ?></span>
      </a><!-- End Profile Iamge Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
            <i class="bi bi-gear"></i>
            <span>Account Settings</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
            <i class="bi bi-question-circle"></i>
            <span>Need Help?</span>
          </a>
        </li>

        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="logout.php">
            <i class="bi bi-box-arrow-right"></i>
            <span>Sign Out</span>
          </a>
        </li>

      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link " href="home.php">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#members-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>Member Area</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="members-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="more.php?mid=<?php echo $id; ?>">
          <i class="bi bi-circle"></i><span>Profile</span>
        </a>
      </li>
  

    </ul>
  </li><!-- End Components Nav -->


  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#loans-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>Loans</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="loans-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="allloans.php">
          <i class="bi bi-circle"></i><span>Loans</span>
        </a>
      </li>
      <li>
        <a href="newloans.php">
          <i class="bi bi-circle"></i><span>New Loan Applications</span>
        </a>
      </li>
      <li>
        <a href="processloans.php">
          <i class="bi bi-circle"></i><span>Under Review</span>
        </a>
      </li>

      <li>
        <a href="runningloans.php">
          <i class="bi bi-circle"></i><span>Running Loans</span>
        </a>
      </li>
      <li>
        <a href="completedloans.php">
          <i class="bi bi-circle"></i><span>Completed Loans</span>
        </a>
      </li>
      <li>
        <a href="rejectedloans.php">
          <i class="bi bi-circle"></i><span>Rejected Loan Applications</span>
        </a>
      </li>

    </ul>
  </li><!-- End Components Nav -->


  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#files-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>Files</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="files-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="statements.php">
          <i class="bi bi-circle"></i><span>Statement Files</span>
        </a>
      </li>
      <li>
        <a href="loanfiles.php">
          <i class="bi bi-circle"></i><span>Loan Files</span>
        </a>
      </li>
         <li>
        <a href="saccofiles.php">
          <i class="bi bi-circle"></i><span>Sacco Files</span>
        </a>
      </li>
      

    </ul>
  </li><!-- End Components Nav -->


</ul>

</aside><!-- End Sidebar-->
