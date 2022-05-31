<?php
$pagetitle  = "test";
$sp_locatie = " test";

$tijd = "17:15";
$datum = "1653350400";

echo $datum;
echo "<br>";
echo $tijd;
echo "<br><br><br>";



$datum = date('Y-m-d', $datum);

$fulldate = strtotime($datum. " ".$tijd);


echo "<br><br><br>";

function make_google_calendar_link($name, $begin, $end, $location, $details) {
	$params = array('&dates=', '/', '&details=', '&location=', '&sf=true&output=xml');
	$url = 'https://www.google.com/calendar/render?action=TEMPLATE&text=';
	$arg_list = func_get_args();
    for ($i = 0; $i < count($arg_list); $i++) {
    	$current = $arg_list[$i];
    	if(is_int($current)) {
    		$t = new DateTime('@' . $current, new DateTimeZone('Europe/Brussels'));
    		$current = $t->format('Ymd\THis');
    		unset($t);
    	}
    	else {
    		$current = urlencode($current);
    	}
    	$url .= (string) $current . $params[$i];
    }

    return $url;
}
$gcl = make_google_calendar_link($pagetitle . " | Afspraak", $fulldate, $fulldate, "Afspraak | ".$pagetitle, $sp_locatie);

?>

<?php echo($gcl); ?>
<center style="margin-top:30px;margin-bottom:30px;" >

    <a href="<?php echo($gcl); ?>" target="_blank" style="border-radius: 5px;
    text-decoration: none;
    background-color: #f5f5f5;
    color: #232530;
    padding: 10px 20px;
    font-weight: bold;
    width: 200px;
    margin: 40px 0;
    border: 1px solid #e5e5e5;"><div style="display: inline;
    vertical-align: middle;
    margin-right: 10px;"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Google_Calendar_icon_%282020%29.svg/1024px-Google_Calendar_icon_%282020%29.svg.png" height="16" width="16"/></div> Google Calendar</a>

</center>
    


