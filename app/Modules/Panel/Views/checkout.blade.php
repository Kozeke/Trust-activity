 
<form id="myCCForm" action="http://dev.positron-it.ru/admin/2checkout" method="post">
  <input name="token" type="hidden" value="" />
  <div>
    <label>
      <span>Name</span>
      <input id="name" type="text" name="name" value="" autocomplete="off" required />
    </label>
  </div>
  <div>
    <label>
      <span>Address</span>
      <input id="addrLine1" type="text" name="addrLine1" value="" autocomplete="off" required />
    </label>
  </div>
  <div>
    <label>
      <span>City</span>
      <input id="city" type="text" name="city" value="" autocomplete="off" required />
    </label>
  </div>
  <div>
    <label>
      <span>State</span>
      <input id="state" type="text" name="state" value="" autocomplete="off" required />
    </label>
  </div>
  <div>
    <label>
      <span>Zip code</span>
      <input id="zipCode" type="text" name="zipCode" value="" autocomplete="off" required />
    </label>
  </div>
  <div>
    <label>
      <span>Country</span>
      <input id="country" type="text" name="country" value="" autocomplete="off" required />
    </label>
  </div>
  <div>
    <label>
      <span>Phone number</span>
      <input id="phoneNumber" type="text" name="phoneNumber" value="" autocomplete="off" required />
    </label>
  </div>
  <div>
    <label>
      <span>Card Number</span>
      <input id="ccNo" type="text" value="" autocomplete="off" required />
    </label>
  </div>
  <div>
    <label>
      <span>Expiration Date (MM/YYYY)</span>
      <input id="expMonth" type="text" size="2" required />
    </label>
    <span> / </span>
    <input id="expYear" type="text" size="4" required />
  </div>
  <div>
    <label>
      <span>CVC</span>
      <input id="cvv" type="text" value="" autocomplete="off" required />
    </label>
  </div>
  <input type="submit" value="Submit Payment" />
  {{ csrf_field() }}
</form>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
<script>
  // Called when token created successfully.
  var successCallback = function(data) {
    var myForm = document.getElementById('myCCForm');

    // Set the token as the value for the token input
    myForm.token.value = data.response.token.token;

    // IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
    myForm.submit();
  };

  // Called when token creation fails.
  var errorCallback = function(data) {
    // Retry the token request if ajax call fails
    if (data.errorCode === 200) {
       // This error code indicates that the ajax call failed. We recommend that you retry the token request.
    } else {
      alert(data.errorMsg);
    }
  };
 
  var tokenRequest = function() {
    // Setup token request arguments
    var args = {
      sellerId: "901404501",
      publishableKey: "66EF238F-4B28-4ADA-A6E6-69358F6A6BF6",
      ccNo: $("#ccNo").val(),
      cvv: $("#cvv").val(),
      expMonth: $("#expMonth").val(),
      expYear: $("#expYear").val()
    };

    // Make the token request
    TCO.requestToken(successCallback, errorCallback, args);
  };

  $(function() {
    // Pull in the public encryption key for our environment
    TCO.loadPubKey('sandbox');

    $("#myCCForm").submit(function(e) {
      // Call our token request function
      tokenRequest();

      // Prevent form from submitting
      return false;
    });
  });

</script>
 
 