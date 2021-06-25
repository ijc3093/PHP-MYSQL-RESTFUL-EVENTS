<?php
    //var_dump($_GET);

    include('header.php');

   // var_dump($_SESSION);
    
    // $_SESSION = array(); // destroy all session data
    // session_destroy(); // compelte erase session
    include('DB_Management.php');
    $db = new DB();

  //delete data from event
    if(isset($_GET['deleteAttendingEvent'])){
        $db->Delete("attendee_event", $_GET['id'], "event");
    }

  //delete data from session
    if(isset($_GET['deleteAttendingSession'])){
        $db->Delete("attendee_session", $_GET['id'], "session");
    }

  //delete event
    if(isset($_GET['deleteEvent'])){
        $db->admin_Delete("event", $_GET['id'], "idevent");
        $db->admin_Delete("session", $_GET['id'], "event");

        // echo "<script>alert('Delete from event ');</script>";
    }


  //delete venue
    if(isset($_GET['deleteVenue']) && ($_GET['id']) == 1){
        $db->admin_Delete("venue", $_GET['id'], "idvenue");
        $db->admin_Delete("event", $_GET['id'], "venue");
    }


    //delete session
    if(isset($_GET['deleteSession'])){
        var_dump($_GET);
        $db->admin_Delete("session", $_GET['id'], "idsession");
    }

    //attending event
    if(isset($_GET['attendEvent'])){
        $db->attending_Event($_GET['id'], $_SESSION['username']);
    }

    //attending session
    if(isset($_GET['attendSession'])){
        $db->attending_Session($_GET['id'], $_SESSION['username']);
    }

    //logout button
    if(isset($_GET['logout'])){
        logout();
    }

    //destory the admin to the login local
    function logout(){
        //$_SESSION = array(); // destroy all venue data
        session_destroy(); // compelte erase venue
       // header("location: http://serenity.ist.rit.edu/~ijc3093/ISTE-341/Project1/login.php");
        header("location: http://127.0.0.1:8080/login.php");
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

        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <!-- Custom styles for this template -->
    <!-- <link href="dashboard.css" rel="stylesheet"> -->
    <title>Admin</title>
  </head>
  <body>
    <div id="root"></div>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Event</a>
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

                                    //Admin
                                    if($_SESSION['userRole'] == 2 || $_SESSION['userRole'] == 3){
                                        // echo '<li class="nav-item">
                                        // <label class="nav-link" href="admin.php">
                                        // <span data-feather="file"></span>
                                        // Admin 
                                        // </label>
                                        // </li>';
                                    }else{
                                        echo '<li class="nav-item">
                                        <a class="nav-link" href="admin.php">
                                        <span data-feather="file"></span>
                                        Admin 
                                        </a>
                                        </li>';
                                    }

                                    //Event
                                    if($_SESSION['userRole'] == 3){
                                        // echo '<li class="nav-item">
                                        // <label class="nav-link" href="events.php">
                                        // <span data-feather="shopping-cart"></span>
                                        // Events
                                        // </label>
                                        // </li>';
                                    }else{
                                        echo '<li class="nav-item">
                                        <a class="nav-link" href="events.php">
                                        <span data-feather="shopping-cart"></span>
                                        Events
                                        </a>
                                        </li>';
                                    }

                                    //Registration
                                    if($_SESSION['userRole'] == 3){
                                        // echo'<li class="nav-item">
                                        // <label class="nav-link" href="registrations.php">
                                        // <span data-feather="users"></span>
                                        // Registrations 
                                        // </label>
                                        // </li>';
                                    }
                                    else{
                                        echo'<li class="nav-item">
                                        <a class="nav-link" href="registrations.php">
                                        <span data-feather="users"></span>
                                        Registrations 
                                        </a>
                                        </li>';
                                    }

                                ?>

                        </ul>
                    </div>
            </nav>
            <!-- MAIN SIDE AREA -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="col-md-8 order-md-1">
                  <div class="container">
                    <div class="col-md-12">
                        <div class="page-header clearfix">
                        
                        
                                <br>
                                <br>
                                <div class="col-lg-12 text-lg-center">
                                    <!-- Events and Sessions Manager Information -->
                                    <h2 class="pull-left">Event Manager Role</h2>
                                        <?php
                                            //Registration
                                            if($_SESSION['userRole'] == 3){
                                                // echo'<a class="btn btn-primary pull-right class="nav-link" href="insert_event.php">
                                                // <span data-feather="users">
                                                // </span>Add New Event
                                                // </a>';
                                            }
                                            else{
                                                echo'<a class="btn btn-primary pull-right class="nav-link" href="insert_event.php">
                                                <span data-feather="users">
                                                </span>Add New Event
                                                </a>';
                                            }
                                        ?>
                                            
                                    <br>
                                    <br>
                                </div>

                                    
                                <br>
                                <table class="table table-bordered table-responsive-md table-striped text-center">
                                            <thead>
                                                <?php
                                                    if($_SESSION['userRole'] == 3){
                                                        echo'<tr>
                                                            <th class="text-center">ID</th>
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Start Date</th>
                                                            <th class="text-center">End Date</th>
                                                            <th class="text-center">Number Allowed</th>
                                                            <th class="text-center">Venue</th></tr>';
                                                    }else{
                                                            echo'<tr>
                                                            <th class="text-center">ID</th>
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Start Date</th>
                                                            <th class="text-center">End Date</th>
                                                            <th class="text-center">Number Allowed</th>
                                                            <th class="text-center">Venue</th>';
                                                            echo'<th class="text-center">Edit</th>
                                                            <th class="text-center">Delete</th></tr>';
                                                    }
                                                ?>
                                            
                                            </thead>

                                            <?php
                                            // echo 'session data: ';
                                            // var_dump($_SESSION);
                                                    if(($_SESSION['userRole'] == 2) || ($_SESSION['userRole'] == 1)){

                                                            $result = $db->get_Manager_Events($_SESSION['id']);
                                                            // var_dump($result);

                                                            foreach($result as $post){
                                                                echo'
                                                                    <tbody>';
                                                                echo'<tr>
                                                                    <td class="pt-3-half" contenteditable="true">' . $post["idevent"] . '
                                                                    </td>
                                                                    <td class="pt-3-half" contenteditable="true">' . $post["name"] . '
                                                                    </td>
                                                                    <td class="pt-3-half" contenteditable="true">' . $post["datestart"] . '</td>
                                                                    <td class="pt-3-half" contenteditable="true">' . $post["dateend"] . '</td>
                                                                    <td class="pt-3-half" contenteditable="true">' . $post["numberallowed"] . ' </td>';

                                                                echo'<td class="pt-3-half" contenteditable="true">'. ($db->get_Venue($post["venue"]))["name"] . ' </td>';
                                                                


                                                                //attendee only
                                                                if($_SESSION['userRole'] == 3){
                                                                    // echo'
                                                                    //     <td>
                                                                    //     <span class="table-remove"><label type="button" class="btn btn-success">Edit</label></span>
                                                                    //     </td>';
                                                                }
                                                                else{
                                                                    echo'
                                                                        <td>
                                                                        <span class="table-remove"><a type="button" class="btn btn-success" href="edit_event.php?id=' . $post["idevent"] . '">Edit</a></span>
                                                                        </td>';
                                                                    }


                                                                if($_SESSION['userRole'] == 3){
                                                                    // echo'
                                                                    //     <td class="pt-3-half">
                                                                    //     <span class="table-remove"><label type="button" class="btn btn-danger btn-rounded btn-sm my-0">Delete</label></span>
                                                                    //     </td>';
                                                                }
                                                                else{
                                                                    echo'<td class="pt-3-half">
                                                                        <span class="table-remove"><a type="button" class="btn btn-danger btn-rounded btn-sm my-0" href="events.php?deleteEvent=true&id= ' . $post["idevent"] . '">Delete</a></span>
                                                                        </td>';
                                                                }
                                                                    echo'</tbody>';


                                                                // Get Session By Event
                                                                //echo' <h2>Get Session By Event</h2>';
                                                                $result2 = $db->get_Session_Event($post['idevent']);

                                                                //var_dump($result2);
                                                                
                                                                if(!($result2 == null)){
                                                                    foreach($result2 as $post2){
                                                                        echo' <tbody> ';
                                                                        echo'<tr>
                                                                            <td class="pt-3-half" contenteditable="true">' . $post["idsession"] . '
                                                                            </td>

                                                                            <td class="pt-3-half" contenteditable="true">' . $post["name"] . '
                                                                            </td>

                                                                            <td class="pt-3-half" contenteditable="true">' . $post["datestart"] . '
                                                                            </td>
                                                                            <td class="pt-3-half" contenteditable="true">' . $post["dateend"] . '
                                                                            </td>
                                                                            <td class="pt-3-half" contenteditable="true">' . $post["numberallowed"] . ' </td> ';
                                                                        echo'
                                                                            <td class="pt-3-half">
                                                                            <span class="table-remove"><a type="button" class="btn btn-success" href="edit_sessions.php?id= ' . $post["idsession"] . '">Edit</a></span>
                                                                            </td>';
                    
                                                                        echo'
                                                                            <td class="pt-3-half">
                                                                            <span class="table-remove"><a type="button" class="btn btn-danger btn-rounded btn-sm my-0" href="events.php?deleteSession=true&id= ' . $post["idsession"] . '">Delete</a></span>
                                                                            </td></tr>';    

                                                                        echo' 
                                                                            </tbody>';
                                                                    }
                                                                }
                                                            }
                                                        
                                                        
                                                    }// close get_Manager_Events()  
                                            ?>
                                </table>




                                <br>
                                <br>
                                <!-- Attending on Events -->
                                <div class="col-lg-12 text-lg-center">
                                    
                                    <h4 class="pull-left">Events List</h4>
                                    <?php
                                            //Registration
                                            if($_SESSION['userRole'] == 3){
                                                // echo'<a class="btn btn-primary pull-right class="nav-link" href="insert_event.php">
                                                // <span data-feather="users">
                                                // </span>Add New Event
                                                // </a>';
                                            }
                                            else{
                                                echo'<a class="btn btn-primary pull-right class="nav-link" href="insert_event.php">
                                                <span data-feather="users">
                                                </span>Add New Event
                                                </a>';
                                            }
                                        ?>
                                    <br>
                                    <br>
                                </div>

                                    
                                <br>  
                                <table class="table table-bordered table-responsive-md table-striped text-center">
                                            <thead>
                                            <?php
                                                if($_SESSION['userRole'] == 3){
                                                    echo'<tr>
                                                        <th class="text-center">ID</th>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Start Date</th>
                                                        <th class="text-center">End Date</th>
                                                        <th class="text-center">Number Allowed</th>
                                                        <th class="text-center">Venue</th></tr>';
                                                }else{
                                                        echo'<tr>
                                                        <th class="text-center">ID</th>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Start Date</th>
                                                        <th class="text-center">End Date</th>
                                                        <th class="text-center">Number Allowed</th>
                                                        <th class="text-center">Venue</th>';
                                                        echo'<th class="text-center">Edit</th>
                                                        <th class="text-center">Delete</th></tr>';
                                                }
                                            ?>
                                            
                                            </thead>

                                            <?php
                                                    $result = $db->get_Events();

                                                    foreach($result as $post){
                                                    echo'<tbody>';
                                                    echo'<tr>
                                                        <td class="pt-3-half" contenteditable="true">' . $post["idevent"] . '
                                                        </td>
                                                        
                                                        <td class="pt-3-half" contenteditable="true">' . $post["name"] . ' </td>

                                                        <td class="pt-3-half" contenteditable="true">' . $post["datestart"] . '
                                                        </td>

                                                        <td class="pt-3-half" contenteditable="true">' . $post["dateend"] . '
                                                        </td>

                                                        <td class="pt-3-half" contenteditable="true">' . $post["numberallowed"] . ' </td> ';

                                                        echo'<td class="pt-3-half" contenteditable="true">' . ($db->get_Venue($post["venue"]))["name"] . '</td>';
                                                        
                                                        //attendee only
                                                        if($_SESSION['userRole'] == 3){
                                                                // echo'<td class="pt-3-half">
                                                                // <span class="table-remove"><label type="button" class="btn btn-success">Edit</label></span>
                                                                // </td>';
                                                        }
                                                        else{
                                                                echo'<td class="pt-3-half">
                                                                <span class="table-remove"><a type="button" class="btn btn-success" href="edit_event.php?id=' . $post["idevent"] . '">Edit</a></span>
                                                                </td>';
                                                            }


                                                        if($_SESSION['userRole'] == 3){
                                                                // echo'<td class="pt-3-half">
                                                                // <span class="table-remove"><label type="button" class="btn btn-danger btn-rounded btn-sm my-0">Delete</label></span>
                                                                // </td>';
                                                            }
                                                        else{
                                                                echo'<td class="pt-3-half">
                                                                    <span class="table-remove"><a type="button" class="btn btn-danger btn-rounded btn-sm my-0" href="events.php?deleteEvent=true&id= ' . $post["idevent"] . '">Delete</a></span>
                                                                    </td>';
                                                            }

                                                        $atteending = false;
                                                        $username = $db->get_Registration_Events($_SESSION['id']);
                                                        foreach($username as $register){
                                                            if($result['idevent'] == $post['idevent']){   
                                                            //Delete session
                                                                echo 
                                                                    '<li class="nav-item">
                                                                        <a class="nav-link active" href="events.php?deleteAttendingEvent=true&id' .$post["idevent"] . '">
                                                                            <span data-feather="home"></span>
                                                                                Stop attending on Event<span class="sr-only">(current)</span>
                                                                        </a>
                                                                    </li>';

                                                                    echo'<span class="table-remove">
                                                                    <a class="nav-link active" href="events.php?attendEvent=true&id' .$post["idevent"] . '">
                                                                        <span data-feather="home"></span>Stop attending on Event<span class="sr-only">(current)</span>
                                                                    </a>
                                                                    <button type="button" class="btn btn-danger btn-rounded btn-sm my-0">Remove</button></span>';
                                                                $atteending = true;
                                                            } 
                                                        }
                                                echo' </tbody>';
                                                }// close get_Events()  
                                            ?>
                                </table>   
                                

                                <br>
                                <br>
                                <div class="col-lg-12 text-lg-center">
                                    <!-- Attending on Events -->
                                    <h4 class="pull-left">Sessions List</h4>
                                    <?php
                                            //Registration
                                            if($_SESSION['userRole'] == 3){
                                                // echo'<a class="btn btn-primary pull-right class="nav-link" href="insert_event.php">
                                                // <span data-feather="users">
                                                // </span>Add New Event
                                                // </a>';
                                            }
                                            else{
                                                echo'<a class="btn btn-primary pull-right class="nav-link" href="insert_session.php">
                                                <span data-feather="users">
                                                </span>Add New Session
                                                </a>';
                                            }
                                        ?>
                                    <br>
                                    <br>
                                </div>
                                    
                                <table class="table table-bordered table-responsive-md table-striped text-center">
                                            <thead>
                                                <?php
                                                    if($_SESSION['userRole'] == 3){
                                                        echo'<tr>
                                                            <th class="text-center">ID</th>
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Number Allowed</th></tr>
                                                            <th class="text-center">Capacity</th></tr>
                                                            <th class="text-center">Start Date</th>
                                                            <th class="text-center">End Date</th>';
                                                    }else{
                                                            echo'<tr>
                                                            <th class="text-center">ID</th>
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Number Allowed</th>
                                                            <th class="text-center">Capacity</th>
                                                            <th class="text-center">Start Date</th>
                                                            <th class="text-center">End Date</th>';
                                                            echo'<th class="text-center">Edit</th>
                                                            <th class="text-center">Delete</th></tr>';
                                                    }
                                                ?>
                                            </thead>

                                            <?php
                                                    $result = $db->get_Sessions();

                                                    foreach($result as $post){
                                                    echo'<tbody>';
                                                    echo'<tr>
                                                        <td class="pt-3-half" contenteditable="true">' . $post["idsession"] . '
                                                        </td>
                                                        <td class="pt-3-half" contenteditable="true">' . $post["name"] . '
                                                        </td>
                                                        <td class="pt-3-half" contenteditable="true">' . $post["numberallowed"] . '</td>

                                                        <td class="pt-3-half" contenteditable="true">' . $post["event"] . '</td>

                                                        <td class="pt-3-half" contenteditable="true">' . $post["startdate"] . '</td>
                                                        <td class="pt-3-half" contenteditable="true">' . $post["enddate"] . '</td>';
                                                        
                                                        //attendee only
                                                        if($_SESSION['userRole'] == 3){
                                                            // echo'<td class="pt-3-half">
                                                            // <span class="table-remove"><a type="button" class="btn btn-success ">Edit</a></span>
                                                            // </td>';
                                                        }
                                                        else{
                                                            echo'<td class="pt-3-half">
                                                            <span class="table-remove"><a type="button" class="btn btn-success " href="edit_session.php?id=' . $post["idsession"] . '">Edit</a></span>
                                                            </td>';
                                                        }


                                                        if($_SESSION['userRole'] == 3){
                                                            // echo'<td class="pt-3-half">
                                                            // <span class="table-remove"><label type="button" class="btn btn-danger btn-rounded btn-sm my-0">Delete</label></span>
                                                            // </td>';
                                                        }
                                                        else{
                                                            echo'<td class="pt-3-half">
                                                            <span class="table-remove"><a type="button" class="btn btn-danger btn-rounded btn-sm my-0" href="events.php?deleteSession=true&id=' . $post["idsession"] . '">Delete</a></span>
                                                            </td>';
                                                        }



                                                        $atteending = false;
                                                        $username = $db->get_Registration_Sessions($_SESSION['username']);
                                                        foreach($username as $post){
                                                            if($result['idsession'] == $post['idsession']){   
                                                            //Attending session
                                                                echo 
                                                                    '<li class="nav-item">
                                                                        <a class="nav-link active" href="events.php?deleteAttendingSession=true&id' .$post["idsession"] . '">
                                                                            <span data-feather="home"></span>
                                                                                Stop attending on Session<span class="sr-only">(current)</span>
                                                                        </a>
                                                                    </li>';

                                                                    echo'<span class="table-remove">
                                                                    <a class="nav-link active" href="events.php?attendSession=true&id' .$post["idsession"] . '">
                                                                        <span data-feather="home"></span>Attending on Session<span class="sr-only">(current)</span>
                                                                    </a>
                                                                    <button type="button" class="btn btn-danger btn-rounded btn-sm my-0">Delete</button></span>';
                                                                $atteending = true;
                                                            } 
                                                        }
                                                echo' </tbody>';
                                                }// close get_Session()  
                                            ?>
                                </table>
                        
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
