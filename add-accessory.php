<?php
  $title = "Add Accessory";
  
  include_once('header.php');

  require_once('includes/dbh.inc.php');

  include('includes/add-accessory.inc.php');

  if (!isset($_SESSION['user'])) {
    echo "<script>window.location = 'login.php';</script>";
  }

  $msgClass = 'errordiv';
?>

<div class="container">

  <div class="form-group row justify-content-center">
    <div class="col-sm-10 col-md-8 col-lg-6">
      <p class="display-6 mt-5 mb-0">Add Accessory</p>
      <p class="mt-0"><hr/></p>
    </div>
  </div>
    
  <form method="post" class="form" enctype="multipart/form-data">

  <div class="form-group row justify-content-md-center">
    <div class="col-sm-10 col-md-8 col-lg-7">
      <input type="text" class="form-control floating_input" name="model" id="model" autocomplete="off" tabindex="1" placeholder="Model" value="<?php echo !empty($postData['model']) ? $postData['model'] : ''; ?>" autofocus>
      <label for="model" class="floating_label" data-content="Model *">
      <span class="hidden--visually">model</span></label>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[0])) {
          foreach ($statusMsgs[0] as $modelErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $modelErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7">
      <input type="text" class="form-control floating_input" name="manufacturer" id="manufacturer" autocomplete="off" tabindex="2" placeholder="Manufacturer" value="<?php echo !empty($postData['manufacturer']) ? $postData['manufacturer'] : ''; ?>" autofocus>
      <label for="manufacturer" class="floating_label" data-content="Manufacturer *">
      <span class="hidden--visually">manufacturer</span></label>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[1])) {
          foreach ($statusMsgs[1] as $manufacturerErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $manufacturerErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7">
      <select class="form-control form-control-2" name="firearm" id="firearm" tabindex="3">
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
        if (isset($statusMsgs[2])) {
          foreach ($statusMsgs[2] as $firearmErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $firearmErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7">
      <input type="date" class="form-control floating_input" name="purchaseDate" id="purchaseDate" autocomplete="off" tabindex="4" placeholder="Purchase Date" value="<?php echo !empty($postData['purchaseDate']) ? $postData['purchaseDate'] : ''; ?>">
      <label for="purchaseDate" class="floating_label" data-content="Purchase Date *">
      <span class="hidden--visually">purchaseDate</span></label>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[3])) {
          foreach ($statusMsgs[3] as $purchaseDateErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $purchaseDateErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7">
      <input type="text" class="form-control floating_input" name="price" id="price" autocomplete="off" tabindex="5" placeholder="Price" value="<?php echo !empty($postData['price']) ? $postData['price'] : ''; ?>">
      <label for="price" class="floating_label" data-content="Price *">
      <span class="hidden--visually">price</span></label>
    </div>
    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <?php
        if (isset($statusMsgs[4])) {
          foreach ($statusMsgs[4] as $priceErrors) {
            echo "<div><p class='small text-danger ml-4 mb-0'>" . $priceErrors . "</p></div>";
          }
        }
      ?>
    </div>

    <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
      <textarea class="form-control form-control-2" name="details" id="tiny" cols="30" rows="8" tabindex="6" placeholder="Additional Details *" value="<?php echo !empty($postData['details']) ? $postData['details'] : ''; ?>"></textarea>
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
    
