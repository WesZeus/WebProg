<?php 
$eventid = $_GET['eventid'];
$eventname = $_GET['eventname'];
?>

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

        
        $booking = array(
            "eventid"           => $eventid,
            "eventname"         => $event_name,
            "full_name"         => $_POST['full_name'],
            "email"             => $_POST['email'],
            "childrens"         => $_POST['childrens'],
            "adults"            => $_POST['adults']
        );

        print_r($booking);

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

<?php require "templates/header.php"; ?>
<div class="container-fluid">
    <div class="topsection">
    <img src="images/pic_1_home.jpg" alt="">
      <div class="menu">
            <div class="logo">
              <h1>H</h1>
              <h2>heights</h2>
              <h2>Hotel</h2>
              <h5>Book Now</h5>
          </div>
          <div class="thenav">
          <?php include "templates/menu.php"; ?>
          </div>
        </div>
    </div>
</div>

<div class="container ">
    <div class="row">
        <div c l ass="columns text-right">
            <?php if (isset($_POST['submit']) && $statement) : ?>
                <blockquote>Event Added Successfully.</blockquote>
            <?php endif; ?>
        </div>
    </div>
    <!-- event form section -->
    <div class="row">
        <div class="col2">
        Event Name<h5>Book <?php echo $eventname;?></h5>
            <div id="eventbx">
                <div id="eform">
                    <form method="post" action="booknow.php">
                        <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
                        <input type="text" name="full_name" id="event_name" placeholder="Full Name" required>
                        <br />
                        <input type="number" name="phonenumber" id="event_name" placeholder="Phone Number" required>
                        <br />
                        <input type="email" name="email" id="event_name" placeholder="Email" required>
                        <br />
                        <input type="number" name="adults" id="" placeholder="No of Adults" required>
                        <br />
                        <input type="number" name="childrens" id="" placeholder="No of Childrens" required>
                        <br />
                        
                        <input type="submit" name="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>

       

    </div>
</div>
</div>

<?php require "templates/footer.php"; ?>