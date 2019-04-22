<?php
require "../config.php";
require "../common.php";
?>
<?php
//SUBMIT EVENT DATA TO DB
if (isset($_POST['submit'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        if (empty($_POST['event_name'])) {
            $eventnameError = 'Event name required';
        } else {
            $event_name = trim(htmlspecialchars($_POST['event_name']));
        }

        if (empty($_POST['event_description'])) {
            $eventdError = 'Event Description required';
        } else {
            $event_description = trim(htmlspecialchars($_POST['event_description']));
        }

        if (empty($_POST['event_start_date'])) {
            $startDateError = 'Satrt Date required';
        } else {
            $event_start_date = trim(htmlspecialchars($_POST['event_start_date']));
        }

        if (empty($_POST['event_end_date'])) {
            $endDateError = 'End Date required';
        } else {
            $event_end_date = trim(htmlspecialchars($_POST['event_end_date']));
        }

        // Select file type
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      
        // Valid file extensions
        $extensions_arr = array("jpg","jpeg","png","gif");



        if (empty($_POST['location'])) {
            $locationError = 'End Date required';
        } else {
            $location = trim(htmlspecialchars($_POST['location']));
        }

        if (empty($_POST['venue'])) {
            $venueError = 'Venue required';
        } else {
            $venue = trim(htmlspecialchars($_POST['venue']));
        }

        // $target_dir = "uploads/";
        // $target_path = $target_dir.basename( $_FILES['event_image']['name']);

        if(move_uploaded_file($_FILES['event_image']['tmp_name'], $target_path)) { 
            echo "File uploaded successfully!"; 
           } else{ 
            echo "Sorry, file not uploaded, please try again!"; 
           } 

        $new_event = array(
            "event_name"         => $event_name,
            "event_description"  => $event_description,
            "event_start_date"   => $event_start_date,
            "event_end_date"     => $event_end_date,
            "location"           => $location,
            //"event_image"        => $image,
            "venue"              => $venue
        );

        print_r($new_event);

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "events",
            implode(", ", array_keys($new_event)),
            ":" . implode(", :", array_keys($new_event))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_event);
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>


<?php
//SUBMIT PRODUCT DATA TO DB
if (isset($_POST['submitp'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $products = array(
            "product_name"        => $_POST['product_name'],
            "product_description" => $_POST['product_description'],
            "product_image"       => addslashes(file_get_contents($_FILES['myimage']['tmp_name'])),
            "product_category"    => $_POST['product_category']
        );

       // print_r($products);

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "products",
            implode(", ", array_keys($products)),
            ":" . implode(", :", array_keys($products))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($products);
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>




<?php
//SUBMIT PAGE DATA TO DB
if (isset($_POST['submitpage'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $page_tite = str_replace(' ', '_', $_POST['page_name']);
        $pagesdata = array(
            "page_name"        =>  $page_tite,
            "page_description" => $_POST['page_description'],
            "page_image"       => $_POST['page_image']
        );

       // print_r($pagesdata);

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "pages",
            implode(", ", array_keys($pagesdata)),
            ":" . implode(", :", array_keys($pagesdata))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($pagesdata);
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>



<?php
//SUBMIT PROMO ITEMS TO DB
if (isset($_POST['submitpromo'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $promo_tite = str_replace(' ', '_', $_POST['promo_name']);
        $promodata = array(
            "promo_name"        => $promo_tite,
            "promo_price"       => $_POST['promo_price'],
            "promo_description" => $_POST['promo_description'],
            "promo_image"       => $_POST['promo_image']
            
        );

        //print_r($promodata);

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "promotions",
            implode(", ", array_keys($promodata)),
            ":" . implode(", :", array_keys($promodata))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($promodata);
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>



<?php require "templates/header.php"; ?>

<div class="container ">
    <div class="row">
        <div cl a ss="columns text-left">
            <h2>Hotel Manager </h2>
        </div>
        <div c l ass="columns text-right">
            <?php if (isset($_POST['submit']) && $statement) : ?>
                <blockquote>Event Added Successfully.</blockquote>
            <?php endif; ?>
            <?php if (isset($_POST['submitp']) && $statement) : ?>
                <blockquote>Product Added Successfully.</blockquote>
            <?php endif; ?>
            <?php if (isset($_POST['submitpage']) && $statement) : ?>
                <blockquote>Product Added Successfully.</blockquote>
            <?php endif; ?>
            <?php if (isset($_POST['submitpromo']) && $statement) : ?>
                <blockquote>Product Added Successfully.</blockquote>
            <?php endif; ?>
        </div>
    </div>
    <hr>
    <!-- event form section -->
    <div class="row">
        <div class="col3">
            <div id="eventbx">
                <a href="#" id="evenbtn" class="clickbtn">
                    <h5>Add Events</h5>
                </a>
                <div id="eventform">
                    <form method="post" action="additems.php" enctype="multipart/form-data">
                        <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
                        <br />
                        <input type="text" name="event_name" id="event_name" placeholder="Event Name" required>
                        <span class="error"><?php if (isset($eventnameError)) echo $eventnameError ?></span>
                        <br />
                        <textarea name="event_description" placeholder="Enter Eevnt Description" rows="5" cols="43"></textarea>
                        <span class="error"><?php if (isset($eventdError)) echo $eventdError ?></span>
                        <br />
                        <label for="event_start_date">Event Start Date</label>
                        <input type="date" name="event_start_date" id="event_start_date" required>
                        <span class="error"><?php if (isset($startDateError)) echo $startDateError ?></span>
                        <label for="event_start_date">Event End Date</label>
                        <input type="date" name="event_end_date" id="event_end_date" required>
                        <span class="error"><?php if (isset($event_end_date)) echo $event_end_date ?></span>
                        <br />
                        <label for="event_image">Event image</label>
                        <input type="file" name="event_image" id="fileToUpload">
                        <input type="text" name="venue" id="location" placeholder="Venue" required>
                        <span class="error"><?php if (isset($vwnuenError)) echo $venueError ?></span>
                        <br />
                        <input type="text" name="location" id="location" placeholder="Location" required>
                        <span class="error"><?php if (isset($locationError)) echo $locationError ?></span>
                        <br />
                        <input type="submit" name="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>

        <!-- product form section  -->
        <div class="col3">
            <div id="eventbx">
                <a href="#" id="productbtn" class="clickbtn">
                    <h5>Add product</h5>
                </a>
                <div id="productform">
                    <form method="post" action="additems.php" enctype="multipart/form-data">
                        <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
                        <br />
                        <input type="text" name="product_name" id="event_name" placeholder="Product Name" required>
                        <br />
                        <textarea name="product_description" placeholder="Enter Product Description" rows="5" cols="43"></textarea>
                        <br />
                        <label for="product_image">Product image</label>
                        <input type="file" name="product_image" accept="image/*" required>
                        <br />
                        <select name="product_category" required>
                            <option value="food_and_beverage">Food and Beverage</option>
                            <option value="shoppig">Shoppig</option>
                            <option value="hotel_experiences">Hotel Experiences</option>
                            <option value="outdoors">Outdoors</option>
                            <option value="events">Events</option>
                            <option value="wildlife">Wildlife</option>
                        </select>

                        <input type="submit" name="submitp" value="Submit">
                    </form>
                </div>
            </div>
        </div>
        <!-- add pages -->
        <div class="col3">
            <div id="eventbx">
                <a href="#" id="pagebtn" class="clickbtn">
                    <h5>Add Pages</h5>
                </a>
                <div id="pageform">
                    <form method="post" action="additems.php" enctype="multipart/form-data">
                        <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
                        <br />
                        <input type="text" name="page_name" id="event_name" placeholder="Page Name" required>
                        <br />
                        <textarea name="page_description" placeholder="Enter Page Description" rows="5" cols="43"></textarea>
                        <br />
                        <label for="product_image">Product image</label>
                        <input type="file" name="page_image" accept="image/*" required>
                        <br />
                        <input type="submit" name="submitpage" value="Submit">
                    </form>
                </div>
            </div>
        </div>

         <!-- add promotional items -->
         <div class="col3">
            <div id="eventbx">
                <a href="#" id="promobtn" class="clickbtn">
                    <h5>Add Promotion items</h5>
                </a>
                <div id="promoform">
                    <form method="post" action="additems.php" enctype="multipart/form-data">
                        <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
                        <br />
                        <input type="text" name="promo_name" id="event_name" placeholder="Promot item Name" required>
                        <br />
                        <input type="text" name="promo_price" id="event_description" placeholder="Item Price" required>
                        <br />
                        <textarea name="promo_description" placeholder="Enter Promo Description" rows="5" cols="43"></textarea>
                        <label for="product_image">Promotion item image</label>
                        <input type="file" name="promo_image" accept="image/*" required>
                        <br />
                        <input type="submit" name="submitpromo" value="Submit">
                    </form>
                </div>
            </div>
        </div>
        

    </div>
</div>
</div>

<?php require "templates/footer.php"; ?>
<script>
    $(document).ready(function() {
        //toggle event button
        $("#evenbtn").click(function() {
            $("#eventform").slideToggle();
        });

        // toggle product button
        $("#productbtn").click(function() {
            $("#productform").slideToggle();
        });
         // toggle product button
         $("#pagebtn").click(function() {
            $("#pageform").slideToggle();
        });
          // toggle product button
          $("#promobtn").click(function() {
            $("#promoform").slideToggle();
        });
    });
</script>