<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Valentine's day contest 2017 showcase your valentine moments online in a storyboard.">
  <meta name="keyword" content="Valentine storyboard, Valentine day experience, Valentine day special, Valentine day moments">
  <title>Valentine day contest 2017, Showcase your valentine moments online | Indiashopps.com</title>
  <link rel="stylesheet" href="<?php echo asset("contest/storyboard/css/bootstrap.css") ?>">
  <link rel="stylesheet" href="<?php echo asset("contest/storyboard/css/style.css") ?>">
  <link rel="shortcut icon" href="<?php echo asset("contest/storyboard/images/faviconindia.png") ?>">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel="stylesheet" type='text/css'>
  <link href="<?php echo asset("contest/storyboard/css/font-awesome.css") ?>" rel="stylesheet">
  <script src="<?php echo asset("contest/valentine/js/banner/jquery.min.js")?>"></script>
  <script type="text/javascript" src="//connect.facebook.net/en_US/sdk.js"></script>
</head>
<body>
<div class="se-pre-con"></div>
<header>
  <div class="headercolor">
    <div class="container">
      <div class="logo"><img src="<?php echo asset("contest/storyboard/images/logo.png") ?>" alt="Indiashopps" width="185" height="125"></div>
    </div>
  </div>
</header>
<input type="hidden" id="fb_id" value="">
<section id="fblogin">
  <div class="container">
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <div class="loginbgbox">


        <div class="userbox"><img src="<?php echo asset("contest/storyboard/images/userim.jpg") ?>" alt=""></div>
        <div class="fbbutton"><img onclick="javascript:checkLoginState();" style="cursor:pointer" class="img-responsive" src="<?php echo asset("contest/storyboard/images/fbbut.png") ?>" width="287" height="63" alt=""></div>
      </div>
    </div>
    <div class="col-md-4"></div>
     
  </div>
 
</section>
 <input type="hidden" value="{{csrf_token()}}" name="_token" />
<section id="video_demo" style="background:#fff; padding:20px; margin-top:40px;">
  <div class="container">
  <h1 style="color:#cc0228;font-size: 32px;">Pave the road to your love journey through this Exciting Storyboard Contest</h1>
  <div class="loginpagecon"><p>This is going to be a super fun because we are asking you to share the road to your beautiful love journey with us.</p>
  <ul>
    <li>This is going to be a super fun because we are asking you to share the road to your beautiful love journey with us.</li>
    <li>The photographs which you will select will be added to our page in an order. You can also change the sequence of the photos once they are uploaded.</li>
    <li>Once all your photographs are uploaded, a video including your all photos will be created to make your journey appear even more beautiful and special.</li>
    <li>We will share the video on our Facebook page defining your love story as the ideal one on 14th Feb, 2017.</li>
    <li>This is contest sponsered by IndiaShopps.com</li>
    <li>IndiaShopps will inform the winners through emails and phone numbers (if available) at their registered email IDs.</li>
  </ul>
  <p>Selection Criteria:</p>
  <ul>
  <li>We will judge this contest on how special your journey is and how you have preserved each and every detail of your love.</li></ul>

  </div>
  <div class="videoboxnew">
  <ul>
  <li><img src="<?php echo asset("contest/storyboard/images/video.jpg") ?>" width="260" height="260" alt=""></li>
  <li><img src="<?php echo asset("contest/storyboard/images/video.jpg") ?>" width="260" height="260" alt=""></li>
  <li><img src="<?php echo asset("contest/storyboard/images/video.jpg") ?>" width="260" height="260" alt=""></li>
  <li><img src="<?php echo asset("contest/storyboard/images/video.jpg") ?>" width="260" height="260" alt=""></li>
  </ul>
  </div>
  </div>
</section>


<section id="album" style="display:none">
  <div class="container">
  
    <div class="albums">
      <h1>Albums</h1>
    </div>
    <div class="albumsbgcolor">
   <!--  <div class="loginpagecon" style="padding:10px 40px 10px 40px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</div> -->
           <div class="albumsphoto">
          <!---Albums COMING FROM BELOW JS---->
      </div>
    </div>
