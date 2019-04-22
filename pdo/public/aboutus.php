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
              <h5>About us</h5>
          </div>
          <div class="thenav">
          <?php include "templates/menu.php"; ?>
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
                $stmt = $connection->prepare("SELECT * FROM pages WHERE page_name='about_us_'");
                $stmt->execute();
				$pages = $stmt->fetchAll(PDO::FETCH_ASSOC); 
				// echo "<pre>";
				//  print_r($pages);
				//  echo "</pre>";
				?>
                <?php foreach ($pages as $page) { ?>
					<?php $pagename = str_replace("_"," ",$page['page_name']); ?>
                    <div class="aboutsection">
						<h1><?php echo ucfirst($pagename); ?></h1>
						 <div>
							Description: <?php echo $page['page_description']; ?>
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