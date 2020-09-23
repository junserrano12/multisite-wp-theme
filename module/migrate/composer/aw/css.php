<?php

/* Display output as html */

if( $data )
{
	extract($data);
	
	$output = "";
	$output .= "body{background:url(".wp_get_attachment_image_src($bodybgimageid, 'full')[0].") $bodybgrepeat $bodybgposition $bodybgscroll $bodybgcolor; font-size:$fontsize; color:$fontcolor; font-family:$fontfamily; } ";
	$output .= "h1{font-family:$h1fontfamily; font-size:$h1fontsize; color:$h1fontcolor;} h2{font-family:$h2fontfamily; font-size:$h2fontsize; color:$h2fontcolor;} h3{font-family:$h3fontfamily; font-size:$h3fontsize; color:$h3fontcolor;} ";
	$output .= "a{color:$fontlinkcolor; } a:hover{color:$fontlinkhovercolor;} ";
	$output .= "#wrapper{background: url(".wp_get_attachment_image_src($wrapperbgimageid, 'full')[0].") $wrapperbgrepeat $wrapperbgposition $wrapperbgscroll $wrapperbgcolor; } ";
	$output .= "#main-container{background: url(".wp_get_attachment_image_src($maincontainerbgimageid, 'full')[0].") $maincontainerbgrepeat $maincontainerbgposition $maincontainerbgscroll $maincontainerbgcolor; padding:$maincontainerpaddingtop $maincontainerpaddingright $maincontainerpaddingbottom $maincontainerpaddingleft; border:$maincontainerborderwidth $maincontainerborderstyle $maincontainerbordercolor; margin:$maincontainerbordermargintop auto $maincontainerbordermarginbottom; border-radius: $maincontainerborderradiustopleft $maincontainerborderradiustopright $maincontainerborderradiusbottomright $maincontainerborderradiusbottomleft; -moz-border-radius: $maincontainerborderradiustopleft $maincontainerborderradiustopright $maincontainerborderradiusbottomright $maincontainerborderradiusbottomleft; -webkit-border-radius: $maincontainerborderradiustopleft $maincontainerborderradiustopright $maincontainerborderradiusbottomright $maincontainerborderradiusbottomleft; } ";
	$output .= "#main-menu li a{padding:$headernavpaddingtop $headernavpaddingright $headernavpaddingbottom $headernavpaddingleft; margin:$headernavmargintop auto $headernavmarginbottom auto; border:$headernavborderwidth $headernavborderstyle $headernavbordercolor; background:url(".wp_get_attachment_image_src($headernavbgimageid, 'full')[0].") repeat 0 0 $headernavbgcolor; color:$headernavfontcolor; font-size:$headernavfontsize; font-family:$headernavfontfamily; -moz-border-radius: $headernavborderradiustopleft $headernavborderradiustopright $headernavborderradiusbottomright $headernavborderradiusbottomleft; -webkit-border-radius: $headernavborderradiustopleft $headernavborderradiustopright $headernavborderradiusbottomright $headernavborderradiusbottomleft; border-radius: $headernavborderradiustopleft $headernavborderradiustopright $headernavborderradiusbottomright $headernavborderradiusbottomleft;} ";
	$output .= "#main-menu li a:hover{background-color:$headernavbghovercolor; background-position:$headernavbghoverposition; color:$headernavfonthovercolor; text-decoration:$headernavtextdecoration;} ";
	$output .= "#main-menu li.current-menu-item a{background-color:$headernavbgactivecolor; background-position:$headernavbgactiveposition; color:$headernavfontactivecolor;} ";
	$output .= "#primary-main .post, #primary-main .page{background:url(".wp_get_attachment_image_src($entrybgimageid, 'full')[0].") $entrybgrepeat $entrybgposition $entrybgscroll $entrybgcolor; padding:$entrypaddingtop $entrypaddingright $entrypaddingbottom $entrypaddingleft; border:$entryborderwidth $entryborderstyle $entrybordercolor; margin-top:$entrymargintop; border-radius: $entryborderradiustopleft $entryborderradiustopright $entryborderradiusbottomright $entryborderradiusbottomleft; -moz-border-radius: $entryborderradiustopleft $entryborderradiustopright $entryborderradiusbottomright $entryborderradiusbottomleft; -webkit-border-radius: $entryborderradiustopleft $entryborderradiustopright $entryborderradiusbottomright $entryborderradiusbottomleft; } ";
	$output .= "#sidebar{position:$sidebarposition; background:url(".wp_get_attachment_image_src($sidebarbgimageid, 'full')[0].") $sidebarbgrepeat $sidebarbgposition $sidebarbgscroll $sidebarbgcolor; border:$sidebarborderwidth $sidebarborderstyle $sidebarbordercolor; border-radius: $sidebarborderradiustopleft $sidebarborderradiustopright $sidebarborderradiusbottomright $sidebarborderradiusbottomleft; -moz-border-radius: $sidebarborderradiustopleft $sidebarborderradiustopright $sidebarborderradiusbottomright $sidebarborderradiusbottomleft; -webkit-border-radius: $sidebarborderradiustopleft $sidebarborderradiustopright $sidebarborderradiusbottomright $sidebarborderradiusbottomleft; margin-top:$sidebarmargintop} ";
	$output .= "#sidebar-container{padding:$sidebarpaddingtop $sidebarpaddingright $sidebarpaddingbottom $sidebarpaddingleft;} ";
	$output .= "#cta-container{color:$ctacontainerfontcolor; background:"."url(".wp_get_attachment_image_src($ctacontainerbgimageid, 'full')[0].")"." $ctacontainerbgrepeat $ctacontainerbgposition $ctacontainerbgscroll $ctacontainerbgcolor; margin:$ctacontainermargintop $ctacontainermarginright $ctacontainermarginbottom $ctacontainermarginleft; padding:$ctacontainerpaddingtop $ctacontainerpaddingright $ctacontainerpaddingbottom $ctacontainerpaddingleft; border:$ctacontainerborderwidth $ctacontainerborderstyle $ctacontainerbordercolor; border-radius: $ctacontainerborderradiustopleft $ctacontainerborderradiustopright $ctacontainerborderradiusbottomright $ctacontainerborderradiusbottomleft; -moz-border-radius: $ctacontainerborderradiustopleft $ctacontainerborderradiustopright $ctacontainerborderradiusbottomright $ctacontainerborderradiusbottomleft; -webkit-border-radius: $ctacontainerborderradiustopleft $ctacontainerborderradiustopright $ctacontainerborderradiusbottomright $ctacontainerborderradiusbottomleft;} ";
	$output .= ".cta{margin:$ctamargintop 0 $ctamarginbottom 0;} ";
	$output .= ".cta .button{color:$ctabuttonfontcolor;} .cta .button:hover{color:$ctabuttonhoverfontcolor;} ";
	$output .= ".ctalink{color:$ctalinkfontcolor;} .ctalink:hover{color:$ctalinkhoverfontcolor;} ";
	$output .= ".image-container{border:$imageborderwidth $imageborderstyle $imagebordercolor; background:$imagebgcolor; padding:$imagepaddingtop $imagepaddingright $imagepaddingbottom $imagepaddingright; border-radius: $imageborderradiustopleft $imageborderradiustopright $imageborderradiusbottomright $imageborderradiusbottomleft; -moz-border-radius: $imageborderradiustopleft $imageborderradiustopright $imageborderradiusbottomright $imageborderradiusbottomleft; -webkit-border-radius: $imageborderradiustopleft $imageborderradiustopright $imageborderradiusbottomright $imageborderradiusbottomleft; } ";
	$output .= ".image-container img{ border-radius: $imageborderradiustopleft $imageborderradiustopright $imageborderradiusbottomright $imageborderradiusbottomleft; -moz-border-radius: $imageborderradiustopleft $imageborderradiustopright $imageborderradiusbottomright $imageborderradiusbottomleft; -webkit-border-radius: $imageborderradiustopleft $imageborderradiustopright $imageborderradiusbottomright $imageborderradiusbottomleft; } ";
	$output .= ".slider-image-container{border:$sliderimageborderwidth $sliderimageborderstyle $sliderimagebordercolor; background:$sliderimagebgcolor; padding:$sliderimagepaddingtop $sliderimagepaddingright $sliderimagepaddingbottom $sliderimagepaddingright; border-radius: $sliderimageborderradiustopleft $sliderimageborderradiustopright $sliderimageborderradiusbottomright $sliderimageborderradiusbottomleft; -moz-border-radius: $sliderimageborderradiustopleft $sliderimageborderradiustopright $sliderimageborderradiusbottomright $sliderimageborderradiusbottomleft; -webkit-border-radius: $sliderimageborderradiustopleft $sliderimageborderradiustopright $sliderimageborderradiusbottomright $sliderimageborderradiusbottomleft; } ";
	$output .= ".slider-image-container img{ border-radius: $sliderimageborderradiustopleft $sliderimageborderradiustopright $sliderimageborderradiusbottomright $sliderimageborderradiusbottomleft; -moz-border-radius: $sliderimageborderradiustopleft $sliderimageborderradiustopright $sliderimageborderradiusbottomright $sliderimageborderradiusbottomleft; -webkit-border-radius: $sliderimageborderradiustopleft $sliderimageborderradiustopright $sliderimageborderradiusbottomright $sliderimageborderradiusbottomleft; } ";
	$output .= ".slider-image-caption{background:$slidercaptionbgcolor; color:$slidercaptioncolor; text-align:$slidercaptiontextalign;} ";
	$output .= ".bpg{width:$bpgwidth;} ";
	$output .= "#bpgtipcontent{background:$bpgbgcolor; color:$bpgcolor;} ";
	$output .= "#bpgtipcontent:after{border-color:transparent $bpgbgcolor transparent transparent;} ";
	$output .= "#logo-container{margin:$logomargintop 0 $logomarginbottom 0;}";
	$output .= "#footer{background:url(". wp_get_attachment_image_src($footerbgimageid, 'full')[0] .") $footerbgrepeat $footerbgposition $footerbgscroll $footerbgcolor; height:$footerheight; color:$footerfontcolor;}";
	$output .= "#footer a{color:$footerlinkfontcolor;} ";
	$output .= "#footer-container{background:url(". wp_get_attachment_image_src($footercontainerbgimageid, 'full')[0] .") $footercontainerbgrepeat $footercontainerbgposition $footercontainerbgscroll $footercontainerbgcolor; top:$footercontainertop;}";
	$output .= "#header{background:url(". wp_get_attachment_image_src($headerbgimageid, 'full')[0] .") $headerbgrepeat $headerbgposition $headerbgscroll $headerbgcolor; height:$headerheight;}";
	$output .= "#header-container{background:url(". wp_get_attachment_image_src($headercontainerbgimageid, 'full')[0] .") $headercontainerbgrepeat $headercontainerbgposition $headercontainerbgscroll $headercontainerbgcolor; top:$headercontainertop; padding:$headercontainerpaddingtop $headercontainerpaddingright $headercontainerpaddingbottom $headercontainerpaddingleft;}";
	$output .= "@media (max-width:570px) { #bpgtipcontent:after{border-color:transparent transparent $bpgbgcolor transparent;} }";
	
	return $output;


}




?>