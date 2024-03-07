<?php
  $title = "Add Malfunction";
  
  include_once('header.php');

  require_once('includes/dbh.inc.php');

  include 'includes/add-malfunction.inc.php';

  if (!isset($_SESSION['user'])) {
    echo "<script>window.location = 'login.php';</script>";
  }

  $msgClass = 'errordiv';
?>

<div class="container">

  <div class="form-group row justify-content-center">
    <div class="col-sm-10 col-md-8 col-lg-6">
      <p class="display-6 mt-5 mb-0">Add Malfunction</p>
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
      <select class="form-control form-control-2" name="malfunctionType" id="malfunctionType" tabindex="2">
          <option>[Select Malfunction Type] *</option>
          <!-- Fetch Malfunctions from DB -->
          <?php
              $sqlSelect = $db->prepare("SELECT * FROM MalfunctionTypes WHERE Status = 'A';");
              $sqlSelect->execute();

              while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
                  echo "<option value='" . $row['Id'] ."'>" . $row['MalfunctionType'] . "</option>";
              }
          ?>
      </select>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[1])) {
          foreach ($statusMsgs[1] as $malfunctionErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $malfunctionErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7">
      <select class="form-control form-control-2" name="ammo" id="ammo" tabindex="3">
          <option>[Select Ammo Used] *</option>
          <!-- Fetch Ammo from DB -->
          <?php
              $sqlSelect = $db->prepare("SELECT * FROM Ammunitions WHERE Status = 'A';");
              $sqlSelect->execute();

              while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
                  echo "<option value='" . $row['Id'] ."'>" . $row['Manufacturer'] . "</option>";
              }
          ?>
      </select>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[2])) {
          foreach ($statusMsgs[2] as $ammoErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $ammoErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7">
      <input type="date" class="form-control floating_input" name="malfunctionDate" id="malfunctionDate" autocomplete="off" tabindex="4" placeholder="Malfunction Date" value="<?php echo !empty($postData['malfunctionDate']) ? $postData['malfunctionDate'] : ''; ?>">
      <label for="malfunctionDate" class="floating_label" data-content="Malfunction Date *">
      <span class="hidden--visually">MalfunctionDate</span></label>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[3])) {
          foreach ($statusMsgs[3] as $malfunctionDateErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $malfunctionDateErrors . "</p></div>";
          }
        }
      ?>
    </div>
    
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <textarea class="form-control form-control-2 ml-1" name="details" id="tiny" cols="30" rows="8" tabindex="5" placeholder="Details" value="<?php echo !empty($postData['details']) ? $postData['details'] : ''; ?>"></textarea>
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
        <button type="submit" name="submit" class="btn btn-primary" tabindex="8" >Submit</button>
      </div>
    <!-- </div> -->

  </form>
</div>

<?php
  include_once('footer.php');
?>
    
