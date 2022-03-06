<?php
    require_once("../functions.php");

    if (empty($_SESSION["page"]))
        header("location: ../signin/");
    
    function Page(string $page) {
        return (strcmp($_SESSION["page"],$page) === 0)? "active" : "";
    }


    $info = company_plan_details($_SESSION["uid"]);
    $info = json_decode($info,true);
    
    $avatar  = $info["data"]["dp_link"];

    if (strcmp($avatar,"N/A") == 0) {
        $avatar = "../assets/no-image.png";
    }

    $company = $info["data"]["cname"];


?>

<nav class="side-bar">

    <!-- profile -->
    <div class="profile-wrapper">
        <span class="company-avatar-wrapper">
            <span class="company-round-avatar">
                <photo id="sidebar-avatar" class="avatar-image" src="<?php echo $avatar; ?>"></photo>
            </span>
        </span>
        <span class="company-name"><?php echo $company; ?></span>
    </div>

    <!-- links wrapper -->
    <div class="links-wrapper">
        <ul class="menu-list">
            <li class="menu-item">
                <a class="menu-link <?php echo Page('dashboard');?>" href="../dashboard/">
                    <i class="menu-link-icon fa fa-chart-bar"></i>
                    <span class="menu-link-label">Dashboard</span>
                </a>
            </li><!--
            --><li class="menu-item">
                <a class="menu-link <?php echo Page('management');?>" href="../management/">
                    <i class="menu-link-icon fa fa-car"></i>
                    <span class="menu-link-label">Manage</span>
                </a>
            </li><!--
            --><li class="menu-item">
                <a class="menu-link <?php echo Page('booking');?>" href="../booking/">
                    <i class="menu-link-icon fa fa-tasks"></i>
                    <span class="menu-link-label">Booking</span>
                </a>
            </li><!--
            --><li class="menu-item">
                <a class="menu-link <?php echo Page('account');?>" href="../account/">
                    <i class="menu-link-icon fa fa-user-cog"></i>
                    <span class="menu-link-label">Account</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- logout link -->
    <a class="logout-link" href="../logout.php">
        <i class="logout-link-icon fa fa-sign-out"></i>
        <span class="logout-link-label">Signout</span>
    </a>

</nav>