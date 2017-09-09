<?php
//TODO:
//do styling through XSLT, just include XML in here
//one main site (Freealise) and subsites that can be added
//Database<->XML
//Not comments but posts that link to each other, like a wiki, but in realtime.
//Donate button on site, default sum of donation, recurring donation
//Q&A section
//Reflect the brand and sub-brands with Freealise banner on each site and list of projects on Freealise.
//Featured Articles as infographics.
//Web-based version with no registration (Multichord). First let try, then ask for money!

//get the q parameter from URL
$site=$_SERVER['SERVER_NAME'];
if ($_GET["p"]) {$p=$_GET["p"];} else {$p="page"; $n=0;}

//find out which site was selected
if ($_GET["s"]) {$site=$_GET["s"];}
else {
    $s=explode(".", $site);
    if ($s[0]=="me" || $s[0]=="m-goritskaia" || $s[1]=="freeali") {$site="me";}
	else {$site=$s[1];}
}

$css=($site."/".$site.".css");
$xml=($site."/".$site.".xml");
$logo=($site."/".$site.".png");
$js=($site."/".$site.".js");

$xmlDoc = new DOMDocument();
$xmlDoc->load($xml);

//get elements from "<channel>"
$channel=$xmlDoc->getElementsByTagName('channel')->item(0);
$c['title'] = $channel->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
$c['link'] = $channel->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
$c['desc'] = $channel->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
$c['keyw'] = $channel->getElementsByTagName('keywords')->item(0)->childNodes->item(0)->nodeValue;
?>

<html>
<head>
	<meta name="description" content="<?php echo $c['desc']; ?>">
	<meta name="keywords" content="<?php echo $c['keyw']; ?>">
	<meta name="author" content="Marina Goritskaia">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<base href="https://m-goritskaia.rhcloud.com/map/"> <?php //echo $site; ?>
	<title><?php echo $c['title']; ?></title>
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
	<link rel="stylesheet" href="<?php echo $css;?>">
	<link rel="alternate" type="application/rss+xml" href="<?php echo $xml;?>" title="<?php echo $c['title']; ?>">
	<script src="index.js"></script>
  <script src="<?php echo $js;?>"></script>
  <script>
    function showRSS(str) {
      if (str.length==0) {
        document.getElementById("rssOutput").innerHTML="";
        return;
      }
      if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      } else {  // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
          document.getElementById("rssOutput").innerHTML=this.responseText;
        }
      }
      xmlhttp.open("GET","getrss.php?q="+str,true);
      xmlhttp.send();
    }
    
    function keywords(keyword) {
      document.getElementById('keywords').value=document.getElementById('keywords').value + keyword + ', ';
    }
  </script>
