<template>
    <div class="admin_content">
        <transition name="fade">
            <div class="dashboard_modal_preloader" v-if="DashboardShowPreloader == true"></div>
        </transition>
        <div class="container admin_container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="domain_list_search" >
                        <form v-show="billing.domains.length > 2">
                            <button></button>
                            <input type="search" placeholder="Type to search..." v-model="search_billing">
                        </form> 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 dashboard_block">
                    <div :class="'domain_list_item dashboard_item dashboard_item-' + item_index" v-for="(item, item_index) in billing.domains" v-if="item.status == 1">
                        <div class="domain_list_head">
                            <div class="domain_list_title">
                                <span class="domain_icon">
                                    <img :src="'https://www.google.com/s2/favicons?domain=' + item['url']" alt="">
                                </span>
                                <span class="domain_name">{{ item['url'] }}</span>
                            </div> 
                            <div class="domain_module">
                                <div class="domain_module_notif module_active" v-if="item.current_plan" title="notification"></div>
                                <div class="domain_module_notif" v-else title="notification"></div>
                                <div class="domain_module_jump" title="jump out"></div>
                                <div class="domain_module_email" title="email"></div>
                            </div>
                            <div class="show_details">
                                <p class="show_details_burger"></p>
                                <p>{{ translation['show-details'] }}</p>
                            </div>
                            <div class="hide_details">
                                <p class="hide_details_burger"></p>
                                <p>{{ translation['hide-details'] }}</p>
                            </div>
                        </div>
                        <div class="domain_list_body">
                            <div class="domain_campaign_item dashboard_notification" v-bind:class="{ module_no_active: !item['current_plan'] }">
                                <div class="domain_list_body_left">
                                    <div class="dashboard_campaign_title">{{ translation['notifications'] }}</div>
                                    <div class="dashboard_choose_rate">
                             
                                        <div class="choose_rate_value" v-if="!item['current_plan']">
                                            <p class="choose_rate_name" :id="'rate_name_' + item_index" style="width: 100%;">
                                                {{ translation['select-your-plan'] }}
                                                <p class="choose_rate_settings" :id="'rate_settings_' + item_index"></p>
                                                <p class="choose_rate_cost" :id="'rate_cost_' + item_index"></p>
                                            </p>
                                            <span class="choose_arrow"></span>
                                        </div>                                   
                                        <div class="choose_rate_list" v-if="!item['current_plan']">
                                            <ul>
                                                <li @click="changeElement('none', item_index, item)">
                                                    <p class="name_rate">{{ translation['none'] }}</p>
                                                </li>
                                                <li v-for="(plan, plan_index) in billing.plans" @click="changeElement(plan_index, item_index, item)">
                                                    {{ plan }}
                                                    <p class="name_rate">{{ plan.name }}<p class="settings_rate">{{ translation['up-to'] }} {{ plan.visitors_mo }}  {{ translation['unique-visitorsmo'] }}</p>
                                                        <p class="cost_rate">${{ plan.price_mo }}</p>
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="domain_list_body_right">
                                    <div class="plan_active" v-if="item['current_plan']">
                                        <p>{{ translation['plan'] }}: <span class="choose_plan_active">{{ item['current_plan']['name'] }}</span></p>
                                        <p class="date_subscription" v-if="item['current_plan'].status == 1">{{ translation['up-to'] }} {{ item['current_plan']['purchases_till'] }}</p>
                                        <p class="date_subscription unsubscribed" v-else-if="item['current_plan'].status == 2">{{ translation['limits reached'] }}</p>
                                        <p class="date_subscription unsubscribed" v-else>{{ translation['unsubscribed'] }}</p>                                    
                                    </div>
                                    <div class="no_subscription" v-else style="display: block;">{{ translation['no-subscription'] }}</div>
                                    <a class="btn-unsubscribe" v-if="item['current_plan'] && item['current_plan'].status == 1" @click="Unsubscribe(item_index)">{{ translation['cancel-subscription'] }}</a>
                                    <a class="btn-subscribe" v-if="item['current_plan'] && item['current_plan'].status == 2" @click="UpdatePlan(item_index)">{{ translation['update-plan'] }}</a>
                                    <a class="btn-subscribe" v-if="item['current_plan'] && item['current_plan'].status == 0" @click="Unsubscribe(item_index)">{{ translation['subscribe'] }}</a>
                                </div>
                            </div>
                            <div class="domain_list_total" v-if="!item['current_plan']">          
                                <p class="domain_total_text">{{ translation['total'] }}:
                                    <span class="domain_total_price" :id="'total_' + item_index" :data-price="billing.plans[0].price_mo" :data-moduleid="billing.plans[0].module_id">$0</span>
                                </p>
                                <p class="domain_list_add_bill" @click="buildCheck($event, item_index)">{{ translation['add-to-bill'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="billing_not_found" v-show="search_billing_404">No matching was found! :(</div>
                </div>
            </div>
            <div class="dashboard_fixed_right" v-bind:class="{ dashboard_hide: hide_billiing_sidebar }">
                <div class="dashboard_fixed_billing-preloader"></div>
                <div class="dashboard_fixed_tabs">
                    <ul class="dashboard_fixed_tabs_list">
                        <li class="dashboard_fixed_tabs_link active">{{ translation['step'] }} 1</li>
                        <li class="dashboard_fixed_tabs_link">{{ translation['step'] }} 2</li>
                        <li class="dashboard_fixed_tabs_link">{{ translation['step'] }} 3</li>
                    </ul>
                    <div class="dashboard_fixed_tabs_content active">
                        <div class="dashboard_check_list">
                            <div class="dashboard_check_item" v-for="(bill, bill_index) in billing.selected">
                                <div class="dashboard_check_domain"><span>{{ bill_index + 1 }}.</span> {{ bill.name }}</div>
                                <ul class="dashboard_check_desc">
                                    <li class="dashboard_check_name" v-for="bill_module in bill.modules">
                                        <span>{{ bill_module.name }}</span>
                                        <span class="dashboard_check_price">{{ bill_module.price }}</span>
                                    </li>
                                </ul>
                                <a href="#" class="remove-from-bill" @click="Remove(bill_index)">{{ translation['remove'] }}</a>
                            </div>
                        </div>
                        <div class="dashboard_fixed_pay_text">
                            <p>{{ translation['total'] }}:</p>
                            <p class="dashboard_fixed_pay_count">${{ billing.total }}</p>
                        </div>
                        <div class="dashboard_tabs_next">
                            <a href="#" id="check-out_first" @click="CheckOut($event)">
                                <span>{{ translation['check-out-2'] }}</span>
                                <span></span>
                            </a>
                        </div>
                    </div>
                    <div class="dashboard_fixed_tabs_content">
                        <div class="dashboard_select_payment_title">{{ translation['select-payment-method'] }}:</div>
                        <div class="dashboard_select_payment_box">
                            <div class="dashboard_select_payment_item dashboard_payment_balance" @click="setPayType('balance')">
                                <p>{{ translation['from-balance'] }}</p>
                            </div>
                            <div class="dashboard_select_payment_item dashboard_payment_paypal active" @click="setPayType('paypal')">
                                <p></p>
                            </div>
                            <div class="dashboard_select_payment_item dashboard_payment_checkout" @click="setPayType('checkout')">
                                <p></p>
                            </div>
                        </div>
                        <form method="POST" id="bill-payment-form" action="/bill/paypal" style="display: none;">
                          <input type="hidden" name="_token" value="" />
                          <input name="payment-amount" type="text" />   
                          <input name="payment-bill" type="text" />     
                          <button>{{ translation['pay-with-paypal'] }}</button>
                        </form>
                        <div class="dashboard_tabs_next">
                            <a href="#" @click="SendPayment()">
                                <span>{{ translation['check-out-2'] }}</span>
                                <span></span>
                            </a>
                        </div>
                    </div>
                    <div class="dashboard_fixed_tabs_content billing-step">
                        
                        <div class="dashboard_total">
                            <p>Total:</p>
                            <p>${{ billing.total }}</p>
                        </div>
                        <h2>Enter your billing details</h2>
                        <div class="checkout-row">

                        </div>
                        <div  class="checkout-row billing">
                            <select  id="checkout-country">
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
                            <div class="checkout-error" style="padding-left: 0px"  id="checkout-country-error" >
                                <img
                                        style="width: 16px;height: 16px; margin-top:-3%"
                                        src="https://png.pngtree.com/svg/20170718/error_icon_509209.png"
                                />
                                <span
                                        style="font-size: 15px;padding-top: 3px;margin-left: 1%;color:red"
                                >Choose your address</span></div>
                            <input  type="text" name="" id="checkout-address" placeholder="Address" />
                            <div class="checkout-error" style="padding-left: 0px"  id="checkout-address-error" >
                                <img
                                        style="width: 16px;height: 16px; margin-top:-3%"
                                        src="https://png.pngtree.com/svg/20170718/error_icon_509209.png"
                                />
                                <span
                                        style="font-size: 15px;padding-top: 3px;margin-left: 1%;color:red"
                                >Address can't be blank</span></div>
                            <input  type="text" name="" id="checkout-city" placeholder="City" />
                            <div class="checkout-error" style="padding-left: 0px"  id="checkout-city-error" >
                                <img
                                        style="width: 16px;height: 16px; margin-top:-3%"
                                        src="https://png.pngtree.com/svg/20170718/error_icon_509209.png"
                                />
                                <span
                                        style="font-size: 15px;padding-top: 3px;margin-left: 1%;color:red"
                                >City can't be blank</span></div>
                            <input  type="text" name="" id="checkout-state" placeholder="State" />
                            <div class="checkout-error" style="padding-left: 0px"  id="checkout-state-error" >
                                <img
                                        style="width: 16px;height: 16px; margin-top:-3%"
                                        src="https://png.pngtree.com/svg/20170718/error_icon_509209.png"
                                />
                                <span
                                        style="font-size: 15px;padding-top: 3px;margin-left: 1%;color:red"
                                >State can't be blank</span></div>
                            <input class="short-input" type="text" name="" id="checkout-zip" placeholder="Zip code" />
                            <div class="checkout-error" style="padding-left: 0px"  id="checkout-zip-error" >
                                <img
                                        style="width: 16px;height: 16px; margin-top:-3%"
                                        src="https://png.pngtree.com/svg/20170718/error_icon_509209.png"
                                />
                                <span
                                        style="font-size: 15px;padding-top: 3px;margin-left: 1%;color:red"
                                >Zip can't be blank</span></div>
                        </div>
                        <div class="checkout-row">
                            <input class="short-input" type="text" name="" id="checkout-phone" placeholder="Enter phone number" />
                            <div class="checkout-error" style="padding-left: 0px"  id="checkout-phone-error" >
                                <img
                                        style="width: 16px;height: 16px; margin-top:-3%"
                                        src="https://png.pngtree.com/svg/20170718/error_icon_509209.png"
                                />
                                <span
                                        style="font-size: 15px;padding-top: 3px;margin-left: 1%;color:red"
                                >Phone number can't be blank</span></div>
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
                <div class="dashboard_fixed_tabs_caption visible-h">
                    <p>The information transfer is secured by SSL 256 bit certificate issued by Comodo. Web site fully satisfies the security standards of Visa and Mastercard (PCI DSS Level 1 compliant).</p>
                    <div class="dashboard_caption_icon">
                        <div class="caption_icon1"></div>
                        <div class="caption_icon2"></div>
                        <div class="caption_icon3"></div>
                        <div class="caption_icon4"></div>
                    </div>
                </div>
            </div>
        </div>
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
        watch: {
            // эта функция запускается при любом изменении поля
            search_billing: function() {

                    var searching = this.search_billing;
                    var total     = 0;
                    if (searching.trim() != '') {
                        for (var index in this.billing.domains) {
                            if(this.billing.domains[index].url.indexOf(searching) !== -1) {
                                this.billing.domains[index].status = 1;
                                total++;
                            } else {
                                this.billing.domains[index].status = 0;      
                            }
                        }
                    } else {
                        for (var index in this.billing.domains) {     
                            this.billing.domains[index].status = 1;
                            total++;
                        }        
                    }

                    if (total == 0) {
                        this.search_billing_404 = true;
                    } else {
                        this.search_billing_404 = false;
                    }
            }
        },
	 	methods: {
            Unsubscribe: function(index) {
                console.log(this.billing.domains[index]);
                var item = this.billing.domains[index];
                if (item.current_plan && item.current_plan.status == 1) {
                    item.current_plan.status = 0;
                } else if (item.current_plan && item.current_plan.status == 0) {
                    item.current_plan.status = 1;
                }

                var data = {    
                    //'module-id' : id,
                    'item_id' : item.id,
                    'plan_id' : item.current_plan.id,
                    'status' : item.current_plan.status,
                    '_token' : $('meta[name="csrf-token"]').attr('content')
                };

                $.post( '/api/billing/status', data, function( result ) {
 
                });

                return false;
            },
            Remove: function(index) {
                this.billing.selected.splice(index, 1);
                this.billingCountTotal();
                if (this.billing.total == 0) {
                    $('.dashboard_fixed_right').addClass('dashboard_hide');        
                }
            },
            RemoveOrAdd: function(id)
            {
                var element = $('.dashboard_item-' + id);
                var name    = element.find('.domain_name').html();
                var item_id = $('#rate_name_' + id).data('id');
                var price   = $('#rate_cost_' + id).html();

                for(var index in this.billing.selected) {
                    if(this.billing.selected[index].name == name && this.billing.selected[index].modules[0].price == price && this.billing.selected[index].modules[0].id == item_id) {                  
                        return true;      
                    } 
                }

                return false;
            },
            buildCheck: function($event, id) {

                var element = $('.dashboard_item-' + id);
                var name    = element.find('.domain_name').html();
                var item_id = $('#rate_name_' + id).data('id');
                var price   = $('#rate_cost_' + id).html();
                var unique  = 0;
                var bill_index = 0;
                var domain_info = {
                    name : name,
                    modules : {
                        0: {
                            name : this.translation.notifications,
                            price : price,
                            id : item_id
                        }
                    }
                };

                for(var index in this.billing.selected) {
                    if(this.billing.selected[index].name == name && $event.srcElement.innerHTML == this.translation['add-to-bill']) {
                        this.billing.selected[index].name             = name;
                        this.billing.selected[index].modules[0].price = price; 
                        this.billing.selected[index].modules[0].id    = item_id;                     
                        unique = 1;        
                    } 

                    if(this.billing.selected[index].name == name && $event.srcElement.innerHTML == 'Remove from bill') {
                        bill_index = index;
                    }
                }

                console.log(unique);

                if (unique == 0 && $event.srcElement.innerHTML == this.translation['add-to-bill']) {
                    $event.srcElement.innerHTML = 'Remove from bill';
                    this.billing.selected.push(domain_info);    
                } else if ($event.srcElement.innerHTML == 'Remove from bill') {
                    $event.srcElement.innerHTML = this.translation['add-to-bill'];
                    this.Remove(bill_index);
                } else if (unique == 1 && $event.srcElement.innerHTML == this.translation['add-to-bill']) {
                    $event.srcElement.innerHTML = 'Remove from bill';
                }
 
                this.billingCountTotal();
            },
            billingCountTotal() {
                this.billing.total = 0;
                for(var bill in this.billing.selected) {
                    var price = this.billing.selected[bill].modules[0].price.replace('$','');
                    this.billing.total = this.billing.total + parseFloat(price); 
                }
            },
            changeElement: function(plan_index, item_index, item) {
                if (plan_index == 'none') {
                    var name     = (item['current_plan'] ? 'Select your next plan' : 'Select your plan');
                    var visitors = '';
                    var price    = '';
                    $('#rate_name_' + item_index).parent().parent().parent().parent().next().removeClass('showed');
                    $('#total_' + item_index).html('$0');
                } else {
                    var name     = this.billing.plans[plan_index].name;
                    var visitors = 'Up to ' + this.billing.plans[plan_index].visitors_mo + ' Unique Visitors/mo';
                    var price    = '$' + this.billing.plans[plan_index].price_mo;
                    $('#rate_name_' + item_index).parent().parent().parent().parent().next().addClass('showed');
                    $('#total_' + item_index).html(price);
                }

                $('#rate_name_' + item_index).html(name + 
                    '<p id="rate_settings_'+ item_index +'" class="choose_rate_settings">' + visitors + 
                    '</p><p id="rate_cost_'+ item_index +'" class="choose_rate_cost">' + price + '</p>');
                
                if (plan_index != 'none') {
                    var plan_id = this.billing.plans[plan_index].id;
                    $('#rate_name_' + item_index).attr('data-id', plan_id);
                    $('#rate_name_' + item_index).parent().next().removeClass('show_choose_list');
                } else {
                    $('#rate_name_' + item_index).parent().next().removeClass('show_choose_list');
                }

                var exist = this.updateAddButton(item_index);

                if (exist) {
                    $('.dashboard_item-' + item_index + ' .domain_list_add_bill').html(this.translation['remove-from-bill']);
                } else {
                    $('.dashboard_item-' + item_index + ' .domain_list_add_bill').html(this.translation['add-to-bill']);
                }
           },
           updateAddButton: function(id) {

                var element = $('.dashboard_item-' + id);
                var name    = element.find('.domain_name').html();
                var item_id = $('#rate_name_' + id).data('id');
                var price   = $('#rate_cost_' + id).html();

                for(var index in this.billing.selected) {
                    if(this.billing.selected[index].name == name && this.billing.selected[index].modules[0].price == price && this.billing.selected[index].modules[0].id == item_id) {                  
                        return true;      
                    } 
                }

                return false;
           },
           ActivatePlan: function(item_index) {
                var checked = $('#on_notification_domain_' + item_index).prop('checked');
                if (checked === true) {
                    $('#total_' + item_index).html('$' + $('#total_' + item_index).attr('data-price'));  
                } else {
                    $('#total_' + item_index).html('$0');              
                }

                this.changeOrderPrice();
           },
           changeOrderPrice: function() {
                var total_price = 0;
                var len = this.billing.domains.length - 1;
                for (var i = 0; i <= len; i++) {
                    var price = parseInt($('#total_' + i).html().substring(1));
                    total_price = total_price + price;
                }
                this.billing.order_price = total_price;
           },
           setPayType: function(type) {
                this.billing.pay_type = type;
           },
           SendPayment: function() {
                if (this.billing.pay_type == 'paypal' && this.billing.total > 0) {
                    this.DashboardShowPreloader = true;
                    console.log(this.billing.selected);
                    $('#bill-payment-form input[name="payment-bill"]').val(JSON.stringify(this.billing.selected));
                    $('#bill-payment-form').submit();
                    console.log('paying with paypal');
                } else if (this.billing.pay_type == 'balance' && this.billing.total > 0) {
                    this.DashboardShowPreloader = true;
                    var data = {    
                        'billing' : JSON.stringify(this.billing.selected),
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
                } else if (this.billing.pay_type == 'checkout' && this.billing.total > 0) {

                    if (this.billing.total > 0) {
                        $('#check-out_first').closest('.dashboard_fixed_tabs').find('.dashboard_fixed_tabs_link.active').removeClass('active').next('li').addClass('active');
                        $('#check-out_first').closest('.dashboard_fixed_tabs').find('.dashboard_fixed_tabs_content.active').removeClass('active').next('div').addClass('active');                    
                    }

                } else {
                    console.log('none');       
                }
           },
           CheckOut: function(item) {

                if (this.billing.total > 0) {
                    $('#check-out_first').closest('.dashboard_fixed_tabs').find('.dashboard_fixed_tabs_link.active').removeClass('active').next('li').addClass('active');
                    $('#check-out_first').closest('.dashboard_fixed_tabs').find('.dashboard_fixed_tabs_content.active').removeClass('active').next('div').addClass('active');                    
                }

                return false;
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
                });       
            },
            UpdatePlan: function(id) {

                let element    = $('.dashboard_item-' + id);
                let name       = element.find('.domain_name').html();
                let unique     = 0;
                let bill_index = 0;

                let current_plan_name = element.find('.choose_plan_active').html(); 
                let next_plan         = null;

                for (let index in this.billing.plans) {

                    let curr_name = this.billing.plans[index].name;
                    if (current_plan_name == curr_name) {

                        let next_index = parseInt(index + 1);
                        if (index < this.billing.plans.length - 1) {

                            next_plan = this.billing.plans[next_index];
                        } else if (index == this.billing.plans.length - 1) {

                            next_plan = this.billing.plans[index];
                        }
                        break;
                    }
                }
 
                let domain_info = {
                    name : name,
                    modules : {
                        0: {
                            name : this.translation.notifications,
                            price : '$' + next_plan.price_mo,
                            id : next_plan.id
                        }
                    }
                };

                this.billing.selected.push(domain_info);   
                this.billingCountTotal();
                $('.dashboard_fixed_right').removeClass('dashboard_hide');
            },
            successCallback: function(data) {

                $('#ccNo').removeClass('error');
                $('#expMonth').removeClass('error');
                $('#expYear').removeClass('error');
                $('#cvv').removeClass('error');
 
                var errors = 0;

                if ($('#checkout-address').val().length < 1) { $('#checkout-address').addClass('error'); errors++; $('#checkout-address-error').css('display','block')  } else { $('#checkout-address').removeClass('error');$('#checkout-address-error').css('display','none') }
                if ($('#checkout-city').val().length < 1) { $('#checkout-city').addClass('error'); errors++; $('#checkout-city-error').css('display','block')  } else { $('#checkout-city').removeClass('error');$('#checkout-city-error').css('display','none') }
                if ($('#checkout-state').val().length < 1) { $('#checkout-state').addClass('error'); errors++; $('#checkout-state-error').css('display','block') } else { $('#checkout-state').removeClass('error');$('#checkout-state-error').css('display','none') }
                if ($('#checkout-zip').val().length < 1) { $('#checkout-zip').addClass('error'); errors++; $('#checkout-zip-error').css('display','block') } else { $('#checkout-zip').removeClass('error');$('#checkout-zip-error').css('display','none') }
                if ($('#checkout-country option:selected').val() == 0) { $('#checkout-country').addClass('error'); errors++; $('#checkout-country-error').css('display','block')} else { $('#checkout-country').removeClass('error');$('#checkout-zip').removeClass('error');$('#checkout-country-error').css('display','none') }
                if ($('#checkout-phone').val().length < 1) { $('#checkout-phone').addClass('error'); errors++; $('#checkout-phone-error').css('display','block')} else { $('#checkout-phone').removeClass('error');$('#checkout-phone-error').css('display','none')  }


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
                        'payment_amount' : this.billing.total,
                        'plan_detail' : this.billing.selected,
                        'payment_type' : 'billing',
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
                                document.location.href="/admin/top-up";
                            } else {
                                alert('Payment failed');
                            }
                            setTimeout(function(){
                                $('.dashboard_fixed_billing-preloader').fadeOut('fast');
                            }, 1000);
                        }
                    });


                } else {
                    console.log('errors ' + errors);
                    setTimeout(function(){
                        $('.dashboard_fixed_billing-preloader').fadeOut('fast');
                    }, 1000);
                }
  

            },
            errorCallback: function(data) {
                // Retry the token request if ajax call fails
                if (data.errorCode === 200) {
                    alert('Please try again later.');
                    $('.dashboard_fixed_billing-preloader').fadeOut('fast');
                   // This error code indicates that the ajax call failed. We recommend that you retry the token request.
                } else {
                    setTimeout(function(){

                        $('#ccNo').addClass('error');
                        $('#expMonth').addClass('error');
                        $('#expYear').addClass('error');
                        $('#cvv').addClass('error');
                        if ($('#checkout-address').val().length < 1) { $('#checkout-address').addClass('error'); $('#checkout-address').addClass('billing');  $('#checkout-address-error').css('display','block')  } else { $('#checkout-address').removeClass('error');$('#checkout-address-error').css('display','none') }
                        if ($('#checkout-city').val().length < 1) { $('#checkout-city').addClass('error'); $('#checkout-city').addClass('billing');  $('#checkout-city-error').css('display','block')  } else { $('#checkout-city').removeClass('error');$('#checkout-city-error').css('display','none') }
                        if ($('#checkout-state').val().length < 1) { $('#checkout-state').addClass('error'); $('#checkout-state').addClass('billing'); $('#checkout-state-error').css('display','block') } else { $('#checkout-state').removeClass('error');$('#checkout-state-error').css('display','none') }
                        if ($('#checkout-zip').val().length < 1) { $('#checkout-zip').addClass('error');  $('#checkout-zip').addClass('billing');$('#checkout-zip-error').css('display','block') } else { $('#checkout-zip').removeClass('error');$('#checkout-zip-error').css('display','none') }
                        if ($('#checkout-country option:selected').val() == 0) { $('#checkout-country').addClass('error'); $('#checkout-country').addClass('billing');  $('#checkout-country-error').css('display','block')} else { $('#checkout-country').removeClass('error');$('#checkout-country-error').css('display','none') }
                        if ($('#checkout-phone').val().length < 1) { $('#checkout-phone').addClass('error');  $('#checkout-phone').addClass('billing'); $('#checkout-phone-error').css('display','block')} else { $('#checkout-phone').removeClass('error');$('#checkout-phone-error').css('display','none')  }

                        $('.dashboard_fixed_billing-preloader').fadeOut('fast');
                       // alert('Wrong card data');
                    }, 1000);
                  //alert(data.errorMsg);
                }
            },
            tokenRequest: function() {
                // Setup token request arguments
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
                console.log(this.errorCallback);
            },
            SendPaymentCheckOut: function() {
 
                this.tokenRequest();
                $('.dashboard_fixed_billing-preloader').fadeIn('fast');
            }
	 	},
        mounted() {
            TCO.loadPubKey('production');
            this.getTranslation();

            $('#bill-payment-form input[name="_token"]').val($('meta[name="csrf-token"]').attr('content'));

            var data = {    
                //'module-id' : id,
                '_token' : $('meta[name="csrf-token"]').attr('content')
            };

            var vm = this;

            $.post( '/api/billing/list', data, function( result ) {
                vm.billing.domains = result.domains;
                vm.billing.plans   = result.plans;
                vm.billing.up_to   = result.up_to;
                vm.billing.user    = result.user;

                for (var index in vm.billing.domains) 
                {
                    vm.billing.domains[index].current_billing  = result.plans[0];
                    vm.billing.domains[index].selected_billing = false;
                    vm.billing.domains[index].status = 1;
                } 
            });

            $(document).on('click', '.choose_rate_value', function() {

                if ($(this).next().hasClass('show_choose_list')) {
                    $(this).next().removeClass('show_choose_list');
                } else {
                    $(this).next().addClass('show_choose_list');
                }
            });

            $(document).on('click', '.domain_list_head', function(){

                if ($(this).hasClass('active')) {
                   $(this).next('.domain_list_body').fadeOut();
                   $(this).removeClass('active');
                } else {
                   $(this).next('.domain_list_body').fadeIn();
                   $(this).addClass('active');
                }

               return false;      
            });

            $(document).on('click', '.hide_details', function(){
                $(this).closest('.domain_list_head').removeClass('active').next('.domain_list_body').fadeOut();
                return false;
            }); 

            $(document).on('click', '.domain_list_add_bill', function(){
                $('.dashboard_fixed_right').removeClass('dashboard_hide');

            });
 
        }
    }
</script>
<style>
    .billing{
        margin-bottom:0px !important;
    }
</style>