</div>
</section>
<!-- <section id="albumPhotos" style="display:none">
    
<div class="popupbg">
  <div class="modal-content">
    <div class="albumsbgcolor">
      <div class="albumsphotos">
       
      </div>
    </div>

    <div class="reelbox">
      <div class="reelimleft"><img src="<?php //echo asset("contest/storyboard/images/reelbgim.jpg") ?>" width="128" height="198" alt=""></div>
    </div>
   <input type="button" class="btn btn-primary" onclick="javascript:submit_image()" value="Submit">
 </div>
</div>
</section>
 -->



  <div class="modal fade albumPhotos" role="dialog">
    <div class="modal-dialog popupbg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Album Photo</h4>
        </div>
        <div class="modal-body albumsbgcolor">
          <div class="albumsphotos">
            
          </div>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
          <div class="reelbox">
              <div class="reelimleft">
                  <img src="<?php echo asset("contest/storyboard/images/reelbgim.jpg") ?>" width="128" height="198" alt=""></div>
            </div>
           <input type="button" class="btn btn-primary" onclick="javascript:submit_image()" value="Post To Facebook">
         </div>
        </div>
      </div>
      
    </div>
  </div>




<footer style="background:#cc0228; margin-top:30px;">
  <div class="container">
    <div class="row">
      <p class="footer-txt">COPYRIGHT © 2017 Indiashopps.com - All Rights Reserved.</p>
    </div>
  </div>
</footer>

</body>

<script src="<?php echo asset("contest/storyboard/js/bootstrap.min.js") ?>"></script>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '403179636692282',
      // appId      : '1204368399600216', //localhost
      xfbml      : true,
      cookie     : true,
       status    : true, // check login status
      version    : 'v2.8'
    });
  
  };
function checkLoginState() { 
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}
function log_out(){
FB.logout();
}
function statusChangeCallback(res){
  if( res.status == "connected" ){ 
    FB.api('/me?fields=name,picture,email,albums', function(fbUser) {console.log(fbUser);
      //console.log("Open the pod bay doors, " + fbUser.name + ".");
      $("input#fb_id").val(fbUser.id);
      $.ajaxPrefilter(function(options, originalOptions, xhr) { // this will run before each request
          var token = $('input[name="_token"]').val(); // or _token, whichever you are using
          if (token) {
              return xhr.setRequestHeader('X-CSRF-TOKEN', token); // adds directly to the XmlHttpRequest Object
          }
      });
      $.post( "<?php echo url('/storyboard/log_insert');?>",{profile_id: fbUser.id,name: fbUser.name,email: fbUser.email,picture: fbUser.picture.data.url}, function( response ) {
        // console.log(response);
     
        if(fbUser.albums.data.length > 1)
        {
          album = "<ul>";
          for(i=0;i<fbUser.albums.data.length;i++)
          {
            album += "<li rel='"+fbUser.albums.data[i].id+"'><div class='photoalbums'><img src='#' alt='"+fbUser.albums.data[i].name+"' width='194' height='195'></div>";
              album += "<div class='titalphoto'><h2>"+fbUser.albums.data[i].name+"</h2><p>15 Photos</p></div>";           
            album += "</div></li>";
          }
          album += "</ul>";
           $("section#fblogin").hide();
          $("section#video_demo").hide();
          $("section#album").show();
          $("div.albumsphoto").html(album);
          getAlbumCoverPhoto();          
        }
 });

    });
    
  }else if( res.status == "not_authorized" ){
    FB.login(function(response) {
         statusChangeCallback(response);
    }, {scope: 'public_profile,email,user_photos,publish_actions'});
  }else if( res.status == "unknown" ){
    FB.login(function(response) {
         statusChangeCallback(response);
    }, {scope: 'public_profile,email,user_photos,publish_actions'});
  }
}


function getAlbumCoverPhoto()
{ 
  $("div.albumsphoto ul li").each(function(){    
      var imgalbum = $(this).children().children();
      var countnum = $(this).children(".titalphoto").children("p");
      album_id = $(this).attr("rel"); 
      FB.api("/"+album_id+"/picture",function (r) { 
           imgalbum.attr("src",r.data.url);          
        }
      );    
     
    FB.api("/"+album_id+"?fields=count",function (r) { 
           countnum.text(r.count+" Photos");         
        }
      );    

   });
}

