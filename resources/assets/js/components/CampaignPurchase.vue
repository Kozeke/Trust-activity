<template>

    <div class="active_domain_block">
        <transition name="fade">
            <div class="dashboard_modal_preloader" v-if="DashboardShowPreloader == true"></div>
        </transition>
        <div class="active_domain_fon" v-bind:class="{ show_update_plan: show_update_plan }"></div>
        <div class="c-active_domain_block" v-bind:class="{ show_update_plan: show_update_plan }">
            <div class="active_domain_block-preloader"></div>
            <div class="active_domain_name">{{ purchase_domain_url }}</div>
            <div class="active_domain_title">{{ translation['activate-notifications'] }}</div>
            <div class="active_domain_plan">
                <p class="active_domain_plan_text">{{ translation['select-your-plan' ] }}:</p>
                <div class="plan_select">  
                    <div v-for="(plan, plan_index) in campaignUpdate.plans" class="active_domain_plan_item plan_micro" @click="selectPlan($event, plan_index)">
                        <p class="plan_name">{{ plan.name }}</p>
                        <p class="plan_desc">{{ translation['up-to'] }} {{ plan.visitors_mo }} {{ translation['unique-visitorsmo'] }}</p>
                        <p class="plan_cost">${{ plan.price_mo }}</p>
                    </div>
                </div>
                <div class="change_active_domain_plan" @click="reset()">
                    <p><span></span>{{ translation['re-select'] }}</p>
                </div>
            </div>
            <div class="active_domain_payment">
                <p class="active_domain_payment_text">{{ translation['select-payment-method'] }}:</p>
                <div class="payment_select">
                    <div class="active_domain_payment_item" @click="selectMethod('balance')" v-bind:class="{ active: updatePlan.pay_type == 'balance' }">
                        <p class="payment_balance">{{ translation['from-balance'] }}</p> 
                    </div>
                    <div class="active_domain_payment_item" @click="selectMethod('paypal')" v-bind:class="{ active: updatePlan.pay_type == 'paypal' }">
                        <p class="payment_paypal"></p>
                    </div>
                    <div class="active_domain_payment_item" @click="selectMethod('checkout')" v-bind:class="{ active: updatePlan.pay_type == 'checkout' }">
                        <p class="payment_checkout"></p>
                    </div>            
                </div>
            </div>
            <transition name="fade">
                <div class="active_domain_link" v-show="updatePlan.pay_type != null">
                    <a href="#" @click="SendPayment()">
                        <span>{{ translation['check-out-2'] }}</span>
                        <span></span>
                    </a>
                </div>
            </transition>

            <div class="c-active_domain_block_form" v-bind:class="{ active: purchase_domain_show }">
                <div class="active_domain_name">{{ purchase_domain_url }}</div>
                <div class="active_domain_title" v-if="this.updatePlan.selected[0] && this.updatePlan.selected[0].modules[0].price">Total Price: {{ this.updatePlan.selected[0].modules[0].price }}</div>
                <div class="active_domain_title" v-else>Total Price: </div>
                <div class="change_active_domain_plan" @click="reset()">
                    <p><span></span>{{ translation['re-select'] }}</p>
                </div>
                <!--<div class="active_domain_title">Total Price: 19$</div>-->
                <p class="active_domain_plan_text">Enter your billing details</p>
                <div class="checkout-row">
                    <label for="checkout-name">Name</label>
                    <input type="text" name="" id="checkout-name" placeholder="Enter name" />
                </div>
                <div class="checkout-row">
                    <label for="checkout-country">Address</label>
                    <select id="checkout-country">
                        <option value="0">Please select...</option>
                        <option value="240">Afghanistan</option>
                        <option value="1">Albania</option>
                        <option value="2">Algeria</option>
                        <option value="3">American Samoa</option>
                        <option value="4">Andorra</option>
                        <option value="5">Angola</option>
                        <option value="6">Anguilla</option>
                        <option value="7">Antarctica</option>
                        <option value="8">Antigua and Barbuda</option>
                        <option value="9">Argentina</option>
                        <option value="10">Armenia</option>
                        <option value="11">Aruba</option>
                        <option value="12">Australia</option>
                        <option value="13">Austria</option>
                        <option value="14">Azerbaijan</option>
                        <option value="15">Bahamas, The</option>
                        <option value="16">Bahrain</option>
                        <option value="17">Bangladesh</option>
                        <option value="18">Barbados</option>
                        <option value="19">Belarus</option>
                        <option value="20">Belgium</option>
                        <option value="21">Belize</option>
                        <option value="22">Benin</option>
                        <option value="23">Bermuda</option>
                        <option value="24">Bhutan</option>
                        <option value="25">Bolivia</option>
                        <option value="250">Bonaire, Sint Eustatius and Saba</option>
                        <option value="26">Bosnia and Herzegovina</option>
                        <option value="27">Botswana</option>
                        <option value="28">Bouvet Island</option>
                        <option value="29">Brazil</option>
                        <option value="30">British Indian Ocean Territory</option>
                        <option value="32">Brunei</option>
                        <option value="33">Bulgaria</option>
                        <option value="34">Burkina Faso</option>
                        <option value="35">Burundi</option>
                        <option value="37">Cambodia</option>
                        <option value="38">Cameroon</option>
                        <option value="39">Canada</option>
                        <option value="241">Canary Islands</option>
                        <option value="40">Cape Verde</option>
                        <option value="41">Cayman Islands</option>
                        <option value="42">Central African Republic</option>
                        <option value="43">Chad</option>
                        <option value="44">Chile</option>
                        <option value="45">China</option>
                        <option value="46">Christmas Island</option>
                        <option value="47">Cocos (Keeling) Islands</option>
                        <option value="48">Colombia</option>
                        <option value="49">Comoros</option>
                        <option value="50">Congo</option>
                        <option value="51">Cook Islands</option>
                        <option value="52">Costa Rica</option>
                        <option value="53">Croatia</option>
                        <option value="248">Curaçao</option>
                        <option value="55">Cyprus</option>
                        <option value="56">Czech Republic</option>
                        <option value="234">Democratic Republic of the Congo</option>
                        <option value="57">Denmark</option>
                        <option value="58">Djibouti</option>
                        <option value="59">Dominica</option>
                        <option value="60">Dominican Republic</option>
                        <option value="61">East Timor</option>
                        <option value="62">Ecuador</option>
                        <option value="63">Egypt</option>
                        <option value="64">El Salvador</option>
                        <option value="65">Equatorial Guinea</option>
                        <option value="66">Eritrea</option>
                        <option value="67">Estonia</option>
                        <option value="68">Ethiopia</option>
                        <option value="69">Falkland Islands (Malvinas)</option>
                        <option value="70">Faroe Islands</option>
                        <option value="71">Fiji</option>
                        <option value="72">Finland</option>
                        <option value="73">France</option>
                        <option value="75">French Guiana</option>
                        <option value="76">French Polynesia</option>
                        <option value="77">French Southern/Antarctic Lands</option>
                        <option value="78">Gabon</option>
                        <option value="79">Gambia</option>
                        <option value="80">Georgia</option>
                        <option value="81">Germany</option>
                        <option value="82">Ghana</option>
                        <option value="83">Gibraltar</option>
                        <option value="84">Greece</option>
                        <option value="85">Greenland</option>
                        <option value="86">Grenada</option>
                        <option value="87">Guadeloupe</option>
                        <option value="88">Guam</option>
                        <option value="89">Guatemala</option>
                        <option value="244">Guernsey</option>
                        <option value="90">Guinea</option>
                        <option value="91">Guinea-Bissau</option>
                        <option value="92">Guyana</option>
                        <option value="93">Haiti</option>
                        <option value="94">Heard and McDonald Islands</option>
                        <option value="95">Honduras</option>
                        <option value="96">Hong Kong</option>
                        <option value="97">Hungary</option>
                        <option value="98">Iceland</option>
                        <option value="99">India</option>
                        <option value="100">Indonesia</option>
                        <option value="101">Iraq</option>
                        <option value="102">Ireland</option>
                        <option value="104">Israel</option>
                        <option value="105">Italy</option>
                        <option value="36">Ivory Coast</option>
                        <option value="106">Jamaica</option>
                        <option value="107">Japan</option>
                        <option value="245">Jersey</option>
                        <option value="108">Jordan</option>
                        <option value="109">Kazakhstan</option>
                        <option value="110">Kenya</option>
                        <option value="111">Kiribati</option>
                        <option value="113">Korea, South</option>
                        <option value="255">Kosovo</option>
                        <option value="114">Kuwait</option>
                        <option value="115">Kyrgyzstan</option>
                        <option value="116">Lao Peoples Democratic Republic</option>
                        <option value="117">Latvia</option>
                        <option value="118">Lebanon</option>
                        <option value="119">Lesotho</option>
                        <option value="120">Liberia</option>
                        <option value="122">Liechtenstein</option>
                        <option value="123">Lithuania</option>
                        <option value="124">Luxembourg</option>
                        <option value="125">Macau</option>
                        <option value="239">Macedonia</option>
                        <option value="126">Madagascar</option>
                        <option value="127">Malawi</option>
                        <option value="128">Malaysia</option>
                        <option value="129">Maldives</option>
                        <option value="130">Mali</option>
                        <option value="131">Malta</option>
                        <option value="238">Man, Isle of</option>
                        <option value="132">Marshall Islands</option>
                        <option value="133">Martinique</option>
                        <option value="134">Mauritania</option>
                        <option value="135">Mauritius</option>
                        <option value="136">Mayotte</option>
                        <option value="137">Mexico</option>
                        <option value="138">Micronesia</option>
                        <option value="139">Moldova, Republic of</option>
                        <option value="140">Monaco</option>
                        <option value="141">Mongolia</option>
                        <option value="142">Monserrat</option>
                        <option value="243">Montenegro</option>
                        <option value="143">Morocco</option>
                        <option value="144">Mozambique</option>
                        <option value="145">Myanmar (Burma)</option>
                        <option value="254">NG_COUNTRY_254</option>
                        <option value="146">Namibia</option>
                        <option value="147">Nauru</option>
                        <option value="148">Nepal</option>
                        <option value="150">Netherlands</option>
                        <option value="151">New Caledonia</option>
                        <option value="152">New Zealand</option>
                        <option value="153">Nicaragua</option>
                        <option value="154">Niger</option>
                        <option value="155">Nigeria</option>
                        <option value="156">Niue</option>
                        <option value="157">Norfolk Island</option>
                        <option value="158">Northern Mariana Islands</option>
                        <option value="159">Norway</option>
                        <option value="160">Oman</option>
                        <option value="161">Pakistan</option>
                        <option value="162">Palau</option>
                        <option value="247">Palestinian territory, ocupied</option>
                        <option value="163">Panama</option>
                        <option value="164">Papua New Guinea</option>
                        <option value="165">Paraguay</option>
                        <option value="166">Peru</option>
                        <option value="167">Philippines</option>
                        <option value="168">Pitcairn</option>
                        <option value="169">Poland</option>
                        <option value="170">Portugal</option>
                        <option value="171">Puerto Rico</option>
                        <option value="172">Qatar</option>
                        <option value="173">Reunion</option>
                        <option value="237">Romania</option>
                        <option value="174">Russia</option>
                        <option value="175">Rwanda</option>
                        <option value="176">Saint Lucia</option>
                        <option value="177">Samoa</option>
                        <option value="178">San Marino</option>
                        <option value="179">Sao Tome and Principe</option>
                        <option value="180">Saudi Arabia</option>
                        <option value="181">Senegal</option>
                        <option value="242">Serbia</option>
                        <option value="182">Seychelles</option>
                        <option value="183">Sierra Leone</option>
                        <option value="184">Singapore</option>
                        <option value="249">Sint Maarten</option>
                        <option value="185">Slovakia</option>
                        <option value="186">Slovenia</option>
                        <option value="187">Solomon Islands</option>
                        <option value="188">Somalia</option>
                        <option value="189">South Africa</option>
                        <option value="190">South Georgia/Sandwich Islands</option>
                        <option value="251">South Sudan</option>
                        <option value="191">Spain</option>
                        <option value="192">Sri Lanka</option>
                        <option value="193">St. Helena</option>
                        <option value="194">St. Kitts and Nevis</option>
                        <option value="195">St. Pierre and Miquelon</option>
                        <option value="196">St. Vincent and the Grenadines</option>
                        <option value="198">Suriname</option>
                        <option value="199">Svalbard/Jan Mayen Islands</option>
                        <option value="200">Swaziland</option>
                        <option value="201">Sweden</option>
                        <option value="202">Switzerland</option>
                        <option value="204">Taiwan</option>
                        <option value="205">Tajikistan</option>
                        <option value="206">Tanzania, United Republic of</option>
                        <option value="207">Thailand</option>
                        <option value="208">Togo</option>
                        <option value="209">Tokelau</option>
                        <option value="210">Tonga</option>
                        <option value="211">Trinidad and Tobago</option>
                        <option value="212">Tunisia</option>
                        <option value="213">Turkey</option>
                        <option value="214">Turkmenistan</option>
                        <option value="215">Turks and Caicos Islands</option>
                        <option value="216">Tuvalu</option>
                        <option value="221">U.S. Minor Outlying Islands</option>
                        <option value="217">Uganda</option>
                        <option value="218">Ukraine</option>
                        <option value="219">United Arab Emirates</option>
                        <option value="220">United Kingdom</option>
                        <option value="222">United States of America</option>
                        <option value="224">Uruguay</option>
                        <option value="225">Uzbekistan</option>
                        <option value="226">Vanuatu</option>
                        <option value="227">Vatican City State (Holy See)</option>
                        <option value="228">Venezuela</option>
                        <option value="229">Vietnam</option>
                        <option value="223">Virgin Islands</option>
                        <option value="31">Virgin Islands (British)</option>
                        <option value="230">Wallis and Futuna Islands</option>
                        <option value="231">Western Sahara</option>
                        <option value="232">Yemen</option>
                        <option value="235">Zambia</option>
                        <option value="236">Zimbabwe</option>
                    </select>
                    <input type="text" name="" id="checkout-address" placeholder="Address" />
                    <input type="text" name="" id="checkout-city" placeholder="City" />
                    <input type="text" name="" id="checkout-state" placeholder="State" />
                    <input type="text" name="" id="checkout-zip" placeholder="Zip code" class="short-input" />
                </div>
                <div class="checkout-row">
                    <label for="checkout-phone">Phone number</label>
                    <input type="text" name="" id="checkout-phone" class="short-input" placeholder="Enter phone number" />
                </div>
                <div class="checkout-card">
                    <div class="checkout-card-row full">
                        <label for="ccNo">Credit card number</label>
                        <input type="text" id="ccNo" placeholder="Enter credit card number" v-imask="TopupPlan.card" />   
                    </div>
                    <div class="checkout-card-row">
                        <label for="expMonth">Expirtaion Date</label>
                        <input type="text" id="expMonth" placeholder="MM"  v-imask="TopupPlan.date"  />
                        <input type="text" id="expYear" placeholder="YY"  v-imask="TopupPlan.date"  />
                    </div>
                    <div class="checkout-card-row"> 
                        <label for="ccv">CCV</label>
                        <input type="text" id="cvv" placeholder="..." v-imask="TopupPlan.ccv" />
                    </div>
                </div>
                <div class="active_domain_link">
                    <a href="#" @click="SendPaymentCheckOut">
                        <span>Submit Payment</span>
                        <span></span>
                    </a>
                </div>
            </div>    


        </div>
        <form method="POST" id="bill-payment-form" action="/bill/paypal" style="display: none;">
          <input type="hidden" name="_token" value="" />
          <input name="payment-amount" type="text" />   
          <input name="payment-bill" type="text" />     
          <button>{{ translation['pay-with-paypal'] }}</button>
        </form>
    </div>

