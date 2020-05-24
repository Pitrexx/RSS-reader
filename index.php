<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
			<title>Piotr Michalski</title>
			<link rel="stylesheet" href="styles.css">
		</head>
		<body style="background-color:powderblue;">
			<div id="container">
				<div class="content">

				 <form method="post" action="">
				  <input type="text" name="feedurl" placeholder="Wprowadź link RSS do strony">&nbsp;<input type="submit" value="Pokaż informacje" name="submit">
				 </form> 
				 <?php //jeśli nie wprowadzimy żandnego linku, domyślnie zostanie wyświetlony przypisany "na sztywno" BBC London news

				 $url = "http://feeds.bbci.co.uk/news/england/london/rss.xml"; //Domyślnie "zasubskrybowany" feed z BBC London
				 if(isset($_POST['submit'])){
				   if($_POST['feedurl'] != ''){
					 $url = $_POST['feedurl'];
				   }
				 }

				 $invalidurl = false; //alt, kiedy wprowadzimy zły adres strony
				 if(@simplexml_load_file($url)){
				  $feeds = simplexml_load_file($url);
				 }else{
				  $invalidurl = true;
				  echo "<h2>Wprowadzony URL jest nieprawidłowy.</h2>";
				 }

				 $i=0;
				 if(!empty($feeds)){

				  $site = $feeds->channel->title;
				  $sitelink = $feeds->channel->link;

				  echo "<h1>".$site."</h1>"; //nazwa strony
				  foreach ($feeds->channel->item as $item) {
					  
				/** ZMIENNE **/

				   $title = $item->title; //Tytuł nagłówka
				   $link = $item->link;
				   $description = $item->description;  //Opis (częściowy)
				   $postDate = $item->pubDate;
				   $pubDate = date('D, d M Y',strtotime($postDate)); //Data publikacji

				   if($i>=9) break; //wyświetlanie maksymalnie 9 artykułów na raz
				  ?>
				   <div class="post">
					 <div class="post-head">
					   <h2><a class="feed_title" href="<?php echo $link; ?>"><?php echo $title; ?></a></h2>
					   <span><?php echo $pubDate; ?></span>
					 </div>
					 <div class="post-content">
					 
					 <!--WYŚWIETLANIE-->
					 
					   <?php echo implode(' ', array_slice(explode(' ', $description), 0, 20)) . "..."; ?> <a href="<?php echo $link; ?>">Czytaj dalej >></a>
					 </div>
				   </div>

				   <?php
					$i++;
				   }
				 }else{
				   if(!$invalidurl){
					 echo "<h2>Nie znaleziono.</h2>";
				   }
				 }
				 ?>
			</div>
		</div>
	</body>
</html>