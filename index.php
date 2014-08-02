<?php
	require("functions.php");
	/*
	 * LIST OF SITES USED
	 * http://www.leukespreuk.nl/special_versierzinnen.htm
	 *
	 * DOCUMENTATION:
	 * https://gist.github.com/rtt/10403467
	 */
	
	$autoLike = false;
	
	// some list with dutch pickup lines
	$pickuplines = array(
		"Heb jij een abonnement op mooier worden?",
		"Als een ster zo ver weg staat, hoe kan jij dan zo dichtbij komen?",
		"Hoi, ik ben een dief en ik ben hier om je hart te stelen.",
		"Je vader heeft vast een snoepwinkel… je ziet eruit om op te eten…",
		"Als de enige plaats waar ik je zou kunnen zien, in mijn dromen was, dan zou ik voor eeuwig slapen...",
		"Ik heb een zwemdiploma , maar in jou ogen verdrink ik toch.",
		"Ik kreeg net een telefoontje uit de hemel: ze missen een engel; rustig maar, ik heb je niet verraden.",
		"Als je me niet ziet zitten, ga ik wel staan.",
		"Bij welke wedstrijd kan ik jou winnen? Ik wil jou wel als mijn hoofdprijs.",
		"Weet je wat raar is? Ik kan niet vliegen en ben toch in de wolken.",
		"Slaap jij op je buik? Nee? Mag ik er dan op slapen?",
		"Heb je een pleister? Mijn been ligt open van toen ik voor je viel.",
		"Als jouw hart een cel is, wil ik levenslang",
		"Mag ik je foto, dan weet Sinterklaas precies wat hij me moet geven.",
		"Ik ben mijn telefoonnummer kwijt. Mag ik het jouwe?",
		"Ik heb mijn teddybeer verloren, dus wil jij vannacht bij me slapen?",
		"Wie niet waagt blijft maagd.",
		"Is jouw vader timmerman, want je hebt een mooie voorgevel",
		"Ik weet een goede openings zin, maar jij heb een opening, en ik heb zin.",
		"Die rook boven je hoofd, is die van een sigaret of ben je zo heet?",
		"Ik hou niet van regen, maar wel van spetters",
		"Ik ben erg verlegen, kun jij het gesprek niet beginnen?",
		"Als een ster zo ver weg staat, hoe kan jij dan zo dicht bij komen?",
		"Waarom ken ik jou niet ergens van?",
		"Gelukkig heb ik mijn zwemdiploma behaald, anders verdronk ik in je mooie ogen.",
		"Jij bent de reden waarom God de vrouw heeft geschapen",
		"Hoe duur is zo'n BH? Hoezo? Ik wil je borsten wel gratis de hele avond vasthouden hoor",
		"Sex is niet het antwoord. Sex is de vraag en ja is het anwoord",
		"Mijn hobby is puzzelen en jij bent mijn laatste stukje",
		"Er zijn honderden openingszinnen, maar als jij nou eens zegt welke bij jou werkt",
		"Jouw vader is vast een dief? Dat hij alle sterren heeft gestolen en ze in je ogen heeft verstopt",
		"Ben jij niet moe? Je loopt al uren rondjes in mijn gedachten.",
		"Ik wou dat ik een traan was, geboren worden in je ogen, leven op je wangen en sterven op je lippen.",
		"Geloof je in liefde op het eerste gezicht, of moet ik nog een keer langslopen?",
		"Herinner je mij niet? Oh nee, dat iswaar ook, ik heb je alleen in mijn dromen ontmoet.",
		"Hebben ze jou net uit de oven gehaald? Want jij bent heet!",
		"Je lijkt heel erg op mijn toekomstige vrouw...",
		"Als jij de boom zou zijn, zou ik je omarmen als een Koala beertje.",
		"Wat wil je voor ontbijt?",
		"Kan ik een kwartje lenen? Ik wil mijn moeder bellen om te vertellen dat ik net het meisje van mijn dromen heb ontmoet.",
		"D'r is vast iets mis met mijn ogen, want ik kan ze niet van je afhouden.",
		"Kun je me de richting wijzen... naar je hart?"
	);
