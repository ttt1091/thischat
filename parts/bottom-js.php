<div id="bottoms"></div>
<script src="<?= $rootWebPath ?>static/js/bootstrap.js"></script>
<script>
$('[data-btn="leftbtn"]').on('click',
  function () {
    $('.left-col').animate({'marginLeft':'300px'},500);
    $('.close-mask').css({'display':'none'}).fadeIn(500);
  }
);
$('[data-btn="rightbtn"]').on('click',
  function () {
    $('.right-col').animate({'marginRight':'300px'},500);
    $('.close-mask').css({'display':'none'}).fadeIn(500);
  }
);

$('.close-mask').on('click',
  function () {
    $('.left-col').animate({'marginLeft':'0px'},500);
    $('.right-col').animate({'marginRight':'0px'},500);
    $('.close-mask').css({'display':'block'}).fadeOut(500);
  }
);


<?php if($_SERVER['SCRIPT_NAME']=='//thechat/login.php'||$_SERVER['SCRIPT_NAME']=='//thechat/thechat.php'||$_SERVER['SCRIPT_NAME']=='/thechat/jobster/index.php'){}else{ ?>

<?php if(isset($_GET['read'])){ ?>
//  d.promise()
//  .then(function() {
//    $(".chat-body").animate({scrollTop:$('#<?= $_GET['read'] ?>').offset().top-104}, { duration: 10, easing: 'swing', });
//  });
$(function(){
	setTimeout(function(){
  $(".chat-body").animate({scrollTop:$('#<?= $_GET['read'] ?>').offset().top-104}, { duration: 10, easing: 'swing', });
},2000);
});
<?php } else { ?>
  $('.chat-body').scrollTop(99999);
<?php } ?>

$('#bottomUpButton').on('click',
  function(){
    $('#postForm').toggleClass("bottom-up");
    $('#postForm').toggleClass("bottom-down");
  }
);
<?php } ?>
</script>

<?php include($rootPath . 'parts/getMessageAjax.php'); ?>