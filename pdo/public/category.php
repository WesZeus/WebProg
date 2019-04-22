<?php 
$categoryname = str_replace(' ', '_', $_GET['catname']);
?>

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
            <?php
            //Connect to db 
            try {
                $connection = new PDO($dsn, $username, $password, $options); ?>

                <?php
                // mysql select query
                $stmt = $connection->prepare("SELECT * FROM products WHERE product_category='$categoryname'");
                $stmt->execute();
				$products = $stmt->fetchAll(PDO::FETCH_ASSOC); 
				//print_r($products);
				?>
                <?php foreach ($products as $product) { ?>
                    <div class="col3">
                        <?php //echo $product['product_image']; ?>
                        <img class="catimg" src="images/img_1.jpg" alt="">
                        <header class="">
                            <h3><a href="<?php echo $product['product_name']; ?>"></a> </h3>
						</header>						
						<div class="">
                        <?php echo $product['product_description']; ?>
						  <a class="seemorebx" href="single.php?pname=<?php echo $product['product_description'];?>">See more</a>
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