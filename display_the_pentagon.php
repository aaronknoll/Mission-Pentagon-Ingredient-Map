/*
Plugin Name: Pentagon Rating Tool
Plugin URI: http://theginisin.com/projectpentagon
Description: A plugin which allows posts to be rated in 5 categories on a scale of 1-3
Version: 0.5
Author: Aaron Knoll
Author URI: http://aaronknoll.com
License: GPL
*/

//this file contains the SVG output. Because it is all style based logic,
//it makes more sense to include it in this seperate file. 

//this is included in Pentagon.php and requires the variable "Pentarray"
// to be filled with all 5 values in each of the 3 aspects. 

//The words are NOT rotated:
<text x = "125" y = "85" fill = "navy" font-size = "10"><?php echo $pentarray[name][1]; ?></text>
<text x = "85" y = "65" fill = "navy" font-size = "10"><?php echo $pentarray[name][2]; ?></text>
<text x = "165" y = "65" fill = "navy" font-size = "10"><?php echo $pentarray[name][3]; ?></text>
<text x = "160" y = "20" fill = "navy" font-size = "10"><?php echo $pentarray[name][4]; ?></text>
<text x = "90" y = "20" fill = "navy" font-size = "10"><?php echo $pentarray[name][5]; ?></text> 

//the same triangular polygon is rotated 5 times to come up
// with the complete geometric figure....
// so we'll run this through a for loop

//NOTE: 360 / 72 = 5 :: we increase the variable $rotatedegrees + 72 each iteration


<svg id="svgelem" height="700" xmlns="http://www.w3.org/2000/svg">



 <polygon Stroke="#000" points="39.38,42.4 17.24,71.42 61.98,71.42" fill="#FFAB07"/>
 <polygon Stroke="#000" points="39.38,42.4 25.04,61.6 54.18,61.6" fill="#FFAB07" />
 <polygon Stroke="#000"  points="39.38,42.4 32.46,51.72, 47.76,51.72" fill="#FFAB07" />

<g transform="rotate(72,39.38,42.4)" >
 <polygon Stroke="#000" points="39.38,42.4 17.24,71.42 61.98,71.42" fill="#E9D558"  />
 <polygon Stroke="#000" points="39.38,42.4 25.04,61.6 54.18,61.6" fill="#E9D558" />
 <polygon Stroke="#000"  points="39.38,42.4 32.46,51.72, 47.76,51.72" fill="E9D558" />
</g>

<g transform="rotate(144,39.38,42.4)" >
 <polygon Stroke="#000" points="39.38,42.4 17.24,71.42 61.98,71.42" fill="#72AD75" />
 <polygon Stroke="#000" points="39.38,42.4 25.04,61.6 54.18,61.6" fill="#72AD75" />
 <polygon Stroke="#000"  points="39.38,42.4 32.46,51.72, 47.76,51.72" fill="#72AD75" />
</g>

<g transform="rotate(288,39.38,42.4)" >
 <polygon Stroke="#000" points="39.38,42.4 17.24,71.42 61.98,71.42" fill="#0E8D94" />
 <polygon Stroke="#000" points="39.38,42.4 25.04,61.6 54.18,61.6" fill="#0E8D94" />
 <polygon Stroke="#000"  points="39.38,42.4 32.46,51.72, 47.76,51.72" fill="#0E8D94" />
</g>

<g transform="rotate(216,39.38,42.4)" >
 <polygon Stroke="#000" points="39.38,42.4 17.24,71.42 61.98,71.42" fill="#434D53" />
 <polygon Stroke="#000" points="39.38,42.4 25.04,61.6 54.18,61.6" fill="#434D53" />
 <polygon Stroke="#000"  points="39.38,42.4 32.46,51.72, 47.76,51.72" fill="#434D53" />
</g>
</svg>