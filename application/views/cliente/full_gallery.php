<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
<!--
@import url(http://fonts.googleapis.com/css?family=Josefin+Sans+Std+Light);
html,body{height:100%;}
*{outline:none;}
body{margin:0px; padding:0px; background:#000;}
#toolbar{position:fixed; z-index:3; right:10px; top:10px; padding:5px; background:url(../../../fs_img_g_bg.png);}
#toolbar img{border:none;}
#img_title{position:fixed; z-index:3; left:10px; top:10px; padding:10px; background:url(../../../fs_img_g_bg.png); color:#FFF; font-family:'Josefin Sans Std Light', arial, serif; font-size:24px; text-transform:uppercase;}
#bg{position:fixed; z-index:1; overflow:hidden; width:100%; height:100%;}
#bgimg{display:none; -ms-interpolation-mode: bicubic;}
#preloader{position:relative; z-index:3; width:32px; padding:20px; top:80px; margin:auto; background:#000;}
#thumbnails_wrapper{z-index:2; position:fixed; bottom:0; width:100%; background:url(../../../empty.gif); /* stupid ie needs a background value to understand hover area */}
#outer_container{position:relative; padding:0; width:100%; margin:20px auto;}
#outer_container .thumbScroller{position:relative; overflow:hidden; background:url(../../../fs_img_g_bg.png);}
#outer_container .thumbScroller, #outer_container .thumbScroller .container, #outer_container .thumbScroller .content{height:150px;}
#outer_container .thumbScroller .container{position:relative; left:0;}
#outer_container .thumbScroller .content{float:left;}
#outer_container .thumbScroller .content div{margin:5px; height:100%;}
#outer_container .thumbScroller img{border:5px solid #fff;}
#outer_container .thumbScroller .content div a{display:block; padding:5px;}

.nextImageBtn, .prevImageBtn{display:block; position:absolute; width:50px; height:50px; top:50%; margin:-25px 10px 0 10px; z-index:3; filter:alpha(opacity=40); -moz-opacity:0.4; -khtml-opacity:0.4; opacity:0.4;}
.nextImageBtn:hover,.prevImageBtn:hover{filter:alpha(opacity=80); -moz-opacity:0.8; -khtml-opacity:0.8; opacity:0.8;}
.nextImageBtn{right:0; background:#000 url(../../../img/nextImgBtn.png) center center no-repeat;}
.prevImageBtn{background:#000 url(../../../img/prevImgBtn.png) center center no-repeat;}
-->
</style>
<script src="<?php echo base_url() ?>js/jquery/js/jquery-1.7.2.min.js"></script>  

<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.easing.1.3.js"></script>
</head>
<body>
<div id="bg"><a href="#" class="nextImageBtn" title="next"></a><a href="#" class="prevImageBtn" title="previous"></a><img src="<?php echo base_url().$dir['original'].$images[0]['original'] ?>" width="1680" height="1050" alt="" title="" id="bgimg" /></div>
<div id="preloader"><img src="<?php echo base_url() ?>img/ajax-loader_dark.gif" width="32" height="32" /></div>
<div id="img_title"></div>
<div id="toolbar"><a href="#" title="Maximize" onClick="ImageViewMode('full');return false"><img src="<?php echo base_url() ?>img/toolbar_fs_icon.png" width="50" height="50"  /></a></div>
<div id="thumbnails_wrapper">
<div id="outer_container">
<div class="thumbScroller">
	<div class="container">
    
    
   <?php foreach($images as $key => $img) { ?>
   <div class="content">
        	<div><a href="<?php echo base_url().$dir['original'].$img['original']; ?>"><img height="110" src="<?php echo base_url().$dir['thumb'].$img['thumb']; ?>" title="" alt="" class="thumb" /></a></div>
        </div>
        
        <?php } ?>
        
    	
    
    
	</div>
</div>
</div>
</div>
<script>
//config
//set default images view mode
$defaultViewMode="full"; //full, normal, original
$tsMargin=30; //first and last thumbnail margin (for better cursor interaction) 
$scrollEasing=600; //scroll easing amount (0 for no easing) 
$scrollEasingType="easeOutCirc"; //scroll easing type 
$thumbnailsContainerOpacity=0.8; //thumbnails area default opacity
$thumbnailsContainerMouseOutOpacity=0; //thumbnails area opacity on mouse out
$thumbnailsOpacity=0.6; //thumbnails default opacity
$nextPrevBtnsInitState="show"; //next/previous image buttons initial state ("hide" or "show")
$keyboardNavigation="on"; //enable/disable keyboard navigation ("on" or "off")

//cache vars
$thumbnails_wrapper=$("#thumbnails_wrapper");
$outer_container=$("#outer_container");
$thumbScroller=$(".thumbScroller");
$thumbScroller_container=$(".thumbScroller .container");
$thumbScroller_content=$(".thumbScroller .content");
$thumbScroller_thumb=$(".thumbScroller .thumb");
$preloader=$("#preloader");
$toolbar=$("#toolbar");
$toolbar_a=$("#toolbar a");
$bgimg=$("#bgimg");
$img_title=$("#img_title");
$nextImageBtn=$(".nextImageBtn");
$prevImageBtn=$(".prevImageBtn");

$(window).load(function() {
	$toolbar.data("imageViewMode",$defaultViewMode); //default view mode
	if($defaultViewMode=="full"){
		$toolbar_a.html("<img src='<?php echo base_url() ?>img/toolbar_n_icon.png' width='50' height='50'  />").attr("onClick", "ImageViewMode('normal');return false").attr("title", "Restore");
	} else {
		$toolbar_a.html("<img src='<?php echo base_url() ?>img/toolbar_fs_icon.png' width='50' height='50'  />").attr("onClick", "ImageViewMode('full');return false").attr("title", "Maximize");
	}
	ShowHideNextPrev($nextPrevBtnsInitState);
	//thumbnail scroller
	$thumbScroller_container.css("marginLeft",$tsMargin+"px"); //add margin
	sliderLeft=$thumbScroller_container.position().left;
	sliderWidth=$outer_container.width();
	$thumbScroller.css("width",sliderWidth);
	var totalContent=0;
	fadeSpeed=200;
	
	var $the_outer_container=document.getElementById("outer_container");
	var $placement=findPos($the_outer_container);
	
	$thumbScroller_content.each(function () {
		var $this=$(this);
		totalContent+=$this.innerWidth();
		$thumbScroller_container.css("width",totalContent);
		$this.children().children().children(".thumb").fadeTo(fadeSpeed, $thumbnailsOpacity);
	});

	$thumbScroller.mousemove(function(e){
		if($thumbScroller_container.width()>sliderWidth){
	  		var mouseCoords=(e.pageX - $placement[1]);
	  		var mousePercentX=mouseCoords/sliderWidth;
	  		var destX=-((((totalContent+($tsMargin*2))-(sliderWidth))-sliderWidth)*(mousePercentX));
	  		var thePosA=mouseCoords-destX;
	  		var thePosB=destX-mouseCoords;
	  		if(mouseCoords>destX){
		  		$thumbScroller_container.stop().animate({left: -thePosA}, $scrollEasing,$scrollEasingType); //with easing
	  		} else if(mouseCoords<destX){
		  		$thumbScroller_container.stop().animate({left: thePosB}, $scrollEasing,$scrollEasingType); //with easing
	  		} else {
				$thumbScroller_container.stop();  
	  		}
		}
	});

	$thumbnails_wrapper.fadeTo(fadeSpeed, $thumbnailsContainerOpacity);
	$thumbnails_wrapper.hover(
		function(){ //mouse over
			var $this=$(this);
			$this.stop().fadeTo("slow", 1);
		},
		function(){ //mouse out
			var $this=$(this);
			$this.stop().fadeTo("slow", $thumbnailsContainerMouseOutOpacity);
		}
	);

	$thumbScroller_thumb.hover(
		function(){ //mouse over
			var $this=$(this);
			$this.stop().fadeTo(fadeSpeed, 1);
		},
		function(){ //mouse out
			var $this=$(this);
			$this.stop().fadeTo(fadeSpeed, $thumbnailsOpacity);
		}
	);

	//on window resize scale image and reset thumbnail scroller
	$(window).resize(function() {
		FullScreenBackground("#bgimg",$bgimg.data("newImageW"),$bgimg.data("newImageH"));
		$thumbScroller_container.stop().animate({left: sliderLeft}, 400,"easeOutCirc"); 
		var newWidth=$outer_container.width();
		$thumbScroller.css("width",newWidth);
		sliderWidth=newWidth;
		$placement=findPos($the_outer_container);
	});

	//load 1st image
	var the1stImg = new Image();
	the1stImg.onload = CreateDelegate(the1stImg, theNewImg_onload);
	the1stImg.src = $bgimg.attr("src");
	$outer_container.data("nextImage",$(".content").first().next().find("a").attr("href"));
	$outer_container.data("prevImage",$(".content").last().find("a").attr("href"));
});

function BackgroundLoad($this,imageWidth,imageHeight,imgSrc){
	$this.fadeOut("fast",function(){
		$this.attr("src", "").attr("src", imgSrc); //change image source
		FullScreenBackground($this,imageWidth,imageHeight); //scale background image
		$preloader.fadeOut("fast",function(){$this.fadeIn("slow");});
		var imageTitle=$img_title.data("imageTitle");
		if(imageTitle){
			$this.attr("alt", imageTitle).attr("title", imageTitle);
			$img_title.fadeOut("fast",function(){
				$img_title.html(imageTitle).fadeIn();
			});
		} else {
			$img_title.fadeOut("fast",function(){
				$img_title.html($this.attr("title")).fadeIn();
			});
		}
	});
}

//mouseover toolbar
if($toolbar.css("display")!="none"){
	$toolbar.fadeTo("fast", 0.4);
}
$toolbar.hover(
	function(){ //mouse over
		var $this=$(this);
		$this.stop().fadeTo("fast", 1);
	},
	function(){ //mouse out
		var $this=$(this);
		$this.stop().fadeTo("fast", 0.4);
	}
);

//Clicking on thumbnail changes the background image
$("#outer_container a").click(function(event){
	event.preventDefault();
	var $this=$(this);
	GetNextPrevImages($this);
	GetImageTitle($this);
	SwitchImage(this);
	ShowHideNextPrev("show");
}); 

//next/prev images buttons
$nextImageBtn.click(function(event){
	event.preventDefault();
	SwitchImage($outer_container.data("nextImage"));
	var $this=$("#outer_container a[href='"+$outer_container.data("nextImage")+"']");
	GetNextPrevImages($this);
	GetImageTitle($this);
});

$prevImageBtn.click(function(event){
	event.preventDefault();
	SwitchImage($outer_container.data("prevImage"));
	var $this=$("#outer_container a[href='"+$outer_container.data("prevImage")+"']");
	GetNextPrevImages($this);
	GetImageTitle($this);
});

//next/prev images keyboard arrows
if($keyboardNavigation=="on"){
$(document).keydown(function(ev) {
    if(ev.keyCode == 39) { //right arrow
        SwitchImage($outer_container.data("nextImage"));
		var $this=$("#outer_container a[href='"+$outer_container.data("nextImage")+"']");
		GetNextPrevImages($this);
		GetImageTitle($this);
        return false; // don't execute the default action (scrolling or whatever)
    } else if(ev.keyCode == 37) { //left arrow
        SwitchImage($outer_container.data("prevImage"));
		var $this=$("#outer_container a[href='"+$outer_container.data("prevImage")+"']");
		GetNextPrevImages($this);
		GetImageTitle($this);
        return false; // don't execute the default action (scrolling or whatever)
    }
});
}

function ShowHideNextPrev(state){
	if(state=="hide"){
		$nextImageBtn.fadeOut();
		$prevImageBtn.fadeOut();
	} else {
		$nextImageBtn.fadeIn();
		$prevImageBtn.fadeIn();
	}
}

//get image title
function GetImageTitle(elem){
	var title_attr=elem.children("img").attr("title"); //get image title attribute
	$img_title.data("imageTitle", title_attr); //store image title
}

//get next/prev images
function GetNextPrevImages(curr){
	var nextImage=curr.parents(".content").next().find("a").attr("href");
	if(nextImage==null){ //if last image, next is first
		var nextImage=$(".content").first().find("a").attr("href");
	}
	$outer_container.data("nextImage",nextImage);
	var prevImage=curr.parents(".content").prev().find("a").attr("href");
	if(prevImage==null){ //if first image, previous is last
		var prevImage=$(".content").last().find("a").attr("href");
	}
	$outer_container.data("prevImage",prevImage);
}

//switch image
function SwitchImage(img){
	$preloader.fadeIn("fast"); //show preloader
	var theNewImg = new Image();
	theNewImg.onload = CreateDelegate(theNewImg, theNewImg_onload);
	theNewImg.src = img;
}

//get new image dimensions
function CreateDelegate(contextObject, delegateMethod){
	return function(){
		return delegateMethod.apply(contextObject, arguments);
	}
}

//new image on load
function theNewImg_onload(){
	$bgimg.data("newImageW",this.width).data("newImageH",this.height);
	BackgroundLoad($bgimg,this.width,this.height,this.src);
}

//Image scale function
function FullScreenBackground(theItem,imageWidth,imageHeight){
	var winWidth=$(window).width();
	var winHeight=$(window).height();
	if($toolbar.data("imageViewMode")!="original"){ //scale
		var picHeight = imageHeight / imageWidth;
		var picWidth = imageWidth / imageHeight;
		if($toolbar.data("imageViewMode")=="full"){ //fullscreen size image mode
			if ((winHeight / winWidth) < picHeight) {
				$(theItem).attr("width",winWidth);
				$(theItem).attr("height",picHeight*winWidth);
			} else {
				$(theItem).attr("height",winHeight);
				$(theItem).attr("width",picWidth*winHeight);
			};
		} else { //normal size image mode
			if ((winHeight / winWidth) > picHeight) {
				$(theItem).attr("width",winWidth);
				$(theItem).attr("height",picHeight*winWidth);
			} else {
				$(theItem).attr("height",winHeight);
				$(theItem).attr("width",picWidth*winHeight);
			};
		}
		$(theItem).css("margin-left",(winWidth-$(theItem).width())/2);
		$(theItem).css("margin-top",(winHeight-$(theItem).height())/2);
	} else { //no scale
		$(theItem).attr("width",imageWidth);
		$(theItem).attr("height",imageHeight);
		$(theItem).css("margin-left",(winWidth-imageWidth)/2);
		$(theItem).css("margin-top",(winHeight-imageHeight)/2);
	}
}

//Image view mode function - fullscreen or normal size
function ImageViewMode(theMode){
	$toolbar.data("imageViewMode", theMode);
	FullScreenBackground($bgimg,$bgimg.data("newImageW"),$bgimg.data("newImageH"));
	if(theMode=="full"){
		$toolbar_a.html("<img src='<?php echo base_url() ?>img/toolbar_n_icon.png' width='50' height='50'  />").attr("onClick", "ImageViewMode('normal');return false").attr("title", "Restore");
	} else {
		$toolbar_a.html("<img src='<?php echo base_url() ?>img/toolbar_fs_icon.png' width='50' height='50'  />").attr("onClick", "ImageViewMode('full');return false").attr("title", "Maximize");
	}
}

//function to find element Position
	function findPos(obj) {
		var curleft = curtop = 0;
		if (obj.offsetParent) {
			curleft = obj.offsetLeft
			curtop = obj.offsetTop
			while (obj = obj.offsetParent) {
				curleft += obj.offsetLeft
				curtop += obj.offsetTop
			}
		}
		return [curtop, curleft];
	}
</script>
</body>
</html>