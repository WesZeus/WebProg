<?php include "templates/header.php"; ?>
<?php
require "../config.php";
require "../common.php";
?>

<div class="container-fluid">
    <div class="topsection">
    <img src="images/pic_1_home.jpg" alt="">
      <div class="menu">
            <div class="logo">
              <h1>H</h1>
              <h2>heights</h2>
              <h2>Hotel</h2>
              <h5>Gallery</h5>
          </div>
          <div class="thenav">
          <?php include "templates/menu.php"; ?>
          </div>
        </div>
    </div>
</div>

<div class="container">
       <div class="row">
        <h1>Events</h1>
       </div>
        <div class="row">
            <?php
            //Connect to db 
            try {
                $connection = new PDO($dsn, $username, $password, $options); ?>

                <?php
                // mysql select query
                $stmt = $connection->prepare("SELECT * FROM events");
                $stmt->execute();
				$events = $stmt->fetchAll(PDO::FETCH_ASSOC); 
				//print_r($events);
				?>
                <?php foreach ($events as $value) { ?>
					<?php $eventname = str_replace("_"," ",$value['event_name']); ?>
                    <div class="col3 ">
                        <div class="eventsec">
                           
                            <img class="catimg" src="images/img_1.jpg" alt="">						
                            <div class="eventbxcont">
                                <h2><a href="booknow.php?eventid=<?php echo $value['event_id']; ?>&activityname=<?php echo $eventname; ?>"><?php echo $eventname; ?></a></h2>
                                <div class="dates">
                                    <span>
                                    Sart Date <?php echo $value['event_start_date']; ?>
                                    </span>
                                    <span>
                                    End Date <?php echo $value['event_end_date']; ?>
                                    </span>
                                </div>
                                <a class="booknow" href="booknow.php?eventid=<?php echo $value['event_id']; ?>&eventname=<?php echo $eventname; ?>">Book Now</a>
                            </div>
                          
                        </div>
                    </div>
                <?php } ?>

            <?php
        } catch (PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }

        ?>
    </div>
</div>

<?php //include "templates/footer.php"; ?>