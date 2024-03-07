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
    $manufacturer = filter_var($_REQUEST['manufacturer'], FILTER_SANITIZE_STRING);
    $model = filter_var($_REQUEST['model'], FILTER_SANITIZE_STRING);
    $purchaseDate = filter_var($_REQUEST['purchaseDate'], FILTER_SANITIZE_STRING);
    $price = filter_var($_REQUEST['price'], FILTER_SANITIZE_STRING);
    $details = htmlspecialchars($_REQUEST['details']);
    $attachment = $_FILES['attachment']['name'];


    /* ********************************************
      ************* FIELD VALIDATION *************
      ******************************************** */
    

    if (empty($model)) {
      $statusMsgs[0][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please enter model.<br>";
    }
    
    if (empty($manufacturer)) {
      $statusMsgs[1][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please enter manufacturer.<br>";
    }

    if ($firearm == "[Select Firearm] *") {
      $statusMsgs[2][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please select firearm.<br>";
    }

    if (empty($purchaseDate)) {
        $statusMsgs[3][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please enter purchase date.<br>";
    }

    if (empty($price)) {
      $statusMsgs[4][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please enter purchase price.<br>";
    }

    if (!isset($statusMsgs)) {
      try {             
        $timestamp = new DateTime('now', new DateTimeZone('America/New_York'));
        $timestamp = $timestamp->format('Y-m-d H:i:s');

        // if file was uploaded, add full path so it can be saved to DB
        // also add timestamp to filename to ensure uniqueness
        if (!empty($attachment)) {
          $path_parts = pathinfo($_FILES['attachment']['name']);
          $attachment = './img/uploads/' . $path_parts['filename'] . "_" . time() . "." . $path_parts['extension'];
        }
        
        $sqlInsert = $db->prepare("INSERT INTO Accessories (Status, Manufacturer, Model, FirearmId, PurchaseDate, Price, Details, ImgURL, sTimestamp) VALUES ('A', :man, :model, :fid, :pdate, :price, :details, :url, :dt)");

        if ($sqlInsert->execute([':man' => $manufacturer, ':model' => $model, ':fid' => $firearm, ':pdate' => $purchaseDate, ':price' => $price, ':details' => $details, ':url' => $attachment, ':dt' => $timestamp])) {
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
