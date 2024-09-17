setTimeout(function(){
  window.location.href = "Passwordchek.php"; // Replace with your target page
}, 18000000);



function ViewPaymentSlip(userId) {
  // document.getElementById('paymentSlip').style.display = 'block';
  // document.getElementById('userIdDisplay').innerText = 'User ID: ' + userId;
  
  // Perform an AJAX request to fetch user details based on userId
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'findslip.php?userId=' + encodeURIComponent(userId), true); // Encodes userId to prevent issues
  xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
          try {
              var response = JSON.parse(xhr.responseText);
              console.log("Response: ", response);
              // Check if the cost exists and update the plan price
              if (response.cost) {
                  document.getElementById('plan_price').innerText = 'Plan Price: Rs : ' + response.cost + '.00';
                 // Logs the plan price
              }

              if (response.photo_link) {
                  // Set the photo link in the image element and show the div
                  console.log("Payment Slip URL: " + response.photo_link); // Logs the photo link URL
                  document.getElementById('userPhoto').src = response.photo_link;
                  document.getElementById('paymentSlip').style.display = 'block';
                  document.getElementById('user_Id').innerText =userId;

                  // Add blur effect to the body
                  document.getElementById('body').style.transition = 'filter 0.3s ease';
                  document.getElementById('body').style.filter = 'blur(5px)';
              } else {
                  alert('No photo available for this user.');
              }
          } catch (e) {
              console.error("Error parsing JSON response: ", e);
              alert("There was an error processing the request.");
          }
      }
  };
  xhr.send();
}

function Verified(){
  
if (!confirm('Are you sure you want to verify this user?')) {
  return;
}

  let userId = document.getElementById('user_Id').innerText;
  let form = new FormData();
  form.append('userId', userId);
  fetch('verifiedUser.php', {
      method: 'POST',
      body: form
  }).then(response => response.text())
      .then(data => {
          console.log(data);
          if (data === '{"message":"Membership status updated."}') {
              alert('User has been verified successfully.');
              document.getElementById('paymentSlip').style.display = 'none';
              document.getElementById('body').style.filter = 'blur(0px)';
              window.location.reload();
          } else {
              alert('There was an error verifying the user.'+data);
          }
      }).catch(error => {
          console.error('Error verifying user: ', error);
          alert('There was an error verifying the user.');
      });
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