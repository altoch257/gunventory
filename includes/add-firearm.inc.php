<?php
  require_once('includes/dbh.inc.php');

  // session_start();

  $postData = $statusMsg = '';

  // if (isset($_SESSION['user'])) {
  //     header("location: home.html");
  // }


  if (isset($_REQUEST['submit'])) {
    $postData = $_POST;
    $manufacturer = filter_var($_REQUEST['manufacturer'], FILTER_SANITIZE_STRING);
    $model = filter_var($_REQUEST['model'], FILTER_SANITIZE_STRING);
    $gunType = $_REQUEST['gunType'];
    $caliber = $_REQUEST['caliber'];
    $serial = filter_var($_REQUEST['serial'], FILTER_SANITIZE_STRING);
    $purchaseDate = filter_var($_REQUEST['purchaseDate'], FILTER_SANITIZE_STRING);
    $price = filter_var($_REQUEST['price'], FILTER_SANITIZE_STRING);
    $notes = htmlspecialchars($_REQUEST['notes']);
    $image = $_FILES['image']['name'];
    $document = $_FILES['document']['name'];

    /* ********************************************
             ************* FIELD VALIDATION *************
             ******************************************** */
    if (empty($manufacturer)) {
      $statusMsgs[0][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please enter firearm manufacturer.<br>";
    }

    if (empty($model)) {
      $statusMsgs[1][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please enter firearm model.<br>";
    }

    if ($gunType == "[Select Gun Type] *") {
      $statusMsgs[2][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please select gun type.<br>";
    }

    if ($caliber == "[Select Caliber] *") {
      $statusMsgs[3][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please enter caliber.<br>";
    }

    if (empty($serial)) {
      $statusMsgs[4][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please enter serial number.<br>";
    }

    if (empty($purchaseDate)) {
      $statusMsgs[5][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please select Purchase Date.<br>";
    }

    if (empty($price)) {
      $statusMsgs[6][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please enter purchase price in decimal, e.g. 624.95<br>";
    }

    if (!isset($statusMsgs)) {
      try {
        $timestamp = new DateTime('now', new DateTimeZone('America/New_York'));
        $timestamp = $timestamp->format('Y-m-d H:i:s');

        // if image was uploaded, add full path so it can be saved to DB
        // also add timestamp to filename to ensure uniqueness
        if (!empty($image)) {
          $path_parts = pathinfo($_FILES['image']['name']);
          $image = './img/uploads/' . $path_parts['filename'] . "_" . time() . "." . $path_parts['extension'];
        }

        // if document was uploaded, add full path so it can be saved to DB
        // also add timestamp to filename to ensure uniqueness
        if (!empty($document)) {
          $path_parts = pathinfo($_FILES['document']['name']);
          $document = './img/uploads/' . $path_parts['filename'] . "_" . time() . "." . $path_parts['extension'];
        }

        $sqlInsert = $db->prepare("INSERT INTO Firearms (Manufacturer, Status, Model, GunTypeId, CaliberId, Serial, PurchaseDate, Price, ImgURL, DocURL, Notes, sTimestamp) VALUES (:man, 'A', :model, :gtid, :cid, :serial, :pdate, :price, :imgURL, :docURL, :notes, :dt)");

        if ($sqlInsert->execute([':man' => $manufacturer, ':model' => $model, ':gtid' => $gunType, ':cid' => $caliber, ':serial' => $serial, ':pdate' => $purchaseDate, ':price' => $price, ':imgURL' => $image, ':docURL' => $document, ':notes' => $notes, ':dt' => $timestamp])) {
          // Move image to uploads folder if format is valid
          if (!empty($image)) {
            if ($path_parts['extension'] === 'jpeg' || 'jpg' || 'png') {
              move_uploaded_file($_FILES['image']['tmp_name'], $image);
            } 
            else {
              throw 'Only the following format(s) are allowed: .pdf, .png, .jpeg, and .jpg.';
            }
          }

          // Move document to uploads folder if format is valid
          if (!empty($document)) {
            if ($path_parts['extension'] === 'pdf') {
              move_uploaded_file($_FILES['document']['tmp_name'], $document);
            } 
            else {
              throw 'Only the following format(s) are allowed: .pdf.';
            }
          }

          echo "<script>window.location = 'index.php';</script>";
        }
        else {
          echo "Stay here!";
        }
      } catch (PDOException $ex) {
        $pdoError = "Oops. An exception occurred and we were unable to save the record. Please check all the fields are populated correctly and try again.<br> $ex";
      }
    }
  }
?>