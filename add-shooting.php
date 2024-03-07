<?php
  $title = "Add Shooting";
  
  include_once('header.php');

  require_once('includes/dbh.inc.php');

  include 'includes/add-shooting.inc.php';

  if (!isset($_SESSION['user'])) {
    echo "<script>window.location = 'login.php';</script>";
  }

  $msgClass = 'errordiv';
?>

<div class="container">

  <div class="form-group row justify-content-center">
    <div class="col-sm-10 col-md-8 col-lg-6">
      <p class="display-6 mt-5 mb-0">Add Shooting Activity</p>
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
      <select class="form-control form-control-2" name="ammo" id="ammo" tabindex="2">
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
        if (isset($statusMsgs[1])) {
          foreach ($statusMsgs[1] as $ammoErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $ammoErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7">
      <select class="form-control form-control-2" name="caliber" id="caliber" tabindex="3">
        <option>[Select Caliber] *</option>
        <!-- Fetch Calibers from DB -->
        <?php
          $sqlSelect = $db->prepare("SELECT * FROM Calibers WHERE Status = 'A';");
          $sqlSelect->execute();

          while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row['Id'] ."'>" . $row['Caliber'] . "</option>";
          }
        ?>
      </select>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[2])) {
          foreach ($statusMsgs[2] as $caliberErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $caliberErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7">
      <select class="form-control form-control-2" name="shootingType" id="shootingType" tabindex="4">
        <option>[Select Type of Shooting] *</option>
        <!-- Fetch Shooting Type from DB -->
        <?php
          $sqlSelect = $db->prepare("SELECT * FROM ShootingTypes WHERE Status = 'A';");
          $sqlSelect->execute();

          while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row['Id'] ."'>" . $row['ShootingType'] . "</option>";
          }
        ?>
      </select>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[3])) {
          foreach ($statusMsgs[3] as $shootingTypeErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $shootingTypeErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <textarea class="form-control form-control-2" name="notes" id="tiny" cols="30" rows="8" tabindex="5" placeholder="Notes *" value="<?php echo !empty($postData['notes']) ? $postData['notes'] : ''; ?>"></textarea>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7">
      <input type="date" class="form-control floating_input" name="shootingDate" id="shootingDate" autocomplete="off" tabindex="6" placeholder="shootingDate" value="<?php echo !empty($postData['shootingDate']) ? $postData['shootingDate'] : ''; ?>">
      <label for="shootingDate" class="floating_label" data-content="Shooting Date *">
      <span class="hidden--visually">ShootingDate</span></label>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[5])) {
          foreach ($statusMsgs[5] as $shootingDateErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $shootingDateErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7">
      <input type="text" class="form-control floating_input" name="roundsFired" id="roundsFired" autocomplete="off" tabindex="7" placeholder="Rounds Fired" value="<?php echo !empty($postData['roundsFired']) ? $postData['roundsFired'] : ''; ?>" autofocus>
      <label for="roundsFired" class="floating_label" data-content="Rounds Fired *">
      <span class="hidden--visually">roundsFired</span></label>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[6])) {
          foreach ($statusMsgs[6] as $roundsFiredErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $roundsFiredErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7">
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" name="subtract" id="subtract" tabindex="8" value="1" checked>
        <label class="custom-control-label" for="subtract">Subtract from inventory</label>
      </div>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[7])) {
          foreach ($statusMsgs[7] as $modelErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $modelErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7 pt-3">
      <input type="file" class="form-control floating_input pt-3 pb-5" name="attachment" id="attachment" tabindex="8">
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
    
