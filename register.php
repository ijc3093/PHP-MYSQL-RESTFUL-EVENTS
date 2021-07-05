
<?php

    //include('validate.php');
    
    require 'DB_Management.php';
    if(isset($_SESSION['userRole'])){
    echo '<script>window.location.replace("registrations.php");</script>';
    }

    $db = new DB();

    //Create new account form
    if(isset($_GET['nextLogin'])){

        if($_POST['role'] == 'Admin'){
            $role = 1;
        }

        else if($_POST['role'] == 'Manager'){
            $role = 2;
        }
        else{
            $role = 3;
        }
        if($post = $db->insertRegister_User($_POST['name'], $_POST['password'], $role)){
            echo "<script type='text/javascript'>alert('User added already!')</script>";
           // header("location: http://serenity.ist.rit.edu/~ijc3093/ISTE-341/Project1/login.php");
            header("location: http://127.0.0.1:8080/login.php");
        }
        else{
            echo "<script type='text/javascript'>alert('Event has not added yet!')</script>";
            header("location: http://127.0.0.1:8080/login.php");
        }
    }


    // $count = count($db->getAllPeople());

    // //$id = $db->insert("Green", "Joe", 3);

    // echo "<h1>Records Found: {$count}</h1>";
    // echo $db->getAllPeopleAsTable();

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Jekyll v4.0.1">
  <title>Signin Template · Bootstrap</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/sign-in/">

  <!-- Bootstrap core CSS -->
<link href="./assets/dist/css/bootstrap.css" rel="stylesheet">

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



    html,
  body {
    height: 100%;
  }

  body {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    padding-top: 40px;
    padding-bottom: 40px;
    background-color: #f5f5f5;
  }

  .form-signin {
    width: 100%;
    max-width: 330px;
    padding: 15px;
    margin: auto;
  }
  .form-signin .checkbox {
    font-weight: 400;
  }
  .form-signin .form-control {
    position: relative;
    box-sizing: border-box;
    height: auto;
    padding: 10px;
    font-size: 16px;
  }
  .form-signin .form-control:focus {
    z-index: 2;
  }
  .form-signin input[type="email"] {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
  }
  .form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
  }

</style>
  <!-- Custom styles for this template -->
  <!-- <img class="mb-4" src="./assets/brand/bootstrap-solid.svg" alt="" width="72" height="72"> -->
  <!-- <link href="signin.css" rel="stylesheet"> -->
</head>
<body class="text-center">
        <?php 
            echo '<form id="createAccountFor" action="insert_user.php?nextLogin=true" class="form-signin" method="post">
            
            <h2 class="h3 mb-3 font-weight-normal">Register Here</h2>
            
            <label for="username" class="sr-only">Username:</label>
            <input type="username" id="username" class="form-control" name="username" placeholder="Role" required autofocus>
            
            <label for="password" class="sr-only">Password</label>
            <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>';


            echo '<div class="form-check">
            <input class="form-check-input" type="radio" name="role" id="exampleRadios1" value="Admin" checked>
            <label class="form-check-label" for="exampleRadios1">
                Admin
            </label>
            </div>

            <div class="form-check">
            <input class="form-check-input" type="radio" name="role" id="exampleRadios2" value="Manager">
            <label class="form-check-label" for="exampleRadios2">
                Manager
            </label>
            </div>

            <div class="form-check">
            <input class="form-check-input" type="radio" name="role" id="exampleRadios3" value="Attendee">
            <label class="form-check-label" for="exampleRadios3">
                Attendee
            </label>
            
            </div>';

            echo '<button class="btn btn-lg btn-primary btn-block" type="submit"value="Register">Create</button></br>
            <p class="mt-5 mb-3 text-muted">&copy; 2017-2021</p>
            </form>';
        ?>
</body>
</html>
