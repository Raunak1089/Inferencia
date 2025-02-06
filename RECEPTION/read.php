<!DOCTYPE html>
<html>
<head>
<link rel="icon" sizes="192x192" href="https://raunak1089.github.io/Required-files/favicon.ico">
<title>Inferencia | Database</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://raunak1089.github.io/all_scripts/fontawesome.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>


<div id="info">
  <div><span id="pno">0</span><span> persons present till now (</span><span id="tno"></span><span>%)</span></div>
</div>

<div id="imp_info" style="display:flex; height:50px;">
<details>
  <summary>View present participants</summary>
  <p id="certificate_names"></p>
</details>

<details>
  <summary>Distribution status</summary>
  <p id="coupon_status"></p>
</details>
</div>


<div id="list" style="overflow: scroll;text-align: center;height: 100vh;"></div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Raleway:wght@700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Playfair Display:wght@700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap');


table {
  font-family: Playfair Display;
  border-collapse: collapse;
}

td, th {
  border: 1px solid black;
  text-align: center;
}

tr:nth-child(even) {
  background-color: #7979ff4a;
}




#info {
  height: 2.5em;
  width: 100%;
  border: 2px solid #7979ff;
  background-color: white;
  position: relative;
  margin: 10px auto;
  text-align: center;
  display: flex;
  justify-content: center;
  align-items: center;
}

span{
  -webkit-text-fill-color: white;
  -webkit-text-stroke-width: 0.5px;
  -webkit-text-stroke-color: black;
  font-size: calc(15px + 1vw);
  z-index:1;
  position:relative;
}

#imp_info > details{
  margin: 0px auto;
  background: linear-gradient(125deg, maroon, transparent);
  padding: 10px;
  height: fit-content;
  display: flex;
  font-family: Quicksand;
  font-size: 18px;
  color: #fff;
  background-color: #007bff;
  border: none;
  border-radius: 10px;
  box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.4), 0px 10px 20px rgba(0, 0, 0, 0.2);
  cursor: pointer;
  transition: all 0.2s ease-in-out;
  flex-direction: column;
  align-items: center;
  z-index: 1;
}

</style>


<style id="present_fill">
  
  #info::before {
    content: "";
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    width: 0%;
    height: 100%;
    background-color: #7979ff;
  }

</style>



<script>

$.post("get_list.php", {},
    function(data, status){
      document.querySelector('#list').innerHTML = data;


      i=0;
      let regid_index;
      let name_index;
      let present_index;
      let stochastoliga_index;
      for(x of document.querySelectorAll('th')){
          if(x.innerText=='regId') regid_index=i;
          if(x.innerText=='name') name_index=i;
          if(x.innerText=='stochastoliga') stochastoliga_index=i;
          if(x.innerText=='present') present_index=i;
          i++
      }

      $("tr td:nth-child("+(stochastoliga_index+1)+")").each(function() {
          if($(this).text() === "1") {
            $(this).html('<i class="fa-duotone fa-comments-question-check"></i>');
          } else {
            $(this).html("");
          }
      });




      let pres_arr, retrieved_data;
      setInterval(() => {
        $.post("getdata.php", {},
          function(data, status){
                    retrieved_data = JSON.parse(data);
                  }
          )


        pres_arr = retrieved_data.present_array;

        for(i=1;i<=pres_arr.length;i++) document.querySelectorAll('tr')[i].childNodes[present_index].innerText=pres_arr[i-1];


        pno.innerText=retrieved_data.curr_pres;
        tno.innerText=Math.floor(10*100*retrieved_data.curr_pres/retrieved_data.present_array.length)/10;

        document.querySelector('#present_fill').innerHTML=`
        #info::before {
          content: "";
          display: block;
          position: absolute;
          top: 0;
          left: 0;
          width: ${100*retrieved_data.curr_pres/retrieved_data.present_array.length}%;
          height: 100%;
          background-color: #7979ff;
        }
      `;

      // DESIGN PRESENT COLUMN __________________________________________
            $("tr td:nth-child("+(present_index+1)+")").each(function() {
              if($(this).text() === "0") {
                $(this).html('<i class="fa-regular fa-xmark"></i>');
                $(this).css('background', 'red');
                $(this).css('color', 'white');
              } else {
                $(this).html('<i class="fa-regular fa-check"></i>');
                $(this).css('background', 'lime');
                $(this).css('color', 'white');
              }
            });


            for(e of Array.from(document.querySelectorAll('*')).filter(el => el.innerText === "Non-Vegeterian")){
              e.innerHTML='<food style="color: #BE360D;font-size: 2em;">▣</food>';
            };
        
            for(e of Array.from(document.querySelectorAll('*')).filter(el => el.innerText === "Vegeterian")){
              e.innerHTML='<food style="color: #008300;font-size: 2em;">▣</food>';
            };


            // SHOW THE INFO IN IMP INFO ___________________________
            // PRESENT PARTICIPANTS LIST
            namelist='<ol>';
            for(x of retrieved_data.participating_names) {
              namelist+='<li>'+x+'</li>';
            }
            namelist+='</ol>';
            document.querySelector('#certificate_names').innerHTML=namelist;

            // DISTRIBUTION STATUS
            coupon_status='<ul>';
            coupon_status+=`<li>Non-Veg coupons used: ${retrieved_data.curr_pres-retrieved_data.veg_presno}</li>`;
            coupon_status+=`<li>Veg coupons used: ${retrieved_data.veg_presno}</li>`;
            document.querySelector('#coupon_status').innerHTML=coupon_status;




      }, 1000);
    }
  )



</script>

</body>
</html>