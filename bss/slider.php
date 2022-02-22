<!DOCTYPE html>
<html lang="en">
<head>
  <title>Slider Bootstrap Webjalanan</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<style>.carousel-inner > .item > img,.carousel-inner > .item > a > img { width: 100%; margin: auto;}</style>
</head>
<body>

<div class="container">
  <br>
  <div id="WJSlider" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#WJSlider" data-slide-to="0" class="active"></li>
      <li data-target="#WJSlider" data-slide-to="1"></li>
      <li data-target="#WJSlider" data-slide-to="2"></li>
      <li data-target="#WJSlider" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

      <div class="item active">
        <img src="images/signup-img.jpg" alt="slide1" width="460" height="345">
        <div class="carousel-caption">
          <h3>Judul Gambar 1</h3>
          <p>Ini adalah deskripsi singkat dari judul gambar yang pertama.</p>
        </div>
      </div>

      <div class="item">
        <img src="images/signup-imgx.jpg" alt="slide2" width="460" height="345">
        <div class="carousel-caption">
          <h3>Judul Gambar 2</h3>
          <p>Ini adalah deskripsi singkat dari judul gambar yang ke dua.</p>
        </div>
      </div>
  
      <div class="item">
        <img src="images/signup-imgxx.jpg" alt="slide3" width="460" height="345">
        <div class="carousel-caption">
          <h3>Judul Gambar 3</h3>
          <p>Ini adalah deskripsi singkat dari judul gambar yang ke tiga.</p>
        </div>
      </div>

      <div class="item">
        <img src="images/signup-imgxxx.jpg" alt="slide4" width="460" height="345">
        <div class="carousel-caption">
          <h3>Judul Gambar 4</h3>
          <p>Ini adalah deskripsi singkat dari judul gambar yang ke empat.</p>
        </div>
      </div>
 
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#WJSlider" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Kembali</span>
    </a>
    <a class="right carousel-control" href="#WJSlider" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Lanjut</span>
    </a>
  </div>
</div>

</body>
</html>