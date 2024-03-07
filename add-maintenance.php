<?php
  $title = "Add Maintenance";
  
  include_once('header.php');

  require_once('includes/dbh.inc.php');

  include 'includes/add-maintenance.inc.php';

  if (!isset($_SESSION['user'])) {
    echo "<script>window.location = 'login.php';</script>";
  }

  $msgClass = 'errordiv';
?>

<div class="container">

  <div class="form-group row justify-content-center">
    <div class="col-sm-10 col-md-8 col-lg-6">
      <p class="display-6 mt-5 mb-0">Add Maintenance</p>
      <p class="mt-0"><hr/></p>
    </div>
  </div>
    
  <form method="post" class="form" enctype="multipart/form-data">

  <div class="form-group row justify-content-md-center">
    <div class="col-sm-10 col-md-8 col-lg-7">
      <select class="form-control form-control-2" name="firearm" id="firearm" tabindex="1">
          <option>[Select Firearm] *</option>
          <!-- Fetch Firearms from DB -->
          <?php
              $sqlSelect = $db->prepare("SELECT * FROM Firearms WHERE Status = 'A';");
              $sqlSelect->execute();

              while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
                  echo "<option value='" . $row['Id'] ."'>" . $row['Model'] . "</option>";
              }
          ?>
      </select>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[0])) {
          foreach ($statusMsgs[0] as $firearmErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $firearmErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7">
      <select class="form-control form-control-2" name="maintenanceType" id="maintenanceType" tabindex="2">
          <option>[Select Type of Maintenance] *</option>
          <!-- Fetch maintenance types from DB -->
          <?php
              $sqlSelect = $db->prepare("SELECT * FROM MaintenanceTypes WHERE Status = 'A';");
              $sqlSelect->execute();

              while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
                  echo "<option value='" . $row['Id'] ."'>" . $row['MaintenanceType'] . "</option>";
              }
          ?>
      </select>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[1])) {
          foreach ($statusMsgs[1] as $maintenanceErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $maintenanceErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7">
      <input type="date" class="form-control floating_input" name="date" id="date" autocomplete="off" tabindex="3" placeholder="date" value="<?php echo !empty($postData['date']) ? $postData['date'] : ''; ?>">
      <label for="date" class="floating_label" data-content="Date *">
      <span class="hidden--visually">Date</span></label>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[2])) {
          foreach ($statusMsgs[2] as $dateErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $dateErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <textarea class="form-control form-control-2" name="details" id="tiny" cols="30" rows="8" tabindex="4" placeholder="Additional Details *" value="<?php echo !empty($postData['details']) ? $postData['details'] : ''; ?>"></textarea>
    </div>
        
    <!-- Display submission status -->
    <div class="status">
      <?php if (!empty($pdoError)) { ?>
        <div class="form-group row justify-content-center statusMsg <?php echo !empty($msgClass) ? $msgClass : ''; ?>">
          <div class="col-sm-10 col-md-8 col-lg-6">
            <?php echo $pdoError; ?>
          </div>
        </div>
      <?php } ?>
    </div>

    <!-- <div class="form-group row justify-content-center"> -->
      <div class="col-sm-10 col-md-8 col-lg-7 pt-3">
        <button type="submit" name="submit" class="btn btn-primary" tabindex="6" >Submit</button>
      </div>
    <!-- </div> -->

  </form>
</div>

<?php
  include_once('footer.php');
?>
    
