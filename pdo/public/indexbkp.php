<?php include "templates/header.php"; ?>
<?php
require "../config.php";
require "../common.php";
?>

<div class="container">
	<div class="row">
		<!-- <div class="loader" id="loader">
			<img src="images/loader.gif" alt="Loading...">
		</div> -->
		<div class="wrapper">
			<div class="slider">
				<div class="slider__wrapper">
					<!-- Images -->
				</div>
				<div class="slider__tracker">
					<!--Slider tracker-->
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
        <div class="row">
			<div class="quote">
            <?php
            //Connect to db 
            try {
                $connection = new PDO($dsn, $username, $password, $options); ?>

                <?php
                // query for 
                $stmt = $connection->prepare("SELECT * FROM pages");
                $stmt->execute();
				$pages = $stmt->fetchAll(PDO::FETCH_ASSOC); 
				echo "<pre>";
				 print_r($pages);
				 echo "</pre>";
				?>
                <?php foreach ($pages as $page) { ?>
					<?php $pagename = str_replace("_"," ",$page['page_name']); ?>
                    <div class="col3 catsection">
						 <!-- <img class="catimg" src="images/img_1.jpg" alt="">	 -->
						 <div>
							Description: <?php echo $page['page_description']; ?>
						 </div>					
						<div class="catbtm">
                          <header class="eventhead">
                            <h3><a href="<?php echo $cat['page_name']; ?>"><?php echo $pagename; ?></a> </h3>
						  </header>
						  <a class="seemorebx" href="category.php?catname=<?php echo $cat['product_category'];?>">See more</a>
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
</div>


<?php include "templates/footer.php"; ?>