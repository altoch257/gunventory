<?php
    require_once('includes/dbh.inc.php');
    
    // session_start();

    $postData = $statusMsg = '';

    // if (isset($_SESSION['user'])) {
    //     header("location: home.html");
    // }


    if (isset($_REQUEST['submit'])) {
        $postData = $_POST;
        $firearm = $_REQUEST['firearm'];
        $ammo = $_REQUEST['ammo'];
        $caliber = $_REQUEST['caliber'];
        $shootingType = $_REQUEST['shootingType'];
        $notes = htmlspecialchars($_REQUEST['notes']);
        $shootingDate = filter_var($_REQUEST['shootingDate'], FILTER_SANITIZE_STRING);
        $roundsFired = filter_var($_REQUEST['roundsFired'], FILTER_SANITIZE_STRING);
        $subtract = $_REQUEST['subtract'];
        $attachment = $_FILES['attachment']['name'];


        /* ********************************************
           ************* FIELD VALIDATION *************
           ******************************************** */
        if ($firearm == "[Select Firearm] *") {
            $statusMsgs[0][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please select firearm.<br>";
        }

        if ($ammo == "[Select Ammo Used] *") {
            $statusMsgs[1][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please select ammo.<br>";
        }

        if ($caliber == "[Select Caliber] *") {
            $statusMsgs[2][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please select caliber.<br>";
        }

        if (($shootingType == "[Select Type of Shooting] *")) {
            $statusMsgs[3][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please select type of shooting.<br>";
        }

        if (empty($shootingDate)) {
            $statusMsgs[5][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please enter Purchase Date.<br>";
        }

        if (empty($roundsFired)) {
            $statusMsgs[6][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please enter number of rounds fired.<br>";
        }

        if (!isset($statusMsgs)) {
            try {             
                $timestamp = new DateTime('now', new DateTimeZone('America/New_York'));
                $timestamp = $timestamp->format('Y-m-d H:i:s');

                if (!isset($subtract)) {
                    $subtract = 0;
                }

                // if file was uploaded, add full path so it can be saved to DB
                // also add timestamp to filename to ensure uniqueness
                if (!empty($attachment)) {
                    $path_parts = pathinfo($_FILES['attachment']['name']);
                    $attachment = './img/uploads/' . $path_parts['filename'] . "_" . time() . "." . $path_parts['extension'];
                }

                
                $sqlInsert = $db->prepare("INSERT INTO ShootingActivities (Status, FirearmId, AmmoId, CaliberId, ShootingTypeId, ShootingDate, RoundsFired, Details, Subtract, sTimestamp) VALUES ('A', :fid, :aid, :cid, :stid, :sdate, :rf, :details, :sub, :dt)");

                if ($sqlInsert->execute([':fid' => $firearm, ':aid' => $ammo, ':cid' => $caliber, ':stid' => $shootingType, ':sdate' => $shootingDate, ':rf' => $roundsFired, ':details' => $notes, ':sub' => $subtract, ':dt' => $timestamp])) {
                    // Move attachment to uploads folder if there was one
                    if (!empty($attachment)) {
                        move_uploaded_file($_FILES['attachment']['tmp_name'], $attachment);
                    }

                    echo "<script>window.location = 'index.php';</script>";
                }
                else {
                    echo "Stay here!";
                }
            } 
            catch (PDOException $ex) {
                $pdoError = "Oops. An exception occurred and we were unable to save the record. Please check all the fields are populated correctly and try again.<br> $ex";
            }
        }
    }


?>
