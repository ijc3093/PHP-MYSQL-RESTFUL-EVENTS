<?php
    //var_dump($_GET);
    
    include('header.php');
    

    include('DB_Management.php');
    $db = new DB();

    // $_SESSION = array(); // destroy all session data
    // session_destroy(); // compelte erase session


    // if($_SESSION['userRole'] == "attendee" || !isset($_GET['id'])){
    //     echo '<script>window.location.replace("registrations.php");</script>';
    // }

    
    if($_SESSION['userRole'] == 2 || $_SESSION['userRole'] == 1){
        $result = $db->get_Manager_Events(1);
        $allowed = false;
        foreach($result as $post){
            if($post['idevent'] == $_GET['id']){
                $allowed = true;
            }
        }
        // if($allowed == false){
        //     echo '<script>window.location.replace("events.php");</script>';
        // }
    }

    //edit events
    if(isset($_GET['updated'])){

        //does  validation first
        $_POST['name'] = sanitize_input($_POST["name"]);
        $_POST['role'] = sanitize_input($_POST["role"]);
        $_POST['id'] = sanitize_input($_POST["id"]);


        if($_POST['role'] == 'Admin'){
            $role = 1;
        }
        else if($_POST['role'] == 'Manager'){
            $role = 2;
        }
        else{
            $role = 3;
        }

        $hold = $db->update_Admin_User($_POST['name'], $role,  $_POST['id']);

        if($hold == true){
            echo "<script>alert('User updated');</script>";
        }else{
            echo "<script>alert('user fail to update. " . $hold ." ');</script>";
        }
        //var_dump($_POST);
    }

    // does sanitization second
    function sanitize_input( $value){
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        return $value;
    }
    

    //delete event
    if(isset($_GET['deleteEvent'])){
        $db->admin_Delete("event", $_GET['id'], "idevent");
        $db->admin_Delete("session", $_GET['id'], "event");
        echo '<script>window.location.replace("events.php");</script>';
    }

  
    //logout button
    if(isset($_GET['logout'])){
        logout();
    }

    //destory the admin to the login local
    function logout(){
        //$_SESSION = array(); // destroy all venue data
        session_destroy(); // compelte erase venue
        header("location: http://serenity.ist.rit.edu/~ijc3093/ISTE-341/Project1/login.php");
        exit();
    }

    //logout button
    if(isset($_GET['back'])){
        back();
    }


    function back(){
        //$_SESSION = array(); // destroy all venue data
        session_destroy(); // compelte erase venue
        header("location: http://serenity.ist.rit.edu/~ijc3093/ISTE-341/Project1/event.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" href="%PUBLIC_URL%/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <meta name="description" content="Web site created using create-react-app"/>
    <link rel="apple-touch-icon" href="%PUBLIC_URL%/logo192.png" />
    <!--
      manifest.json provides metadata used when your web app is installed on a
      user's mobile device or desktop. See https://developers.google.com/web/fundamentals/web-app-manifest/
    -->
    <link rel="manifest" href="%PUBLIC_URL%/manifest.json" />      
    <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <!-- <link href="dashboard.css" rel="stylesheet"> -->
    <title>Admin</title>
  </head>
  <body>
    <div id="root"></div>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Edit Event</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
              <a class="nav-link" href="events.php?logout=true">Logout</a>
            </li>
        </ul>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <!-- NAV SIDE AREA -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="sidebar-sticky pt-3">
                        <ul class="nav flex-column">
                        
                            <?php 
                            
                                // if($_SESSION['userRole'] == 1){
                                //     echo '<li class="nav-item">
                                //     <a class="nav-link" href="admin.php">
                                //       <span data-feather="file"></span>
                                //       Admin 
                                //     </a>
                                //   </li>';
                                // }

                                echo '<li class="nav-item">
                                    <a class="nav-link" href="admin.php">
                                    <span data-feather="file"></span>
                                    Admin 
                                    </a>
                                </li>';
                            
                            ?>
                        <li class="nav-item">
                            <a class="nav-link" href="events.php">
                            <span data-feather="shopping-cart"></span>
                            Events
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="registrations.php">
                            <span data-feather="users"></span>
                            Registrations 
                            </a>
                        </li>
                        
                        </ul>
                    </div>
            </nav>
            <!-- MAIN SIDE AREA -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="col-md-8 order-md-1">
                  
                        <br>
                        <br>
                        <div>
                            <h2>Edit Events</h2>
                            <br>
                            
                        </div>

                            
                        <div class="col-lg-8 push-lg-4 personal-info"> 
                                <?php
                                        //Print all events tied to the manager or admin
                                        //var_dump($username);

                                        $post = $db->get_Attendee($_GET['id'])[0]; 
                                        //var_dump($post);
                                          //var_dump($post);


                                        echo'<form action="edit_user.php?updated=true&id=' . $post["idattendee"] . '" method="post" role="form">';
                                            echo'<div class="form-group row">';
                                                    echo'
                                                    <label class="col-lg-3 col-form-label form-control-label">ID</label>
                                                    <div class="col-lg-9">
                                                    <input type="text" class="form-control" name="id"  value="' . $_GET["id"] . '" required><br>
                                                    </div>';

                                                    echo'
                                                    <label class="col-lg-3 col-form-label form-control-label">Name</label>
                                                    <div class="col-lg-9">
                                                    <input type="text" class="form-control" name="name" value="' . $post["name"] . '" required><br>
                                                    </div>';
                                
                                                    echo '<div class="col-lg-9">
                                                    <label class="col-lg-3 col-form-label form-control-label">Role</label>';
                                                       
                                                    
                                                    echo'
                                                    <input class="form-check-input" type="radio" name="role" id="exampleRadios1" value="Admin" checked>';
                                                    if($post["role"] == 1){
                                                        echo 'checked';
                                                    }
                                                    echo'<label class="form-check-label" for="exampleRadios1">
                                                        Admin
                                                    </label>
                                                    </div>';

                                                    echo'<div class="col-lg-9">
                                                    <input class="form-check-input" type="radio" name="role" id="exampleRadios2" value="Manager">';
                                                    if($post["role"] == 2){
                                                        echo 'checked';
                                                    }
                                                    echo'<label class="form-check-label" for="exampleRadios2">
                                                        Manager
                                                    </label>
                                                    </div>';

                                                    echo'<div class="col-lg-9">
                                                    <input class="form-check-input" type="radio" name="role" id="exampleRadios3" value="Attendee">';
                                                    if($post["role"] == 3){
                                                        echo 'checked';
                                                    }
                                                    echo'<label class="form-check-label" for="exampleRadios3">
                                                        Attendee
                                                    </label>';

                                                    
                                                    echo '<br><br><a href="admin.php?back=true" class="btn btn-secondary" class="form-control" value="Cancel" required>Back</a>
                                                    <input class="btn btn-success" type="submit" name="updated" class="form-control" value="Save Changes" required>&nbsp;';
                                                    echo'</div>';

                                            echo'</div';
                                                           
                                        echo'<hr></form>';
                                ?>
                                
                        </div>
                    
                </div>
            </main>
        </div>
    </div>
</body>
</html>
