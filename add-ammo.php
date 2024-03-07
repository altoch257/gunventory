<?php
  $title = "Add Ammo";
  
  include_once('header.php');

  require_once('includes/dbh.inc.php');

  include 'includes/add-ammo.inc.php';

  if (!isset($_SESSION['user'])) {
    echo "<script>window.location = 'login.php';</script>";
  }

  $msgClass = 'errordiv';
?>

<div class="container">

  <div class="form-group row justify-content-center">
    <div class="col-sm-10 col-md-8 col-lg-6">
      <p class="display-6 mt-5 mb-0">Add Ammo</p>
      <p class="mt-0"><hr/></p>
    </div>
  </div>
    
  <form method="post" class="form" enctype="multipart/form-data">

  <div class="form-group row justify-content-md-center">

    <div class="col-sm-10 col-md-8 col-lg-7">
      <input type="text" class="form-control floating_input" name="brand" id="brand" autocomplete="off" tabindex="1" placeholder="Manufacturer" value="<?php echo !empty($postData['brand']) ? $postData['brand'] : ''; ?>" autofocus>
      <label for="brand" class="floating_label" data-content="Manufacturer *">
      <span class="hidden--visually">brand</span></label>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[0])) {
          foreach ($statusMsgs[0] as $brandErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $brandErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7">
      <select class="form-control form-control-2" name="gunType" id="gunType" tabindex="2">
        <option>[Select Gun Type] *</option>
        <!-- Fetch Gun Type from DB -->
        <?php
          $sqlSelect = $db->prepare("SELECT * FROM GunTypes WHERE Status = 'A';");
          $sqlSelect->execute();

          while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row['Id'] ."'>" . $row['GunType'] . "</option>";
          }
        ?>
      </select>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[1])) {
          foreach ($statusMsgs[1] as $caliberErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $caliberErrors . "</p></div>";
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
      <input type="text" class="form-control floating_input" name="rounds" id="rounds" autocomplete="off" tabindex="4" placeholder="No. of Rounds" value="<?php echo !empty($postData['rounds']) ? $postData['rounds'] : ''; ?>" autofocus>
      <label for="rounds" class="floating_label" data-content="Rounds *">
      <span class="hidden--visually">rounds</span></label>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[3])) {
          foreach ($statusMsgs[3] as $roundsErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $roundsErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7">
      <input type="date" class="form-control floating_input" name="purchaseDate" id="purchaseDate" autocomplete="off" tabindex="5" placeholder="Purchase Date" value="<?php echo !empty($postData['purchaseDate']) ? $postData['purchaseDate'] : ''; ?>">
      <label for="purchaseDate" class="floating_label" data-content="Purchase Date *">
      <span class="hidden--visually">purchaseDate</span></label>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[4])) {
          foreach ($statusMsgs[4] as $purchaseDateErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $purchaseDateErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7">
      <input type="text" class="form-control floating_input" name="price" id="price" autocomplete="off" tabindex="6" placeholder="Price" value="<?php echo !empty($postData['price']) ? $postData['price'] : ''; ?>" autofocus>
      <label for="price" class="floating_label" data-content="Price *">
      <span class="hidden--visually">price</span></label>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[5])) {
          foreach ($statusMsgs[5] as $priceErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $priceErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7 pt-3">
      <input type="file" class="form-control floating_input pt-3 pb-5" name="attachment" id="attachment" tabindex="7">
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
    