function getPhotos(album_id)
{
  // alert(album_id);

    FB.api("/"+album_id+"/photos?fields=images",function (response) {
        if (response && !response.error) {
          var photos = response["data"];
          console.log(photos);          
          var output = "<ul>";
          for(var v=0;v<photos.length;v++) {
              var image_arr = photos[v]["images"];
            
              output += '<li><input type="checkbox" id="cb'+v+'" /><label for="cb'+v+'"><img style="z-index:1" width="194" height="195" src="'+image_arr[(image_arr.length-2)]["source"]+'" big-src="'+image_arr[0]["source"]+'" /></label></li>';
              // output += '<li><input type="checkbox" id="cb'+v+'" /><label for="cb'+v+'"><img alt="" width="194" height="195" src="'+image_arr[(image_arr.length-4)]["source"]+'" /></label></li>';
// console.log(subImages_text2);   
          }
          output += "</ul>";
          // console.log(output);
          $("div.albumPhotos div.albumsphotos").html(output);
          // $("section#albumPhotos div.albumsphotos").html(output);
          // $("section#albumPhotos").show();
           $("div.albumPhotos").modal();

        }
      }
    );

/*FB.api(
    "/10210947407461822?fields=picture",
    function (response) {
      if (response && !response.error) {
         console.log("photos");
          console.log(response);    
      }
    }
);*/

}

</script>

<script type="text/javascript">
  $(function () {   
   $(".se-pre-con").fadeOut("slow");
  /*****Getting Photos of album being clicked**************/
  $("div.albumsphoto").on("click","li",function(){
    getPhotos($(this).attr("rel"));
  });

/*****On checked photos are storing in stack for making video**************/
  $("div.albumsphotos").on("click","li input",function(){
    if($(this).is(":checked"))
    {      
      $("div.reelbox").append(' <div rel="'+$(this).attr("id")+'" class="reelbhphoto"><img class="reelphoto" src="'+$(this).next().children().attr("big-src")+'" width="125" height="80" alt=""></div>')
    }else{
       $("div.reelbox div[rel='"+$(this).attr("id")+"']").remove();
    }   
  });
  /***********PUBLISH IMAGES TO VIDEO**********************/
  
  

});
  
  function submit_image()
  {
    $(".se-pre-con").show("slow");
    var publish_image_api = [];
    $("div.reelbox div.reelbhphoto img").each(function(){
      // alert($(this).attr("src"));
        publish_image_api.push($(this).attr("src"));
    });
    // console.log(publish_image_api);
  
    $.post( "http://www.indiashopps.com/storyboard_api/video.php",{publish_image: publish_image_api}, function( response ) {
    // $.post( "http://localhost/indiashopps/storyboard_api/video_demo.php",{publish_image: publish_image_api}, function( response ) {
      // console.log(response);
      res = JSON.parse(response);
      console.log(res.video);
      if(res.video != "error")
      {
        var profile_id = $("input#fb_id").val();
         $.ajaxPrefilter(function(options, originalOptions, xhr) { // this will run before each request
          var token = $('input[name="_token"]').val(); // or _token, whichever you are using
          if (token) {
              return xhr.setRequestHeader('X-CSRF-TOKEN', token); // adds directly to the XmlHttpRequest Object
          }
        });
        $.post( "<?php echo url('/storyboard/log_insert');?>",{profile_id: profile_id,video: res.video}, function( response ) {
          FB.api(
              "/"+profile_id+"/videos",
              "POST",
              {
                  "file_url": res.video
              },
              function (response) {
               // if (response && !response.error) {
                  console.log(response);
                  $(".se-pre-con").fadeOut("slow");
                  alert("Video has been Posted to Facebook Page");
                  window.reload();
               // }
              }
          );     
          }); 
    }else{
      alert("Error");
    }
  });
  }
</script>
</html>
<script>
 (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-69454797-1', 'auto');
  ga('send', 'pageview');
</script>