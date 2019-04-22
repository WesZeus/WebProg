<?php include "templates/header.php"; ?>
<?php
require "../config.php";
require "../common.php";
?>

<div class="container-fluid">
    <div class="topsection">
    <img src="images/pic_1_home.jpg" alt="">
	  <?php include "templates/menu.php"; ?>
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
                $stmt = $connection->prepare("SELECT product_category FROM products");
                $stmt->execute();
				$pcategories = $stmt->fetchAll(PDO::FETCH_ASSOC); 
				//print_r($pcategories);
				?>
				<?php $count = 0; ?>
                <?php foreach ($pcategories as $cat) { ?>
					<?php $catname = str_replace("_"," ",$cat['product_category']); ?>
                    <div class="col2 gallerysec">
						 <img class="catimg" src="images/img_1.jpg" alt="">						
						<div class="gallerybtn">
                            <h3><a href="category-single.php?catname=<?php echo $catname; ?>"><?php echo $catname; ?></a> </h3>
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