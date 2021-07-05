<?php 
    //session_start();

    //DB
    class DB{

        private $dbh;
        
        private $host = "127.0.0.1";
        private $database_name = "events";
        private $username = "root";
        private $password = "Merciful$100";

        //Constructor
        function __construct(){

            $this->dbh = null;
            try{
                $this->dbh = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
                $this->dbh->exec("set names utf8");
            }catch(PDOException $exception){
                echo "Database could not be connected: " . $exception->getMessage();
            }
            return $this->dbh;

        }//End of function constructor
        

        //////////////////////////////////////////////Login///////////////////////////////////////////////////////////////////////
        function login($username, $password){
           // $this->dbh = $db;
            try{
                $stmt = $this->dbh->prepare("select idattendee, role from attendee where name = ? and password = ?;");
                $password = hash("sha256", $password);
                $stmt->bindParam(1, $username, PDO::PARAM_STR);
                $stmt->bindParam(2, $password, PDO::PARAM_STR);
                $stmt->execute();
                $reply = $stmt->fetch();
                if($reply == null){
                    // $stmt->close();
                    $this->dbh = null;
                    return -1;
                }
                else{
                // User's role (userRole)
                $role = $reply['role'];
                // user id add here
                $id = $reply['idattendee'];
                
                if($role == 1){
                    $_SESSION['userRole'] = 1;
                }
                else if($role == 2){
                    $_SESSION['userRole'] = 2;
                }
                else{
                    $_SESSION['userRole'] = 3;
                }

                $_SESSION['id'] = $id;
                
            }
           
            return 1;
            }catch(PDOException $e){
                echo $e->getMessage();
                return -1;
            }       
        }




        //////////////////////////////////////////////Register///////////////////////////////////////////////////////////////////////
        function insertRegister_User($name, $password, $role){
            try{
                $password = hash("sha256", $password);
                //$stmt = $this->$dbh->prepare("insert into attendee set name = ?, password = ? role = ?;");
                $query = "insert into attendee (`name`, `password`, `role`) values(?,?,?)";
                $stmt = $this->dbh->prepare($query);
                //$stmt->bind_param("ssi", $name, $password, $role);
                $stmt->bindParam(1, $name, PDO::PARAM_STR);
                $stmt->bindParam(2, $password, PDO::PARAM_STR);
                $stmt->bindParam(3, $role, PDO::PARAM_INT);
                if(!$stmt->execute()){
                    $return = -1;
                }
                else{
                    $return = 1;      
                }
                // $stmt->close();
                $this->dbh = null;
                return $return;
            }
            catch(PDOException $e){
                return $e->getMessage();
            }
        }


        //////////////////////////////////////////////Event///////////////////////////////////////////////////////////////////////
        
        function get_Manager_Events($id){
            try{
                $data = array();

                $query = "select event from manager_event where manager =" . $id. ";";
                $stmt = $this->dbh->prepare($query);
                $stmt->execute();
                if( $stmt != false ){
                    while(($row = $stmt->fetch())){
                        $query2 = "select idevent, name, datestart, dateend, numberallowed, venue from event WHERE idevent = " . $row['event'] . ";";
                        $stmt2 = $this->dbh->prepare($query2);
                        $stmt2->execute();
                        while($row2 = $stmt2->fetch()){
                            $data[] = $row2;
                        }
                    }
                }
                // $dbh->close();
                return $data;
            }catch(PDOException $pe){
                // echo $pe->getMessage();
                return ['failed', 'reason'=> $pe->getMessage()];
            }
            
        }


        //Get all events=
        function get_Events($eventID = null){
            try{
                $data = array();
                $query = "select * from event";
                if( $eventID != null ) {$query .= " WHERE idevent = " .$eventID;}
                $stmt = $this->dbh->prepare($query);
                $stmt->execute();
                while($row = $stmt->fetch()){
                    $data[] = $row;
                }
                //dbh->close();
                return $data;
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
           }
        }


        //Events send exactly information to session as array
        function get_Session_Event($id){
            try{
                $data = array();
                $query = "select * from session where event = ". $id . ";";
                $stmt = $this->dbh->prepare($query);
                $stmt->execute();
                while($row = $stmt->fetch()){
                    $data[] = $row;
                }
                //dbh->close();
                return $data;
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return['failed'];
           }
        }


        //Get specific event with id and detail about event
        function get_Event($id){
            //try and catch Avoid crash
            try{
                $data = array();
                $query = "select * from event where idevent = ? ;";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                while($row = $stmt->fetch()){
                    $data[] = $row;
                }
                return $data;
            }
            catch(PDOException $pe){
                echo $pe->getMessage();
                return['failed'];
            }
        }

        // Information of Events
        function getInfo_Event(){
           try{
                $data = array();
                $stmt = $this->dbh->prepare("select event from manager_event where manager = '". $_SESSION["username"] . "';");
                while($row = $stmt->fetch()){
                    $stmt2 = $this->dbh->prepare("select * from event where idevent = " .$row . ";");
                    while($row2 = $stmt->fetch()){
                        $data[] = $row2;
                    }
                }
                // dbh->close();
                return $data;
           }catch(PDOException $pe){
            echo $pe->getMessage();
            return[];
            }
        }


        //user store data in database server (insert into event and manager_event)
        function insert_Event($name, $dateStart, $dateEnd, $numberAllowed, $venue, $manager){
            try{
                $stmt = $this->dbh->prepare("insert into event (name, datestart, dateend, numberallowed, venue) VALUES(?, ?, ?, ?, ?);");
                $stmt->bindParam(1, $name, PDO::PARAM_STR);
                $stmt->bindParam(2, $dateStart, PDO::PARAM_STR);
                $stmt->bindParam(3, $dateEnd, PDO::PARAM_STR);
                $stmt->bindParam(4, $numberAllowed, PDO::PARAM_INT);
                $stmt->bindParam(5, $venue, PDO::PARAM_INT);
                if(!$stmt->execute()){
                    $return = -1;
                }
                else{
                    $event_ID = $_SESSION['userRole'];
                    $stmt = $this->dbh->prepare("insert into manager_event (event, manager) VALUES(?, ?);");
                    // TODO finish this bindParam()
                    $stmt->bindParam(1, $event_ID, PDO::PARAM_INT);
                    $stmt->bindParam(2, $manager, PDO::PARAM_INT);
                    if(!$stmt->execute()){
                        $return = -1;
                    }
                    else{
                        $return = 1;
                    }      
                }
                // $stmt->close();
                // dbh->close();
                return $return;
                }catch(PDOException $pe){
                    echo $pe->getMessage();
                    return[];
                }
        }


        //Update Event
        function update_event($name, $dateStart, $dateEnd, $numberAllowed, $venue, $id){
            try{
                $data = array();
                $stmt = $this->dbh->prepare("update event set name = ?, datestart = ?, dateend = ?, numberallowed = ?, venue = ? where idevent = ?;");
                
                $stmt->bindParam(1, $name, PDO::PARAM_STR);
                $stmt->bindParam(2, $dateStart, PDO::PARAM_STR);
                $stmt->bindParam(3, $dateEnd, PDO::PARAM_STR);
                $stmt->bindParam(4, $numberAllowed, PDO::PARAM_INT);
                $stmt->bindParam(5, $venue, PDO::PARAM_INT);
                $stmt->bindParam(6, $id, PDO::PARAM_INT);
                // TODO finish this bindParam()
                return $stmt->execute();
                // $stmt->close();
                // dbh->close();
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return false;
            }
        }
    

        ////////////////////////////////////////////////Admin///////////////////////////////////////////////////////////////////////
        
        //Update venue
        function update_Admin_User($name, $role, $id){
            try{
                $query = "update attendee set name = ?, role = ? where idattendee = ?;";
                $stmt = $this->dbh->prepare($query);
                // TODO finish this bindParam()
                // $stmt->bind_param("sii", $name, $role, $id);
                $stmt->bindParam(1, $name, PDO::PARAM_STR);
                $stmt->bindParam(2, $role, PDO::PARAM_INT);
                $stmt->bindParam(3, $id, PDO::PARAM_INT);
                return $stmt->execute();
                // $stmt->close();
                // dbh->close();
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return ['failed','reason'=>$pe->getMessage()];
            }
        }


        //Admin delete from exactly table
        function Delete($table, $id, $idName){
            try{
                $query = "delete from " . $table . " where " . $idName . " = ? and attendee = ?;";
                $stmt = $this->dbh->prepare($query);
                // TODO finish this bindParam()
                $stmt->bindParam("is", $id, $_SESSION["username"]);
                if($stmt->execute()){
                    //  $stmt->close();
                    //  $dbh->close();
                    return 1;
                }
                else{
                    // $stmt->close();
                    // dbh->close();
                    return -1;
                }
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
            }
        }


        //Admin delete from exactly table
        function admin_Delete($table,$id, $name){
            try{
                $query = "delete from " . $table . " where " . $name . ' = ' . $id;
                // var_dump($query);
                $stmt = $this->dbh->prepare($query);
            
                // $stmt->bindParam("i", $id);
                if($stmt->execute()){
                    // $stmt->close();
                    // dbh->close();
                    $return = 1;
                }
                else{
                    // $stmt->close();
                    // dbh->close();
                    $return = -1;
                }
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
            }
        }

        ////////////////////////////////////////////////Sessions///////////////////////////////////////////////////////////////////////
        //User Table information show
        function admin_User($name, $role, $id){
            try{
                $query = "update attendee set name = ?, role = ? where idattendee = ?;";
                $stmt = $this->dbh->prepare($query);
                // TODO finish this bindParam()
                // $stmt->bind_param("sii", $name, $role, $id);
                $stmt->bindParam(1, $name, PDO::PARAM_STR);
                $stmt->bindParam(2, $role, PDO::PARAM_INT);
                $stmt->bindParam(3, $id, PDO::PARAM_INT);
                $stmt->execute();
                // $stmt->close();
                // dbh->close();
                $return = $stmt->fetch();
                return $return;
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
            }
        }

        
        //Get all session
        function get_Sessions($sessionID = null){
            try{
                $data = array();
                $query = "select * from session";
                if( $eventID != null ) {$query .= " WHERE idsession = " .$sessionID;}
                $stmt = $this->dbh->prepare($query);
                $stmt->execute();
                while($row = $stmt->fetch()){
                    $data[] = $row;
                }
                //dbh->close();
                return $data;
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
            }
        }


        //Get specific event with id and detail about event
        function get_Session($id){
            //try and catch Avoid crash
            try{
                $data = array();
                $stmt = $this->dbh->prepare("select * from session where idsession = ?;");
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch();
            }
            catch(PDOException $pe){
                 echo $pe->getMessage();
                 return[];
            }
        }
    


        function insert_Session($name, $numberAllowed, $event, $data_Start, $dateEnd){
            //insert into session VALUES(1,'Lion', 10, 1, '20200505','20200505');
            try{
                $stmt = $this->dbh->prepare("insert into session (name, numberallowed, event, startdate, enddate) VALUES(?, ?, ?, ?, ?);");
                $stmt->bindParam(1, $name, PDO::PARAM_STR);
                $stmt->bindParam(2, $numberAllowed, PDO::PARAM_INT);
                $stmt->bindParam(3, $event, PDO::PARAM_STR);
                $stmt->bindParam(4, $data_Start, PDO::PARAM_STR);
                $stmt->bindParam(5, $dateEnd, PDO::PARAM_STR);
                if(!$stmt->execute()){
                    $return = -1;
                }
                else{
                    $return = 1; 
                }
                // $stmt->close();
                // dbh->close();
                return $return;
            }catch(PDOException $pe){
                    echo $pe->getMessage();
                    return[];
                }
        }
        


        

        //Update Session
        function update_session($name, $startdate, $enddate, $numberAllowed, $id){
            try{
                $data = array();
                $stmt = $this->dbh->prepare("update session set name = ?, startdate = ?, enddate = ?, numberallowed = ? where idsession = ?;");
                
                $stmt->bindParam(1, $name, PDO::PARAM_STR);
                $stmt->bindParam(2, $startdate, PDO::PARAM_STR);
                $stmt->bindParam(3, $enddate, PDO::PARAM_STR);
                $stmt->bindParam(4, $numberAllowed, PDO::PARAM_INT);
                $stmt->bindParam(5, $id, PDO::PARAM_INT);
                // TODO finish this bindParam()
                $stmt->execute();
                // $stmt->close();
                // dbh->close();
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
            }
        }



        //Update venue
        function update_Venue($name, $event, $id){
            try{
                $query = "update venue set name = ?, capacity = ? where idvenue = ?;";
                $stmt = $this->dbh->prepare($query);
                //$stmt->bindParam("sii", $name, $event, $id);
                $stmt->bindParam(1, $name, PDO::PARAM_STR);
                $stmt->bindParam(2, $event, PDO::PARAM_INT);
                $stmt->bindParam(3, $id, PDO::PARAM_INT);
                return  $stmt->execute();
                //$stmt->close();
                //dbh->close();
            }catch(PDOException $pe){
                return ['failed', 'reason'=>$pe->getMessage()];
           }
        }


        //Get Venues output
        function get_Venues(){
            try{
                $data = array();
                $query = "select * from venue";
                $stmt = $this->dbh->prepare($query);
                $stmt->execute();
                while($row = $stmt->fetch()){
                    $data[] = $row;
                }
                //dbh->close();
                return $data;
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
           }
        }

        //Get exact venue's information in array
        function get_Venue($id){
            try{
                $data = array();
                $query = "select * from venue where idvenue = ?;";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch();
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
           }
        }


        function insert_Venue($name, $capacity){
            try{
                $query = "insert into venue (name, capacity) values(?,?)";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $name, PDO::PARAM_STR);
                $stmt->bindParam(2, $capacity, PDO::PARAM_INT);
                if(!$stmt->execute()){
                    $return = -1;
                }
                else{
                    $return = 1;      
                }
                //$stmt->close();
                //dbh->close();
                return $return;
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
           }
        }



        //Attend Event
        function attending_Event($event, $attendee){
            try{
                //$stmt = $this->$dbh->prepare("insert into attendee set name = ?, password = ? role = ?;");
                $query = "insert into attendee_session (event, attendee) values(?,?)";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam("si", $event, $attendee);
                if(!$stmt->execute()){
                    $return = -1;
                }
                else{
                    $return = 1;      
                }
                //$stmt->close();
                //dbh->close();
                return $return;
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
           }
        }



        //Attend Event
        function attending_Session($session, $attendee){
            try{
                //$stmt = $this->$dbh->prepare("insert into attendee set name = ?, password = ? role = ?;");
                $query = "insert into attendee_session (session, attendee) values(?,?)";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam("si", $session, $attendee);
                if(!$stmt->execute()){
                    $return = -1;
                }
                else{
                    $return = 1;      
                }
                //$stmt->close();
                //dbh->close();
                return $return;
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
           }
        }

        //Output of all Attendees as array
        function get_Attendees($userRoleID = null){
            try{
                $data = array();
                $query = "select * from attendee";
                if($userRoleID != null) { 
                    $query .= " WHERE idattendee = ?";
                    $stmt = $this->dbh->prepare($query);
                    $stmt->bindParam(1, $userRoleID, PDO::PARAM_INT);
                }
                else{
                    $stmt = $this->dbh->prepare($query);
                }
                $stmt->execute();
                while($row = $stmt->fetch()){
                    $data[] = $row;
                }
                //dbh->close();
                return $data;
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return ['failed','reason'=>$pe->getMessage()];
           }
        }


        //Get exact user's information in array
        function get_Attendee($id){
            try{
                $data = array();
                $query = "select * from attendee where idattendee = ?;";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                while($row = $stmt->fetch()){
                    $data[] = $row;
                }
                return $data;
            }catch(PDOException $pe){
                echo $pe->getMessage();
                return[];
           }
        }



        //This is still issue with Registration
        ////////////////////////////////////////////////Registration///////////////////////////////////////////////////////////////////////

        //Get Registration Events
        /**
         * $register array
         */
        function get_Registration_Events($register){
            $query = '';
            try{
                $data = array();
                // if ( $register == null ) {
                //     echo "<script>console.log('Register event from session empty');</script>";
                //     return $data;
                // }
                //$query = "SELECT event FROM attendee_event WHERE attendee = " . $register . ";";
                // $query = "select event from attendee_event where attendee = ?;";
                $query = "select event from attendee_event where attendee = ". $register . ";";
                $stmt = $this->dbh->prepare($query);
                // $stmt->bindParam(1, $register, PDO::PARAM_INT);
                $stmt->execute(); 
                while($rows = $stmt->fetch()){
                    $query2 = "select e.*, v.name from event as e left join venue as v on v.idvenue = e.venue where e.idevent = " . $rows["event"] . ";";
                    $stmt2 = $this->dbh->prepare($query2);
                    $stmt2->execute();
                    while($rows2 = $stmt2->fetch()){
                        $data[] = $rows2;
                    }
                    // $data[] = $rows;
                }
                // dbh->closed();
                return $data;
            }catch(PDOException $e){
                echo  $query . $e->getMessage();
                return ['failed','reason'=>$e->getMessage()];
            }
        }

        //Get Sessions Events
        function get_Registration_Sessions($register){
            $query = '';
            try{
                $data = array();
                // if ( $register == null ) {
                //     echo "<script>console.log('Register event from session empty');</script>";
                //     return $data;
                // }
                $query = "select session from attendee_session WHERE attendee = ?";

                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $register, PDO::PARAM_INT);
                $stmt->execute(); 
                while($rows = $stmt->fetch()){
                    // $query2 = "select e.*, v.name from session as e left join event as v on v.idevent = e.event where e.idsession = " . $rows["session"];
                    $query2 = "select e.* from session as e left join event as v on v.idevent = e.event where e.idsession = " . $rows["session"];
                    $stmt2 = $this->dbh->prepare($query2);
                    $stmt2->execute();
                    while($rows2 = $stmt2->fetch()){
                        $data[] = $rows2;
                    }
                }
                // dbh->closed();
                return $data;
            }catch(PDOException $e){
                echo  $query . $e->getMessage();
                return [];
            }
        }  

    }
?>