</template>

<script>
    import {IMaskDirective} from 'vue-imask';
    export default {
        data () {
            return this.$parent._data;
        },
        directives: {
          imask: IMaskDirective
        },
	 	methods: {
            selectMethod: function(type) {

                this.updatePlan.pay_type = type;
            },
            reset: function() {

                $('.active_domain_plan_item').fadeIn('fast');
                $('.active_domain_payment_item').removeClass('active');
                $('.change_active_domain_plan').fadeOut();
                $('.active_domain_plan_item').removeClass('active');

                this.purchase_domain_show = false;    
                this.updatePlan.pay_type = null;
                this.updatePlan.selected = [];
            },
            selectPlan: function(event, plan_index) {

                let hasClass = $(event.target).hasClass('active_domain_plan_item');
                let parent   = (hasClass) ? $(event.target) : $(event.target).parent();

                parent.addClass('active').siblings().removeClass('active');

                $('.active_domain_plan_item').fadeOut('fast');
                $('.active_domain_payment').fadeIn();
                $('.change_active_domain_plan').fadeIn(); 

                let domain_info = {
                    name : $('.active_domain_name').html(),
                    modules : {
                        0: {
                            name : this.translation.notifications,
                            price : '$' + this.campaignUpdate.plans[plan_index].price_mo,
                            id : this.campaignUpdate.plans[plan_index].id
                        }
                    } 
                };
                console.log(domain_info);
                this.updatePlan.selected.push(domain_info);   
            },
            getTranslation: function() {

                let data = {    
                    'page' : 'billing',
                    '_token' : $('meta[name="csrf-token"]').attr('content')
                };

                var vm = this;      

                $.post( '/api/translation/get', data, function( result ) {
                    for (var index in result) {
                        vm.translation[index] = result[index];
                    }
                
                    //setTimeout(function(){ vm.campaignListShowPreloader = false; }, 300);
                });       
            },
            SendPayment: function() {

                if (this.updatePlan.pay_type == 'paypal') {
                    this.DashboardShowPreloader = true;
                    $('#bill-payment-form input[name="_token"]').val($('meta[name="csrf-token"]').attr('content'));
                    $('#bill-payment-form input[name="payment-bill"]').val(JSON.stringify(this.updatePlan.selected));
                    $('#bill-payment-form').submit();
                    //console.log('paying with paypal');
                } else if (this.updatePlan.pay_type == 'balance') {
                    this.DashboardShowPreloader = true;
                    var data = {    
                        'billing' : JSON.stringify(this.updatePlan.selected),
                        '_token' : $('meta[name="csrf-token"]').attr('content')
                    };
                    var vm = this;
                    $.post( '/api/billing/buy', data, function( result ) {
                        if (result == 'success') {
                            vm.billing.user.balance = vm.billing.user.balance - vm.billing.order_price;
                            $('.sidebar_user_balance span:nth-child(2)').html('$' + vm.billing.user.balance);
                            window.location.href = "/admin/domains";
                        } else {
                           window.location.href = "/admin/domains";
                        }
                    });
                } else if (this.updatePlan.pay_type == 'checkout') {
                    this.purchase_domain_show = true;
                    console.log(this.updatePlan);
                } else {
                    console.log('none');       
                }
 
                return false;
            },
            successCallback: function(data) {

                $('#ccNo').removeClass('error');
                $('#expMonth').removeClass('error');
                $('#expYear').removeClass('error');
                $('#cvv').removeClass('error');
 
                var errors = 0;
 
                if ($('#checkout-name').val().length < 1) { $('#checkout-name').addClass('error'); errors++; } else { $('#checkout-name').removeClass('error'); }
                if ($('#checkout-address').val().length < 1) { $('#checkout-address').addClass('error'); errors++; } else { $('#checkout-address').removeClass('error'); }
                if ($('#checkout-city').val().length < 1) { $('#checkout-city').addClass('error'); errors++; } else { $('#checkout-city').removeClass('error'); }               
                if ($('#checkout-state').val().length < 1) { $('#checkout-state').addClass('error'); errors++; } else { $('#checkout-state').removeClass('error'); }
                if ($('#checkout-zip').val().length < 1) { $('#checkout-zip').addClass('error'); errors++; } else { $('#checkout-zip').removeClass('error'); }
                if ($('#checkout-country option:selected').val() == 0) { $('#checkout-country').addClass('error'); errors++; } else { $('#checkout-country').removeClass('error'); }
                if ($('#checkout-phone').val().length < 1) { $('#checkout-phone').addClass('error'); errors++; } else { $('#checkout-phone').removeClass('error'); }
                
                if(errors == 0) {
                    var data = {    
                        'token' : data.response.token.token,
                        '_token' : $('meta[name="csrf-token"]').attr('content'),
                        'name' : $('#checkout-name').val(),
                        'addrLine1' : $('#checkout-address').val(),
                        'city' : $('#checkout-city').val(),
                        'state' : $('#checkout-state').val(),
                        'zipCode' : $('#checkout-zip').val(),
                        'country' : $('#checkout-country option:selected').text(),
                        'phoneNumber' : $('#checkout-phone').val(),
                        'payment_amount' : this.updatePlan.selected[0].modules[0].price,
                        'plan_detail' : this.updatePlan.selected,
                        'payment_type' : 'campaign',
                    };      
                    
                    console.log(data);
                    console.log('success');     

                    var vm = this;

                    $('#checkout-form .domain_modal_preloader').fadeIn(500);

                    $.ajax({
                        type: "POST",
                        url: '/api/checkout/pay',
                        data: data,
                        success: function(result) {
                                
                            if (result == 'success') {
                                window.location.href = "/admin/domains";
                            } else {
                                alert('Payment failed');
                            }
                            setTimeout(function(){
                                $('.active_domain_block-preloader').fadeOut('fast');
                            }, 1000);
                        }
                    });


                } else {
                    console.log('errors ' + errors);
                    setTimeout(function(){
                        $('.active_domain_block-preloader').fadeOut('fast');
                    }, 1000);
                }
  

            },
            errorCallback: function(data) {
                // Retry the token request if ajax call fails
                if (data.errorCode === 200) {
                    alert('Please try again later.');
                    $('.active_domain_block-preloader').fadeOut('fast');
                   // This error code indicates that the ajax call failed. We recommend that you retry the token request.
                } else {
                    setTimeout(function(){

                        $('#ccNo').addClass('error');
                        $('#expMonth').addClass('error');
                        $('#expYear').addClass('error');
                        $('#cvv').addClass('error');

                        $('.active_domain_block-preloader').fadeOut('fast');
                       // alert('Wrong card data');
                    }, 1000);
                  //alert(data.errorMsg);
                }
            },      
            tokenRequest: function() {
                // Setup token request arguments
                console.log('tokenRequest');
                var args = {
                    sellerId: "203805143",
                    publishableKey: "9F9127D3-C804-420D-BF17-7225AF8753E5",
                    ccNo: $("#ccNo").val(),
                    cvv: $("#cvv").val(),
                    expMonth: $("#expMonth").val(),
                    expYear: $("#expYear").val()
                };      

                 $('#checkout-form .domain_modal_preloader').fadeIn('fast');
                // Make the token request
                TCO.requestToken(this.successCallback, this.errorCallback, args);
            }, 
            SendPaymentCheckOut: function() {
                                console.log(this.updatePlan.selected[0].modules[0].price);
                console.log('SendPaymentCheckOut');
                this.tokenRequest();
                $('.active_domain_block-preloader').fadeIn('fast');
            }


	 	},
        mounted() {
            TCO.loadPubKey('production');
            var vm = this;

            this.purchase_domain_url = document.getElementById('d_url').value;
            this.getTranslation();

            var data = {'_token' : $('meta[name="csrf-token"]').attr('content')};
 
            $.post( '/api/billing/list', data, (result) => {
                this.campaignUpdate.plans = result.plans;
            });
 
            $(document).on('click', '#domain-plan-update', () => {
                this.show_update_plan  = true;
            });

            $(document).on('click', '.active_domain_fon', () => {
                this.show_update_plan  = false;
            }); 
        }
    }
</script>
