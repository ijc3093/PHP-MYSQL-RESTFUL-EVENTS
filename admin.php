<?php
   //var_dump($_GET);

    include('header.php');

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
    }

    //deleteUser
    if(isset($_GET['deleteUser']) && !($_GET['id'] == 1)){
        $db->admin_Delete("attendee", $_GET['id'], "idattendee");
    }

  //delete venue
    if(isset($_GET['deleteVenue']) && ($_GET['id']) == 1){
        $db->admin_Delete("venue", $_GET['id'], "idvenue");
        $db->admin_Delete("event", $_GET['id'], "venue");
    }


    //delete session
    if(isset($_GET['deleteSession'])){
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
        //header("location: http://serenity.ist.rit.edu/~ijc3093/ISTE-341/Project1/login.php");
        header("location: http://127.0.0.1:8080/login.php");
        exit();
    }


    // if($_SESSION['userRole'] == "manager" || $_SESSION['userRole'] == "attendee"){
    //     echo '<script>window.location.replace("registrations.php");</script>';
    // }


    if($_SESSION['userRole'] == 2){
        echo '<script>window.location.replace("registrations.php");</script>';
    }

    if($_SESSION['userRole'] == 3){
        echo '<script>window.location.replace("events.php");</script>';
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
   
    <title>Admin</title>
  </head>
  <body>
    <div id="root"></div>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Admin</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
              <a class="nav-link" href="admin.php?logout=true">Logout</a>
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
                  <div class="container">
                                <br>
                                <br>
                                <div class="col-lg-12 text-lg-center">
                                    <!-- Attending on Events -->
                                    <h2 class="pull-left">The Information System</h2><br><br>
                                    <a class="btn btn-primary pull-right class="nav-link" href="insert_user.php">
                                    <span data-feather="users"></span>Add New User</a>
                                <br>
                                </div>

                                    
                                <br>   
                                <!-- Attendee Table -->
                                <table class="table table-bordered table-responsive-md table-striped text-center">
                                            <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Role</th>
                                                <th class="text-center">Edit</th>
                                                <th class="text-center">Delete</th>
                                            </tr>
                                            </thead>

                                            <?php
                                                    $result = $db->get_Attendees();

                                                    foreach($result as $post){
                                                    echo'
                                                        <tbody>';

                                                    echo'
                                                            <tr>
                                                            <td class="pt-3-half" contenteditable="true">'
                                                            . $post["idattendee"] . 
                                                            '</td>

                                                            <td class="pt-3-half" contenteditable="true"> '. $post["name"] . '
                                                            </td>';
                                                        
                                                    echo'
                                                            <td class="pt-3-half">';
                                                                if($post['role'] == 1){
                                                                    echo '<input class="form-control" name="role" type="role" value="Admin" />';
                                                                }
                                                                else if($post['role'] == 2){
                                                                    echo '<input class="form-control" name="role" type="role" value="Manager" />';
                                                                }
                                    
                                                                else{
                                                                    echo '<input class="form-control" name="role" type="role" value="Attendee" />';
                                                                }
                                                    echo'
                                                            </td>';




                                                        //Admin's super
                                                        if($_SESSION['userRole'] == 1 || $_SESSION['userRole'] == 2){
                                                            echo'
                                                                <td>
                                                                    <span class="table-remove"><a type="button" class="btn btn-success" href="edit_user.php?id=' 
                                                                    .$post["idattendee"]. '">Edit</a>&nbsp;</span>
                                                                </td>';

                                                            echo'
                                                                <td>
                                                                    <span class="table-remove"><a type="button" class="btn btn-danger" href="admin.php?deleteUser=true&id=' 
                                                                    .$post["idattendee"]. 
                                                                    '">Delete</a>&nbsp;</span>
                                                                </td>';
                                                                
                                                        }else{
                                                            echo'
                                                                <td>
                                                                    <span class="table-remove"><a type="button" class="btn btn-success" href="edit_user.php?id=' 
                                                                    .$post["idattendee"]. 
                                                                    '" disabled>Edit</a>&nbsp;</span>
                                                                </td>';


                                                            echo'
                                                                <td>
                                                                    <span class="table-remove"><a type="button" class="btn btn-danger" href="admin.php?deleteUser=true&id=' 
                                                                    .$post["idattendee"]. '
                                                                    "disabled>Delete</a>&nbsp;</span>
                                                                </td>';
                                                        }
                                                        
                                                        
                                                echo' 
                                                    </tbody>';
                                                }// close get_Events()  
                                            ?>
                                </table>






                                <br>
                                <br>
                                <div class="col-lg-12 text-lg-center">
                                    <!-- Event List -->
                                    <h2 class="pull-left">Manage registration for events</h2>
                                            <!-- <a class="btn btn-primary pull-right class="nav-link" href="insert_event.php">
                                            <span data-feather="users"></span>Add New Event</a> -->
                                <br>
                                </div>   
                            
                                
                                <table class="table table-bordered table-responsive-md table-striped text-center">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Start Date</th>
                                                    <th class="text-center">End Date</th>
                                                    <th class="text-center">Attending Events</th>
                                                    <th class="text-center">Stop Attending Event</th>
                                                </tr>
                                            </thead>

                                            <?php
                                                    $result = $db->get_Attendees($_SESSION['id']);
                                                    echo' 
                                                    <tbody>';
                                                        foreach($result as $post){
                                                            
                                                            $events = $db->get_Registration_Events($post["idattendee"]);
                                                            foreach($events as $register){
                                                            echo'
                                                                <tr>
                                                                <td class="pt-3-half" contenteditable="true"> ' . $register["idevent"] .' 
                                                                </td> ' .

                                                                ' <td class="pt-3-half" contenteditable="true"> ' . $register["name"] . ' 
                                                                  </td> ' .

                                                                ' <td class="pt-3-half" contenteditable="true"> ' . $register["datestart"] . ' 
                                                                </td> '.
                                                                ' <td class="pt-3-half" contenteditable="true">' . $register["dateend"] . ' 
                                                                    </td> ';  


                                                            echo'    
                                                                <td><a class="nav-link active" href="admin.php?AttendingEvent=true&id' . $register["idevent"] . '">
                                                                attending on Event</a></td>';

                                                        echo'    
                                                            <td><a class="nav-link active" href="admin.php?deleteAttendingEvent=true&id' . $register["idevent"] . '">
                                                            Stop attending on Event</a></td>
                                                          </tr>';
                                                            } // close get_Register_Events()
                                                        }// close get_Attendees()  
                                                      echo'  
                                                            </tbody> ';
                                            ?>
                                </table>


                                
                                
                                
                                
                                
                                <br>
                                <br>
                                <div class="col-lg-12 text-lg-center">
                                    <!-- Session List -->
                                    <h2 class="pull-left">Manage registration for sessions</h2>
                                    
                                <br>
                                </div>   
                                
                                
                                <table class="table table-bordered table-responsive-md table-striped text-center">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Start Date</th>
                                                    <th class="text-center">End Date</th>
                                                    <th class="text-center">Attending Session</th>
                                                    <th class="text-center">Stop Attending Session</th>
                                                </tr>
                                            </thead>

                                            <?php
                                                    $result = $db->get_Attendees($_SESSION['id']);
                                                        // var_dump($result);
                                                        foreach($result as $post){
                                                          // var_dump($post);
                                                            echo'<tbody>';
                                                            $events = $db->get_Registration_Sessions($post["idattendee"]);
                                                            // var_dump($events);

                                                            foreach($events as $register){
                                                            echo' <tr>
                                                                  <td class="pt-3-half" contenteditable="true"> ' . $register["idsession"] . ' </td>
                                                                  
                                                                  <td class="pt-3-half" contenteditable="true"> ' . $register["name"] . '</td>

                                                                  <td class="pt-3-half" contenteditable="true"> ' . $register["startdate"] . '</td>

                                                                  <td class="pt-3-half" contenteditable="true"> ' . $register["enddate"] . ' 
                                                                  </td> '; 
                                                                  
                                                            echo'    
                                                                <td><a class="nav-link active" href="admin.php?AttendingEvent=true&id' . $register["idsession"] . '">
                                                                attending on Event</a></td>';

                                                            echo'    
                                                                <td><a class="nav-link active" href="admin.php?deleteAttendingEvent=true&id' . $register["idsession"] . '">
                                                                Stop attending on Event</a></td></tr>';
                                                            echo' </tbody> ';
                                                        } 
                                                    }// close get_Register_Events()  
                                            ?>
                                </table>


                
                                
                                <br>
                                <br>
                                <div class="col-lg-12 text-lg-center">
                                    <!-- Get Registration -->
                                    <h2 class="pull-left">Venue Location</h2>
                                        <a class="btn btn-primary pull-right class="nav-link" href="insert_venue.php">
                                        <span data-feather="users"></span>Add New Venue</a>
                                <br>
                                <br>
                            
                                </div>    
                                <!-- Attendee Table -->
                                <table class="table table-bordered table-responsive-md table-striped text-center">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Capacity</th>
                                                    <th class="text-center">Edit</th>
                                                    <th class="text-center">Delete</th>
                                                    
                                                </tr>
                                            </thead>

                                            <?php
                                                        $result = $db->get_Venues();
                                                        foreach($result as $post){
                                                            echo'<tbody>';
                                                            
                                                            echo'<tr>
                                                                <td class="pt-3-half" contenteditable="true">'. $post["idvenue"] . '</td>
                                                                <td class="pt-3-half" contenteditable="true">'. $post["name"] . '</td>
                                                                <td class="pt-3-half" contenteditable="true">'. $post["capacity"] . ' </td> ';  
                                                                // close get_Register_Events()
                                                            
                                                            echo'    
                                                                <td><a  class="btn btn-success" href="edit_venue.php?id=' . $post["idvenue"] . '">
                                                                Edit</a></td>';

                                                            echo'    
                                                                <td><a  class="btn btn-danger btn-rounded btn-sm my-0" href="admin.php?deleteVenue=true&id=' . $post["idevenue"] . '">
                                                                Delete</a></td>';
                                                            echo' </tbody> ';
                                                        }
                                            ?>
                                </table>


                                <br>
                                <br>
                                <!-- Attending on Events -->
                                <div class="col-lg-12 text-lg-center">
                                    
                                    <h2 class="pull-left">Attending on Events</h2>
                                        <a class="btn btn-primary pull-right class="nav-link" href="insert_event.php">
                                            <span data-feather="users">
                                            </span>Add New Event</a>
                                    <br>
                                    <br>
                                </div>

                                    
                                <br>  
                                <table class="table table-bordered table-responsive-md table-striped text-center">
                                            <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Start Date</th>
                                                <th class="text-center">End Date</th>
                                                <th class="text-center">Number Allowed</th>
                                                <th class="text-center">Venue</th>
                                                <th class="text-center">Edit</th>
                                                <th class="text-center">Delete</th>
                                            </tr>
                                            </thead>

                                            <?php
                                                    $result = $db->get_Events();

                                                    foreach($result as $post){
                                                    echo' <tbody>';
                                                    echo' <tr>
                                                        <td class="pt-3-half" contenteditable="true"> ' . $post["idevent"] . ' 
                                                        </td>

                                                        <td class="pt-3-half" contenteditable="true"> ' . $post["name"] . '
                                                        </td>
                                                        <td class="pt-3-half" contenteditable="true"> ' . $post["datestart"] . '
                                                        </td>
                                                        <td class="pt-3-half" contenteditable="true"> ' . $post["dateend"] . '</td>
                                                        <td class="pt-3-half" contenteditable="true"> ' . $post["numberallowed"] . ' </td> ';

                                                        echo' <td class="pt-3-half" contenteditable="true">' . ($db->get_Venue($post["venue"]))["name"] . '</td>';
                                                        
                                                        echo' <td class="pt-3-half">
                                                        <span class="table-remove"><a type="button" class="btn btn-success" href="edit_event.php?id= ' . $post["idevent"] . '">Edit</a></span>
                                                        </td>';

                                                        echo' <td class="pt-3-half">
                                                        <span class="table-remove"><a type="button" class="btn btn-danger btn-rounded btn-sm my-0" href="admin.php?deleteEvent=true&id= ' . $post["idevent"] . '">Delete</a></span>
                                                        </td>';

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
                                    <h2 class="pull-left">Attending on Sessions</h2>
                                        <a class="btn btn-primary pull-right class="nav-link" href="insert_session.php">
                                            <span data-feather="users">
                                            </span>Add New Session</a>
                                    <br>
                                    <br>
                                </div>
                                    
                                <table class="table table-bordered table-responsive-md table-striped text-center">
                                            <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Start Date</th>
                                                <th class="text-center">End Date</th>
                                                <th class="text-center">Number Allowed</th>
                                                <th class="text-center">Edit</th>
                                                <th class="text-center">Delete</th>
                                            </tr>
                                            </thead>

                                            <?php
                                                    $result = $db->get_Sessions();

                                                    foreach($result as $post){
                                                    echo' <tbody>';
                                                    echo' <tr>
                                                        <td class="pt-3-half" contenteditable="true"> ' . $post["idsession"] . ' </td>

                                                        <td class="pt-3-half" contenteditable="true"> ' . $post["name"] . ' </td>

                                                        <td class="pt-3-half" contenteditable="true"> ' . $post["startdate"] . ' </td>
                                                        <td class="pt-3-half" contenteditable="true"> ' . $post["enddate"] . ' </td>
                                                        <td class="pt-3-half" contenteditable="true"> ' . $post["numberallowed"] . ' </td>';
                                                        
                                                        echo'<td class="pt-3-half">
                                                        <span class="table-remove"><a type="button" class="btn btn-success " href="edit_session.php?id= ' . $post["idsession"] . '">Edit</a></span>
                                                        </td>';

                                                        echo'<td class="pt-3-half">
                                                        <span class="table-remove"><a type="button" class="btn btn-danger btn-rounded btn-sm my-0" href="events.php?deleteSession=true&id= ' . $post["idsession"] . '">Delete</a></span>
                                                        </td>';

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
            </main>
        </div>
    </div>
</body>
</html>