</head>
<body>
	<div id="main">
		<div id="header">
			<div id="title">
                <?php echo "<a href='" . $c['link'] . "'><img id='logo' src='" . $logo . "' alt='" . $site . "'><span>" . $c['title'] . "</span></a><br>"; ?>
				<span id="des">
					<?php echo $c['desc']; ?>
				</span>
			</div><br>
			<a id="support" href="">$€£</a>
			<div id="follow">
				<?php
				$x=$xmlDoc->getElementsByTagName('sn');
				$fb=$x->item(0)->getElementsByTagName('facebook')->item(0)->childNodes->item(0)->nodeValue;
				$tw=$x->item(0)->getElementsByTagName('twitter')->item(0)->childNodes->item(0)->nodeValue;
				?>
				<div>
					<a href="<?php echo $fb;?>" target="_blank">fb</a>
					<a href="<?php echo $tw;?>" target="_blank">tw</a>
					<a id="rss" href="<?php echo $xml;?>" target="_blank">rss</a>
					<a id="subscribe" href="">sub</a>
				</div>
			</div>
		</div>
		<div id="links">
      <?php
      $x=$xmlDoc->getElementsByTagName('page');
			$posts=4;
			for ($i=0; $i<$posts; $i++) {
				if ($x->item($i)) {
					$item['title']=$x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
					$item['link']=$x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
					$item_desc=$x->item($i)->getElementsByTagName('description')->item(0);
					$item['desc']=$item_desc->ownerDocument->saveHTML($item_desc);
                    echo ("<a href='?p=page&n=" . $i . "'>" . $item['title'] . "</a>");
				} else {break;}
			}
            ?>
		</div>
		<div id="map"></div>
		<!--<script src="js_config.js"></script>
		<script src="js_functions.js"></script>-->
		<div id="newpost">
		</div>
		<div id="content">
			<?php
			$x=$xmlDoc->getElementsByTagName($p);
			if ($_GET["n"]) {$n=$_GET["n"];}
			else {$n=0;}
			if ($x->item($n)) {
				$item['title']=$x->item($n)->getElementsByTagName('title')->item(0)->nodeValue;
				$item['link']=$x->item($n)->getElementsByTagName('link')->item(0)->nodeValue;
				$item_desc=$x->item($n)->getElementsByTagName('description')->item(0);
				$item['desc']=$item_desc->ownerDocument->saveHTML($item_desc);
			} else {echo "No such page. Maybe the URL is wrong.";}
			?>
			<div id="p_title">
                <?php if ($item['title']!="Home") {echo $item['title'];} ?>
			</div>
			<div id="p_des">
				<p><?php echo $item['desc']; ?></p>
			</div>
			<div id="nav">
			  <div id="search">
  			  <script>
            (function() {
              var cx = '012028642072992676584:-oftupfelow';
              var gcse = document.createElement('script');
              gcse.type = 'text/javascript';
              gcse.async = true;
              gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
              var s = document.getElementsByTagName('script')[0];
              s.parentNode.insertBefore(gcse, s);
            })();
          </script>
          <gcse:search></gcse:search>
        </div>
        <div id="tags">
          Tags
          <form><input type=text id="keywords"><input type=submit></form>
          <?php
      		$x=$xmlDoc->getElementsByTagName('item');
      		$item_keywords=array();
      		$keywords=array();
          for ($i=0; $i<$x->length; $i++) {
            $item[$i]=$x->item($i);
            $item['keywords'] = $item[$i]->getElementsByTagName('keywords')->item(0)->childNodes->item(0)->nodeValue;
            $item_keywords=explode(", ", $item['keywords']);
            for ($j=0; $j<count($item_keywords); $j++) {
              array_push($keywords, $item_keywords[$j]);
            }
          }
          $item_keywords=array();
          $keyword_exists=false;
          for ($i=0; $i<count($keywords); $i++) {
            for ($j=0; $j<count($item_keywords); $j++) {
              if ($item_keywords[$j] == $keywords[$i]) {$keyword_exists=true; break;}
            }
            if ($keyword_exists==false) {
              echo ("<span><a onclick=keywords('" . $keywords[$i] . "');>" . $keywords[$i] . "</a>&nbsp;</span>");
              array_push($item_keywords, $keywords[$i]);
            } else {$keyword_exists=false;}
          }
          ?>
        </div>
		  </div>
			<div id="articles">
        Featured Articles
          <?php
            $x=$xmlDoc->getElementsByTagName('article');
			      $posts=4;
			      for ($i=0; $i<0+$posts; $i++) {
				      if ($x->item($i)) {
      					$item['title']=$x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
      					$item['link']=$x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
      					$item_desc=$x->item($i)->getElementsByTagName('description')->item(0);
      					$item['desc']=$item_desc->ownerDocument->saveHTML($item_desc);
                echo ("<div><a href='?p=article&n=" . $i . "'>" . $item['title'] . "</a></div>");
				      } else {break;}
			      }
          ?>
		  </div>
		  <div id="blog">
			<?php
			if ($n!=3) {
  			//get and output "<item>" elements
  			$x=$xmlDoc->getElementsByTagName('item');
  			if ($_GET["posts"]) {$posts=$_GET["posts"];}
  			else {$posts=7;}
  			if ($_GET["start"]) {$start=$_GET["start"];}
  			else {$start=0;}
  			for ($i=$start; $i<$start+$posts; $i++) {
  				if ($x->item($i)) {
  					$item['title']=$x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
  					$item['link']=$x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
  					$item_desc=$x->item($i)->getElementsByTagName('description')->item(0);
  					$item['desc']=$item_desc->ownerDocument->saveHTML($item_desc);
  					echo ("<div><a href='?p=item&n=" . $i . "'>" . $item['title'] . "</a><br/>" . $item['desc'] . "</div><br/>");
  				} else {break;}
  			}
  			if ($x->item($start-1)) {
  				$back=$start-$posts;
  				echo ("| <a href='?p=" . $p . "&posts=" . $posts . "&start=" . $back . "'><b> Back </b></a> | ");
  			}
  			if ($x->item($i)) {
  				$start=$start+$posts;
  				echo ("| <a href='?p=" . $p . "&posts=" . $posts . "&start=" . $start . "'><b> More </b></a> |");
  			}
			} else {
    		$x=$xmlDoc->getElementsByTagName('links');
        for ($i=0; $i<$x->length; $i++) {
          $links[$i]=$x->item($i);
          $l['title'] = $links[$i]->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
          $l['link'] = $links[$i]->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
          $l['desc'] = $links[$i]->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
          //$l['xml'] = $links[$i]->getElementsByTagName('xml')->item(0)->childNodes->item(0)->nodeValue;
          echo ("<p><a href='" . $l['link'] . "'>" . $l['title'] . "</a><br>" . $l['desc'] . "</p>");
        }
			}
			?>
			<?php //include("posts.php"); ?>
		  </div>
		</div>
		<div id="rssOutput">
		</div>
	</div>
</body>
</html>