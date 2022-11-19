<?php
$items = file_get_contents(__DIR__ ."/../database/items.json");
$items = json_decode($items, true);

$descriptions = file_get_contents(__DIR__ ."/../database/descriptions.json");
$descriptions = json_decode($descriptions, true);

$item_filters = file_get_contents(__DIR__ ."/../database/filters.json");
$item_filters = json_decode($item_filters, true);

$items_id = [];
$items_array = [];
$no_items = 0;
$max_price = 0;
$min_price = 1000000;

if(!array_key_exists('filters', $_SESSION)){
  $_SESSION["filters"] = [
    "types" =>
      ["type1" => "checked", "type2" => "checked", "type3" => "checked"],
    "range" =>
      ["start" => 0, "end" => 100]
  ];
}

$filters = $_SESSION['filters'];
$checked1 = $filters['types']['type1'];
$checked2 = $filters['types']['type2'];
$checked3 = $filters['types']['type3'];

foreach($item_filters as $key => $filter){
  if($filter['price'] > $max_price){
    $max_price = $filter['price'];
  }
  if($filter['price'] < $min_price){
    $min_price = $filter['price'];
  }
  if($filter['types']['type1'] == "checked" and $checked1 == "checked"){
    array_push($items_id, $filter['id']);
  }elseif($filter['types']['type2'] == "checked" and $checked2 == "checked"){
    array_push($items_id, $filter['id']);
  }elseif($filter['types']['type3'] == "checked" and $checked3 == "checked"){
    array_push($items_id, $filter['id']);
  }
  if($filter['price'] > $filters['range']['end']){
    foreach($items_id as $key => $id){
      if($filter['id'] == $id){
        unset($items_id[$key]);
        break;
      }
    }
  }
}

foreach($items as $key => $item){
  foreach($items_id as $key => $id){
    if($item['id'] == $id){
      array_push($items_array, $item);
    }
  }
}

if(!array_key_exists(0, $items_array)){
  $no_items = 1;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nazov</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
    integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/db23ba13d0.js" crossorigin="anonymous"></script>
    <link href="/design/style.css" rel="stylesheet">
  </head>
  <body>
    <div class="row">
      <div class="col-sm-1">
      </div>
      <div class="col-sm-10">
        <div class="filter-holder">
          <div class="filter pull-left">
            <span class="filter-label"><i class="icon-color fa-solid fa-filter center"></i></span>
              <div class="filter-item">
                <form action="/filter" method="get">
                  <div class="filters row" style="padding-bottom: 20px; padding-top: 10px;">
                    <div class="col-sm-6" style="width: 100%;">
                      <p style="padding-bottom: 5px;">Types:</p>
                      <label class="checkbox" for="check1">
                        <input <?php print($checked1); ?> class="checkbox_input" type="checkbox" name="type1" id="check1">
                        <div class="check_circle"></div>
                        <div class="checkbox_box"></div>
                        type1
                      </label>
                      <br>
                      <label class="checkbox" for="check2">
                        <input <?php print($checked2); ?> class="checkbox_input" type="checkbox" name="type2" id="check2">
                        <div class="check_circle"></div>
                        <div class="checkbox_box"></div>
                        type2
                      </label>
                      <br>
                      <label class="checkbox" for="check3">
                        <input <?php print($checked3); ?> class="checkbox_input" type="checkbox" name="type3" id="check3">
                        <div class="check_circle"></div>
                        <div class="checkbox_box"></div>
                        type3
                      </label>
                    </div>
                    <div class="col-sm-6" style="width: 100%">
                      <p style="padding-bottom: 5px;" id="slider-value"></p>
                      <div class="slidecontainer">
                        <input type="range" name="range" min="<?php echo($min_price); ?>" max="<?php echo($max_price); ?>" value="<?php print($filters['range']['end']);?>" class="slider" id="Slider">
                        <br>
                        <label for="range"><?php echo($min_price); ?> - <?php echo($max_price); ?></label>
                      </div>
                      <br><br>
                      <button class="filter-button" type="submit">Filter</button>
                    </div>
                  </div>
                </form>
              </div>
          </div>
          <form action="/filter" method="get">
            <input checked class="checkbox_input" type="checkbox" name="type1" id="check1">
            <input checked class="checkbox_input" type="checkbox" name="type2" id="check2">
            <input checked class="checkbox_input" type="checkbox" name="type3" id="check3">
            <input class="hide-input" type="range" name="range" min="0" max="<?php echo($max_price);?>" value="<?php echo($max_price);?>">
            <button class="filter-cancel" type="submit">
              <i class="fa-solid fa-xmark center" style="font-size: 30px;"></i>
            </button>
          </form>
        </div>
        <div class="row" style="padding-top: 40px;">
          <?php if($no_items == 1): ?>
            <div class="main-description" style="color: red; text-align: center; border-color: black;">
              No items found
            </div>
          <?php endif; ?>
          <?php foreach ($items_array as $key => $item): ?>
            <div class="col-sm-4 item-holder">
              <div class="shadow">
                <div class="image-holder">
                  <?php foreach($descriptions as $description): ?>
                    <?php if($description['id'] == $item['id']): ?>
                      <div class="description">
                        <span class="description"><?php echo($description['short']); ?></span>
                      </div>
                    <?php endif; ?>
                  <?php endforeach ?>
                  <img class="item-img" src="/../<?php echo($item['image']); ?>">
                </div>
                <form action="/item" method="get">
                  <input type="hidden" name="id" value="<?php echo($item['id']); ?>">
                  <div class="item-name">
                    <div class="row">
                      <div class="col-sm-6 col-xs-6" style="text-align: center;">
                        <?php echo($item['name']); ?>
                      </div>
                      <div class="col-sm-6 col-xs-6" style="text-align: center;">
                        Price: <?php echo($item['price']); ?>€
                      </div>
                    </div>
                    <button class="item-button" type="submit"></button>
                  </div>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      var slider = document.getElementById("Slider");
      var output = document.getElementById("slider-value");
      output.innerHTML = "Price: " + slider.value;

      slider.oninput = function() {
        output.innerHTML = "Price: " + this.value;
      }
    </script>
  </body>
</html>