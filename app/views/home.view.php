<h1>this is home view page </h1>
<div>
    <img class="source_img" src="<?=$file?>" alt="" style="width:30%">
    <div class="source"></div>
</div>

<div>
    <img class="thumbnail_img" src="<?=$thumbnail?>" alt="" >
    <div class="thumbnail"></div>
</div>

<script>
    window.onload = function (){
        let img  = document.querySelector(".source_img");
        let thumb = document.querySelector(".thumbnail_img");

        document.querySelector(".source").innerHTML = `width: ${img.naturalWidth},height: ${img.naturalHeight}`;
        document.querySelector(".thumbnail").innerHTML = `width: ${thumb.naturalWidth},height: ${thumb.naturalHeight}`;
    }
</script>
