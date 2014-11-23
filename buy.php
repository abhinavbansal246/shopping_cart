<?php
// Student name -- Abhinav Bansal
// Project url -- http://omega.uta.edu/~axb1869/project4/buy.php

session_start();

//IF(!isset($_session['ITEM']))

if(!isset($_SESSION['shoppingcart1']))
	$_SESSION['shoppingcart1']=array();

//session_destroy();
?>
<html>
<head>

<p>Buy Products</p>

<?php
//if(!isset($_SESSION['shoppingcart']))
	//$_SESSION['shoppingcart']=array();

if(isset($_GET['clear']))
{
session_destroy();
header('Location:http://omega.uta.edu/~axb1869/project4/buy.php');

}
foreach($_SESSION['item'] as $key=>$value)
{
	if(in_array($_GET['buy'],$value)){
		array_push($_SESSION['shoppingcart1'],$value);
		
	}
		
}

if(isset($_GET['delete']))
{

foreach($_SESSION['shoppingcart1'] as $key=>$value)
{
	if(in_array($_GET['delete'],$value)){
	
		unset($_SESSION['shoppingcart1'][$key]);	
	}
		
}

}

//print_r($_SESSION['shoppingcart1']);
$sum=0.0;
echo "<table border=1>";

foreach($_SESSION['shoppingcart1'] as $ar){

echo "<tr>";
//echo "<td>".$ar[0]."</td>";
echo "<td><a href=".$ar[4]."><img src=".$ar[2]."/></td>";
echo "<td>".$ar[1]."</td>";
echo "<td>".$ar[3]."</td>";
$sum+=$ar[3];
echo "<td><a href=buy.php?delete=".$ar[0].">"."delete"."</a></td>";
echo "</tr>";
}

echo "</table>";
?>
<br/>
<form action="buy.php">
<input type="hidden" name="clear" value=1/>
<input type="submit" value="Empty Basket"/>
</form>

<p> Total: <?php echo $sum."$"?></p>

<p>Shopping cart</p>
<div id="cart">

</div>
 <form  method="get" style="background-color:#FFA500;">
       <label >Search Items <input type="text" name="search"/></label>
       <input type="submit"  value="search"/>
    </form>
	
	<script>
	function putSession(cid){
	
	<?php  ?>
	//document.getElementById('cart').document;
	}
	</script>
	
</head>
<body>
<?php
error_reporting(E_ALL);
$searchp= $_GET["search"];
//echo "here";
$item= array();
$_SESSION['item']=array();
echo $searchp."<br>";
ini_set('display_errors','Off');
$xmlstr = file_get_contents('http://sandbox.api.ebaycommercenetwork.com/publisher/3.0/rest/GeneralSearch?apiKey=78b0db8a-0ee1-4939-a2f9-d3cd95ec0fcc&trackingId=7000610&keyword='.$searchp);
$xml = new SimpleXMLElement($xmlstr);

//header('Content-Type: text/xml');
//echo $xmlstr;
//var_dump($xml);
echo "<br>";
$result_set = $xml->categories->category->items->product;
$i = 0;
$doc = new DomDocument;
foreach ($result_set as $value)
   {
   $j = $i+1;
   echo "<h1>".$j."  ".$value->name."</h1><br>";
  //  echo '<div id="prod'.$i.'"> <a href="buy.php?buy='.$value->attributes().'"> <img src="'.$value->images->image->sourceURL.'" /> </a> </div>';
  echo '<div id="prod'.$i.'" onclick="putSession(id)"> <a href="buy.php?buy='.$value->attributes().'"> <img src="'.$value->images->image->sourceURL.'" ;/></a>  </div>';
   //  echo $value->images->image->sourceURL."<br>";
	 echo $value->minPrice."<br><br>";
  $name="".$value->name;
  $image="".$value->images->image->sourceURL;
  $price="".$value->minPrice;
  $offer="".$value->productOffersURL;
  $product_id = "".$value->attributes();
  array_push($item, $product_id,$name, $image, $price, $offer);
 // print_r($_SESSION['item']);
  //echo $name;
  //echo $image; 
  //echo $price;
  //echo $offer;
  //echo $product_id;
  
  $i++;  
  
   }
   array_push($_SESSION['item'], $item);
//echo $result_set->name;

echo "<br>";
//var_dump($xml);
?>
</body>
</html>
