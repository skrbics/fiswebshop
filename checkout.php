<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Checkout</title>

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

</head>

<body>

    <header id="header">
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Simple Shopping Cart</a>
          </div>

          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <!-- left nav here -->
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="view_cart.php"><span class="badge"><?php echo count($_SESSION['cart']); ?></span> Cart <span class="glyphicon glyphicon-shopping-cart"></span></a></li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <main id="main" role="main">
        <section id="checkout-container">
            <div class="container">
                <div class="py-5 text-center">
                    <i class="fa fa-credit-card fa-3x text-primary"></i>
                    <h2 class="my-3">Checkout</h2>
                    <p class="lead">Please fill the form</p>
                </div>
                <div class="row py-5">
                    <div class="col-md-4 order-md-2 mb-4">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Your cart</span>
                            <span class="badge badge-secondary badge-pill"><?php echo count($_SESSION['cart']); ?></span>
                        </h4>
                        <ul class="list-group mb-3">
                          <?php
                            $total = 0;
														$index = 0;
                            if(!empty($_SESSION['cart'])){
                              $conn = new mysqli('localhost', 'fisuser', 'fis', 'fisexample');
                              if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                              }
                              $sql = "SELECT name,price FROM products WHERE id IN (".implode(',',$_SESSION['cart']).");";
															$query = $conn->query($sql);
															while($row = $query->fetch_assoc()){
                          ?>
                          <li class="list-group-item d-flex justify-content-between lh-condensed">
                              <div>
                                  <h6 class="my-0"><?php echo $row['name']; ?></h6>
                                  <small class="text-muted">Quantity: <?php echo $_SESSION['qty_array'][$index]; ?></small>
                              </div>
                              <span class="text-muted">$<?php echo number_format($_SESSION['qty_array'][$index]*$row['price'], 2); ?></span>
                          </li>
                          <?php $total += $_SESSION['qty_array'][$index]*$row['price']; ?>
                          <?php
                              $index ++;
                            }
                          }
                          else{ ?>
                            <li class="list-group-item d-flex justify-content-between bg-light">
                                <div class="text-success">
                                    <h6 class="my-0">Cart empty!</h6>

                                </div>

                            </li>
                            <?php
                          }
                          ?>

                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total (USD)</span>
                                <strong>$<?php echo number_format($total, 2); ?></strong>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-8 order-md-1">
                        <h4 class="mb-3">Billing address</h4>
                        <form class="needs-validation" novalidate method="post" action="finish.php">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName">First name</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="" value="" required>
                                    <div class="invalid-feedback">
                                        Valid first name is required.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName">Last name</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName" placeholder="" value="" required>
                                    <div class="invalid-feedback">
                                        Valid last name is required.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email">Email
                                    <span class="text-muted">(Optional)</span>
                                </label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com">
                                <div class="invalid-feedback">
                                    Please enter a valid email address for shipping updates.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required>
                                <div class="invalid-feedback">
                                    Please enter your shipping address.
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label for="country">Country</label>
                                    <select class="custom-select d-block w-100" id="country" name="country" required>
                                        <option value="">Choose...</option>
																				<option>Bosnia</option>
																				<option>Croatia</option>
																				<option>Serbia</option>
																				<option>Slovenia</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a valid country.
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="zip">Post code</label>
                                    <input type="text" class="form-control" id="zip" name="zip" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Post code required.
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-4">

                            <h4 class="mb-3">Payment</h4>

                            <div class="d-block my-3">
                                <div class="custom-control custom-radio">
                                    <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked required>
                                    <label class="custom-control-label" for="credit">Credit card</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required>
                                    <label class="custom-control-label" for="debit">Debit card</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cc-name">Name on card</label>
                                    <input type="text" class="form-control" id="cc-name" name="cc-name" placeholder="" required>
                                    <small class="text-muted">Full name as displayed on card</small>
                                    <div class="invalid-feedback">
                                        Name on card is required
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cc-number">Credit card number</label>
                                    <input type="text" class="form-control" id="cc-number" name="cc-number" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Credit card number is required
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="cc-expiration">Expiration</label>
                                    <input type="text" class="form-control" id="cc-expiration" name="cc-expiration" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Expiration date required
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="cc-expiration">CVV</label>
                                    <input type="text" class="form-control" id="cc-cvv" name="cc-cvv" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Security code required
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-4">
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- jQuery first, then Bootstrap JS.
    <script src="dist/jquery/jquery.min.js"></script>
    <script src="dist/popper/popper.min.js" integrity=""></script>
    <script src="dist/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.min.js"></script>-->
</body>

</html>
