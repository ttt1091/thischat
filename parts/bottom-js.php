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

<?php if(isset($_GET['read'])){ ?>
  d.promise()
  .then(function() {
    $(".chat-body").animate({scrollTop:$('#<?= $_GET['read'] ?>').offset().top-104}, { duration: 10, easing: 'swing', });
  });
<?php } else { ?>
  $(".chat-body").animate({scrollTop:$('#lastPostView').offset().top}, { duration: 1000, easing: 'swing', });
<?php } ?>

$('#bottomUpButton').on('click',
  function(){
    $('#postForm').toggleClass("bottom-up");
    $('#postForm').toggleClass("bottom-down");
  }
);
</script>