?>
<!DOCTYPE html>
<html>
<head>
<title>Tinder API TEST</title>
<meta charset="utf-8">
<style type="text/css">

	body
	{
		background-color: #E8E8E8;
	}
	
	#container
	{
		width: 840px;
		margin-left: auto;
		margin-right: auto;
	}
	
	.infoboxnormal
	{
		width: 200px;
		height: 300px;
		background-color: #ffffff;
		-webkit-box-shadow: 0 5px 5px 0 rgba(0,0,0,.25);
		box-shadow: 0 5px 5px 0 rgba(0,0,0,.25);
		margin: 5px;
		padding: 5px;
		box-sizing: border-box;
		float: left;
	}
	
	.infoboxmatch
	{
		width: 200px;
		height: 300px;
		background-color: #53BF00;
		-webkit-box-shadow: 0 5px 5px 0 rgba(0,0,0,.25);
		box-shadow: 0 5px 5px 0 rgba(0,0,0,.25);
		margin: 5px;
		padding: 5px;
		box-sizing: border-box;
		float: left;
	}

</style>

<script type='text/javascript'>
function mouseOver(id){
	//whatever you want
	
	
}
</script>

</head>

<body>

<div id='container'>

<?php
	
	$yourToken = $_GET['token'];
	
	$api_url = "https://api.gotinder.com/";
	$header = array('Content-Type: application/json; charset=utf-8', 'User-Agent: Tinder/4.0.4 (iPhone; iOS 7.0.4; Scale/2.00)');
	
	$data = array("facebook_token" => $yourToken, "facebook_id" => "");
	
	$info = PostRequest($api_url."auth", $header, $data);
	$decode = json_decode($info, true);
	
	$userid = $decode['user']['_id'];
	$token = $decode['token'];
	
	$valids = array('Authentication: Token token="'.$token.'"', 'X-Auth-Token: '.$token);
	$headers = array_merge($header, $valids);
	
	$info = GetRequest($api_url."user/recs", $headers);
	$decoded = json_decode($info, true);
	
	if(!array_key_exists('error', $decoded))
	{
		$matches = $decoded['results'];
		for($i = 0; $i < count($matches); $i++)
		{
			$distance = round($matches[$i]['distance_mi'] / 0.621371192);
			
			if($autoLike)
			{
				$liking = GetRequest($api_url."like/".$matches[$i]['_id'], $headers);
				$likedecode = json_decode($liking, true);
				echo ($likeddecode['match'])?"<div class='infoboxmatch'>":"<div class='infoboxnormal'>";
			}
			else
			{
				if(strlen($matches[$i]['bio']) > 70)
					echo "<div class='infoboxnormal' style='overflow-y: scroll;' onMouseOver='mouseOver($i)'>";
				else
					echo "<div class='infoboxnormal' onMouseOver='mouseOver($i)'>";
			}
			
			
			echo "<img src='".$matches[$i]['photos'][0]['processedFiles'][0]['url']."' width='100%' />";
			echo "<b>".$matches[$i]['name']." - ".$distance."km</b><br/>";
			echo "<span>".$matches[$i]['bio']."</span>";
			echo "</div>";
			
			// send a standard pickupline if you're matched
			if($likeddecode['match'])
			{
				$message = array("message" => $pickuplines[rand(0, count($pickuplines))]);
				$sendMessage = PostRequest($api_url."user/matches/".$matches[$i]['_id'], $headers, $message);
				$messageAnswer = json_decode($sendMessage, true);
				
				if($messageAnswer['status'] != 500)
				{
					// success
					echo "Message sent.";
				}
			}
		}
	}
	else
	{
		echo "<h1>There's an error.</h1>";
	}
?>

<input type="button" value="Reload" onclick="location.reload(true)" /><br/>

</div>

</body>
</html>
