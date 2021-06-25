<?php
    
    include('header.php');

    require('DB_Management.php');
   
    $db = new DB();


    if(isset($_GET['nextLogin'])){

       //does  validation first
       $_POST['username'] = sanitize_input($_POST["username"]);
       $_POST['password'] = sanitize_input($_POST["password"]);
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
        echo "saving data";

        // var_dump($db);

        $result = $db->insertRegister_User($_POST['username'], $_POST['password'], $role);

        // var_dump($result);
        // exit(0);
        if( $result == 1 ){
          
            header("location: http://serenity.ist.rit.edu/~ijc3093/ISTE-341/Project1/login.php");
        }
        else{
          echo 'failed';
        }
    }else{
    
      echo "NO";
    }


    // does sanitization second
    function sanitize_input( $value){
      $value = trim($value);
      $value = stripslashes($value);
      $value = htmlspecialchars($value);
      return $value;
    }

    //logout button
    if(isset($_GET['logout'])){
        logout();
    }

    //destory the session to the login local (index)
    function logout(){
        //session_destory();
        header("location: http://serenity.ist.rit.edu/~ijc3093/ISTE-341/Project1/login.php");
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
    <meta
      name="description"
      content="Web site created using create-react-app"
    />
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
    <title>React App</title>
  </head>
  <body>
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <div id="root"></div>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Add Client</a>
          <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
          <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
            <a class="nav-link" href="insert_event.php?logout=true">Logout</a>
            </li>
          </ul>
        </nav>
            <div class="container-fluid">
              <div class="row">
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

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Add User</h1>
                    
                  </div>

                  <div class="col-md-8 order-md-1">
                  <div class="col-lg-8 push-lg-4 personal-info"> 
                  <?php 
                        echo '<form id="createAccountFor" action="insert_user.php?nextLogin=true" class="form-signin" method="post">
                        
                        
                        <label for="username" class="sr-only">Username:</label>
                        <div class="col-lg-9">
                        <input type="username" id="username" class="form-control" name="username" placeholder="Role" required autofocus></div><br>
                        
                        
                        
                        <label for="password" class="sr-only">Password</label>
                        <div class="col-lg-9">
                        <input type="password" id="password" class="form-control" name="password" placeholder="Password" required></div><br>';
                        

                        echo '<div class="form-check">
                        <div class="col-lg-9">
                        <input class="form-check-input" type="radio" name="role" id="exampleRadios1" value="Admin" checked></div><br>
                        <label class="form-check-label" for="exampleRadios1">
                            Admin
                        </label>
                        </div><br>

                        <div class="form-check">
                        <div class="col-lg-9">
                        <input class="form-check-input" type="radio" name="role" id="exampleRadios2" value="Manager"></div><br>
                        <label class="form-check-label" for="exampleRadios2">
                            Manager
                        </label>
                        </div><br>

                        <div class="form-check">
                        <div class="col-lg-9">
                        <input class="form-check-input" type="radio" name="role" id="exampleRadios3" value="Attendee"></div><br>
                        <label class="form-check-label" for="exampleRadios3">
                            Attendee
                        </label>
                        </div><br>';

                        echo '<div class="col-lg-9"><button class="btn btn-lg btn-primary btn-block type="submit"value="Register">Submit</button></div></br>
                          <p class="mt-5 mb-3 text-muted">&copy; 2017-2021</p>
                        </form>';

                        echo'<div class=" border-bottom">
                        
                        
                        </div>';
                    ?> 
                    </div>
                </div>
                </main>
              </div>
            </div>
  </body>
</html>

