<?php
$items = file_get_contents(__DIR__ ."/../database/items.json");
$items = json_decode($items, true);

$descriptions = file_get_contents(__DIR__ ."/../database/descriptions.json");
$descriptions = json_decode($descriptions, true);

$id = $_GET['id'];
$item = [];
$description = [];

foreach($items as $value){
	if($value['id'] == $id){
		$item = $value;
		break;
	}
}
foreach($descriptions as $value){
	if($value['id'] == $id){
		$description = $value;
		break;
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
	    <meta charset="UTF-8">
	    <meta name="viewport"
	    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	    <title>Item</title>
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
	    integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	    <script src="https://kit.fontawesome.com/db23ba13d0.js" crossorigin="anonymous"></script>
	    <link href="/design/style.css" rel="stylesheet">
  	</head>
	<body>
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-10" style="text-align: center;">
				<img class="main-image" src="/../<?php echo($item['image']); ?>">
				<div class="main-name">
					<div class="row">
						<div class="col-sm-6 col-xs-6" style="text-align: center;">
							<?php echo($item['name']); ?>
						</div>
						<div class="col-sm-6 col-xs-6" style="text-align: center;">
							Price: <?php echo($item['price']); ?>€
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
				<div class="main-description">
					<?php echo($description['long']); ?> <br>
					test <br>
					test <br>
					test <br>
				</div>
			</div>
		</div>
	</body>
</html>