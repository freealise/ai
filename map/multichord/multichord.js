<script type="text/javascript">
function logo() {
	var colors = ["#ff0000", "#ff9900", "#ffff00", "#99ff00", "#00ff00", "#00ff99", "#00ffff", "#0099ff", "#0000ff", "#9900ff", "#ff00ff", "#ff0099"];
	var x;
	for (x=1; x<=12; x++) {
		document.write("<hr width=36 color='" + colors[x-1] + "' style='position:absolute;left:10px;top:" + (50-Math.log2(x)*10) + "px'>");
	}
}
</script>

<script type="text/javascript">
  var y, i, c;
  c=Math.pow(2, 1/(12*12));
  document.write('<svg height="5000" width="500">');
  y = 5000; 					//fretboard length
  							//frets_per_octave*smallfrets_per_fret*octaves
  for (i=0; i<12*12*4; i++) {
  	document.write('<line x1="0" x2="200" y1="' + y + '" y2="' + y + '" style="stroke:rgb(255,0,0);stroke-width:1" />');
    y=y/c;
  }
  document.write('</svg>');
</script>