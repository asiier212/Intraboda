<div class="main">
    <h2>
        Galeria
    </h2>

    <style type="text/css">

    #container {
        margin: 0 auto;
        margin-top:30px;
        width: 900px;
    }
    #imgshow {
        float: left;
        width: 500px;
    }
    .imgdet {
        border:1px solid #e3e3e3;
        padding:2px;
    }
    #imglist {
        float: right;
        width: 350px;
    }
    .imgfor {
        border: 1px solid #e3e3e3;
        padding: 10px 0;
    }
    #fupload {
        margin: 0;
        border: 1px solid #e3e3e3;
        padding: 10px 0;
        text-align: center;
        margin-bottom: 10px;
    }
    .btnupload {
        border: 1px solid #e3e3e3;
        background: #f3f3f3;
        font-size: 11px;
        font-weight: bold;
        padding: 2px 5px;
    }
    .imgbox {
        text-align: center;
        width: 150px;
        height: 150px;
        float: left;
        margin: 0 0 15px 10px;
    }
    .thumb {
        border:1px solid #fff;
        padding:2px;
    }
    .thumb:hover {
        border-color: #0066cc;
    }
    .thumbclick {
        border:1px solid #0066ff;;
        padding:2px;
    }
    .dadel {
        margin-top: 2px;
    }
    .adel {
        color: #0066cc;
        font-size: 11px;
    }
    .adel:hover {
        background: #ff0000;
        color:#fff;
        text-decoration: none;
    }
    .clear {
        clear: both;
    }
    .error p {
        font-size: 11px;
        color: #ff0000;
        margin: 0;
        padding: 10px 0 0 0;
    }
    .bottom {
        color: #666;
        font-weight: bold;
        font-size: 11px;
        text-align: center;
        border: 1px solid #e3e3e3;
        padding: 10px;
        margin-top: 10px;
    }
    .bottom a {
        color: #0066cc;
        font-size: 14px;
    }
    .bottom a:hover {
        text-decoration: none;
        color:#fff;
        background: #0066cc;
    }
    </style>
    <script type="text/javascript">
        function changepic(img_src, obj) {
            document["img_tag"].src = img_src;
            var thumbs = document.getElementsByName("thumb");
            for (var i = 0; i < thumbs.length; i++) {
                var tmp_id = "thumb_" + i;
                document.getElementById(tmp_id).setAttribute("class", "thumb");
            }
            document.getElementById(obj).setAttribute("class", "thumbclick");
            var ori_img = img_src.replace("thumb_", "");
            document.getElementById("detimglink").setAttribute("href", ori_img);
        }
    </script>


<div id="container">
    <div id="imgshow">
        <?php if (isset($images[0])) { ?>
        <a href="<?php echo base_url().$dir['original'].$images[0]['original']; ?>" target="_blank" id="detimglink">
            <img class="imgdet" name="img_tag" src="<?php echo base_url().$dir['original'].$images[0]['original']; ?>" width="500"/>
        </a>
        <?php } ?>
    </div>

    <div id="imglist">
        <form enctype="multipart/form-data" id="fupload" method="post">
            <input name="userfile" type="file" size="20"/>
            <input type="submit" name="btn_upload" value="Upload &uarr;" class="btnupload"/>
            <?php if (isset ($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
            <?php } ?>
        </form>
        
        <div class="clear"></div>

        <div class="imgfor">
        <!-- Looping Array Image -->
        <?php foreach($images as $key => $img) { ?>
        <div class="imgbox">
            <div>
                <a href="javascript:" onclick="changepic('<?php echo base_url().$dir['original'].$img['original']; ?>', 'thumb_<?php echo $key; ?>');">
                <img class="thumb" name="thumb" id="thumb_<?php echo $key; ?>" src="<?php echo base_url().$dir['thumb'].$img['thumb']; ?>"/>
                </a>
            </div>
            <div class="dadel">
            <a class="adel" href="<?php echo base_url().'cliente/delete/'.$id.'/'.$img['original']; ?>">
                Borrar
            </a>
            </div>
        </div>
        <?php } ?>
        
        <div class="clear"></div>
       	
        </div>
        <div class="clear"></div>

        <div class="bottom">
            <?php echo $total; ?> Image(s)
        </div>

        <div class="bottom">
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>

    <div class="clear"></div>

</div> <!-- end div container -->
 </div>
<div class="clear"></div>