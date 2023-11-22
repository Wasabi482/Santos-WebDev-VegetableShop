<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Vegetable Market</title>
    <link rel="stylesheet" href="veggies.css?v=<?php echo time(); ?>">
    
</head>
<body>
  <div class="container">
    <h1>Vegetable Shop Orders</h1>
    <table>
      <tr>
        <th>Order ID</th>
        <th>Name</th>
        <th>Vegetable Type</th>
        <th>Size</th>
        <th>Total Price</th>
        <th>Instructions</th>
        <th>Extras</th>
      </tr>
      <?php include 'show_order.php';?>
    </table>

    <br/>

    <form action="index.html">
      <button type="submit">Back to Main Menu</button>
    </form>
  </div>
</body>
</html>