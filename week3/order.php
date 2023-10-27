<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vegetable Order Summary</title>
  <link rel="stylesheet" href="veggies.css?v=<?php echo time(); ?>">
  
</head>
<body>
<div class="navbar">
    <h1> Vegetable Shop</h1>
 </div>


<div class="container">
<?php

function calculateOrder($extras, $total_price, $extras_prices){
  foreach ($extras as $extra) {
      $total_price += $extras_prices[$extra];
  }
  return $total_price;
}

function displayOrder($total_price, $product_prices, $product_type, $size_prices,$size,$extras,$extras_prices){

  echo "<div class='order'>";
  echo "Name:" ." ". htmlspecialchars($_POST["name"]) . "<br>";
  echo "<br>Vegatable Type:" ." ". htmlspecialchars($_POST["choices"]) . " (₱" . number_format($product_prices[$product_type], 2) . ")<br>";
  echo "Size:" ." ". htmlspecialchars($_POST["size"]) . " (₱" . number_format($size_prices[$size], 2) . ")<br>";

  if (!empty($extras)) {
      echo "Extras:" ." ". implode(", ", $extras) . " (₱" . number_format(array_sum(array_intersect_key($extras_prices, array_flip($extras))), 2) . ")<br>";
  }
  echo "Total Price:₱" ." ". number_format($total_price, 2) . "<br>";
  echo "Special Instructions<br>" . htmlspecialchars($_POST["instructions"]) . "<br>";
}

function displayImageAndInfo($product_type){

    switch($product_type) {
        case "potato":
            $result ="<img src='https://www.gardenia.net/wp-content/uploads/2023/05/solanum-tuberosum.webp'>The potato is a starchy food, a tuber of the plant Solanum tuberosum and is a root vegetable native to the Americas. The plant is a perennial in the nightshade family Solanaceae. Wild potato species can be found from the southern United States to southern Chile.";
            break;
        case "carrot":
            $result ="<img src='https://www.economist.com/cdn-cgi/image/width=1424,quality=80,format=auto/sites/default/files/20180929_BLP506.jpg'>The carrot is a root vegetable, typically orange in color, though heirloom variants including purple, black, red, white, and yellow cultivars exist, all of which are domesticated forms of the wild carrot, Daucus carota, native to Europe and Southwestern Asia. ";
            break;
        case "tomato":
            $result ="<img src='https://images-prod.healthline.com/hlcmsresource/images/AN_images/tomatoes-1296x728-feature.jpg'>The tomato is the edible berry of the plant Solanum lycopersicum, commonly known as the tomato plant. The species originated in western South America, Mexico, and Central America. The Nahuatl word tomatl gave rise to the Spanish word tomate, from which the English word tomato derived.";
            break;
        case "cabbage":
            $result ="<img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSkEeqh9Pgh8x6s03XcAylTlfq0r6SsxWgoviVOR73X7SrIA6BMbDJHG4QAOfj44_JIt90&usqp=CAU'>Cabbage, comprising several cultivars of Brassica oleracea, is a leafy green, red, or white biennial plant grown as an annual vegetable crop for its dense-leaved heads.";
            break;
        case "celery":
            $result ="<img src='https://img.taste.com.au/dOryg-6K/taste/2007/07/celery-181887-1.jpg'>Celery is a marshland plant in the family Apiaceae that has been cultivated as a vegetable since antiquity. Celery has a long fibrous stalk tapering into leaves. Depending on location and cultivar, either its stalks, leaves or hypocotyl are eaten and used in cooking. Celery seed powder is used as a spice.";
            break;
    }

    echo $result;
}

function generateReceiptContent($name, $productType, $product_prices, $size, $size_prices, $extras, $extras_prices, $total_price, $instructions){
    $receiptContent ="Order Summary\n";
    $receiptContent .="-----------------\n";

    $receiptContent .="Name:".$name. "\n";

    $receiptContent .="Product Type:".$productType."(₱".number_format($product_prices[$productType], 2).")\n";

    $receiptContent.="Size:".$size."(₱".number_format($size_prices[$size], 2).")\n";

    if(!empty($extras))
    {
        $receiptContent .="Extras: " . implode(",", $extras)."(₱" . number_format(array_sum(array_intersect_key($extras_prices, array_flip($extras))), 2). ")\n";
    }

    $receiptContent.="Total Price: ₱". number_format($total_price, 2)."\n";

        $receiptContent.="Special Instructions: ".$instructions. "\n";

        $receiptContent .="\n";
        $receiptContent .="Thank you for your order!";

        return $receiptContent;
}

function saveReceiptToFile($receiptContent){
    $file=fopen("Order.txt", "w+") or die("Unable to open file!");

    fwrite($file,$receiptContent);

   fclose($file);

    echo "Receipt created successfully as Order.txt!";
}

echo "<button class='orderagain'><a href ='http://localhost/php/index.html'>Order Again</a></button>";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "<div class='summary'>";
    echo "<h2>📝 Order Summary</h2>";

    $product_prices = [
        "potato" => 90,
        "carrot" => 80,
        "tomato" => 20,
        "cabbage" => 80,
        "celery" => 90,
    ];

    $size_prices = [
        "small" => .2,
        "medium" => .5,
        "large" => 1,
    ];

    $extras_prices = [
        "plastic" => 5.75,
        "paper" => 10.50,
    ];

    $name = htmlspecialchars($_POST["name"]);
    $productType=htmlspecialchars($_POST["choices"]);
    $size=htmlspecialchars($_POST["size"]);
    $instructions=htmlspecialchars($_POST["instructions"]);

    $product_type = $_POST["choices"];
    $size = $_POST["size"];
    $extras = isset($_POST["extras"]) ? $_POST["extras"] : [];
    $total_price = $product_prices[$product_type] * $size_prices[$size];

    


    displayOrder($total_price, $product_prices, $product_type, $size_prices,$size,$extras,$extras_prices);


    displayImageAndInfo($product_type);


  
    echo "</div>";

    echo "<div class='receipt'>";
    $receiptContent = generateReceiptContent($name, $productType, $product_prices, $size, $size_prices, $extras, $extras_prices, $total_price, $instructions);

    saveReceiptToFile($receiptContent);
    echo "</div>";
    

}


?>
</div>

</body>
</html>
