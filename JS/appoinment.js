setTimeout(function(){
  window.location.href = "Passwordchek.php"; // Replace with your target page
}, 18000000);



function ViewPaymentSlip() {
  document.getElementById('paymentSlip').style.display = 'block';
  
  document.getElementById('body').style.transition = 'filter 0.3s ease';
  document.getElementById('body').style.filter = 'blur(5px)';
  // Perform an AJAX request to fetch user details based on userId
  // var xhr = new XMLHttpRequest();
  // xhr.open('GET', 'getUserPhoto.php?userId=' + userId, true);
  // xhr.onreadystatechange = function() {
  //     if (xhr.readyState == 4 && xhr.status == 200) {
  //         var response = JSON.parse(xhr.responseText);
  //         if (response.photo_link) {
  //             // Set the photo link in the image element and show the div
  //             document.getElementById('userPhoto').src = response.photo_link;
  //             document.getElementById('paymentSlip').style.display = 'block';
  //         } else {
  //             alert('No photo available for this user.');
  //         }
  //     }
  // };
  // xhr.send();
}

function Casel(){
  document.getElementById('paymentSlip').style.display = 'none';
  document.getElementById('body').style.filter = 'blur(0px)';
}

function ViewPaymnetSlipAfterV(){
  document.getElementById('paymentSlipAfterV').style.display = 'block';
  document.getElementById('div_1').style.filter = 'blur(5px)';
  document.getElementById('div_2').style.filter = 'blur(5px)';
  document.getElementById('div_3').style.filter = 'blur(5px)';

  
}

function CaselAfterV(){
  document.getElementById('paymentSlipAfterV').style.display = 'none';
  document.getElementById('div_1').style.filter = 'blur(0px)';
  document.getElementById('div_2').style.filter = 'blur(0px)';
  document.getElementById('div_3').style.filter = 'blur(0px)';
}