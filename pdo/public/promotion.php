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
              <h5>Promotions</h5>
          </div>
          <div class="thenav">
          <?php include "templates/menu.php"; ?>
          </div>
        </div>
    </div>
</div>

<div class="container">
        <div class="row">
            <?php
            //Connect to db 
            try {
                $connection = new PDO($dsn, $username, $password, $options); ?>

                <?php
                // mysql select query
                $stmt = $connection->prepare("SELECT promo_name FROM promotions");
                $stmt->execute();
				$promodata = $stmt->fetchAll(PDO::FETCH_ASSOC); 
				//print_r($pcategories);
				?>
				<?php $count = 0; ?>
                <?php foreach ($promodata as $promo) { ?>
					<?php $promoname = str_replace("_"," ",$promo['promo_name']); ?>
                    <div class="promobx">
                        <h1><?php echo $promoname; ?></h1>
						 <img class="catimg" src="images/img_1.jpg" alt="">						
						<div class="promobtn">
                            <h3><a href="single-promo.php?promoname=<?php echo $promoname; ?>">
                           See More</a> </h3>
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


<?php include "templates/footer.php"; ?>