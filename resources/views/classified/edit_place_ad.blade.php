


<main class="two-cloumn">
        <div class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>

        <div class="user-box-cs">
            <a href="{{ url('/') }}" class="sm-logo"><img src="{{ asset('css/img/logo.png') }}" alt=""></a>
            <ul class="nav nav-wizard  d-none" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="active" id="pills-step-1-tab" data-toggle="pill" href="#pills-step-1" role="tab">1</a>
                </li>
                <li class="nav-item">
                    <a class="" id="pills-step-2-tab" data-toggle="pill" href="#pills-step-2" role="tab">2</a>
                </li>
                <li class="nav-item">
                    <a class="" id="pills-step-3-tab" data-toggle="pill" href="#pills-step-3" role="tab">3</a>
                </li>
                <li class="nav-item">
                    <a class="" id="pills-step-4-tab" data-toggle="pill" href="#pills-step-4" role="tab">4</a>
                </li>
            </ul>
            <div class="tab-content wizard" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-step-1" role="tabpanel">
                    <p class="lead">Start adding some details for your ad post.</p>
                    <form>
                      
                        <div class="form-group row">
                            <label for="" class="col-12 col-form-label">Title</label>
                            <div class="col-12">
                                <input type="text" value="<?php echo $result -> title;?>" class="form-control" id="ad_title" name="ad_title" placeholder="">
                            </div>
                        </div>
                        
                        
                         <div class="form-group row">
                            <label for="" class="col-12 col-form-label">Category</label>
                            <div class="col-12">
                                 <select id="js_category"><option value="">Select category</option></select>
                            </div>
                        </div>
                        
                        
                        
                         <div class="form-group row sub_cat d-none">
                            <label for="" class="col-12 col-form-label">Sub Category</label>
                            <div class="col-12">
                                 <select  class="sub_cat d-none"  id="js_sub_category"><option value="">Select sub category</option></select>
                            </div>
                        </div>
                        
                        
                         <div class="form-group row level_3 d-none">
                            <label for="" class="col-12 col-form-label">Level 3 Category</label>
                            <div class="col-12">
                                 <select  class="level_3 d-none"  id="js_sub_sub_category"><option value="">Select sub category</option></select>
                            </div>
                        </div>
                        
                        
                          <div class="form-group row level_4 d-none">
                            <label for="" class="col-12 col-form-label">Model</label>
                            <div class="col-12">
                                 <select  class="level_4 d-none"  id="js_cars_modals"><option value="">Select sub category</option></select>
                            </div>
                        </div>
                        
                        
                        
                        <div class="form-group row level_5 d-none">
                            <label for="" class="col-12 col-form-label">Year</label>
                            <div class="col-12">
                                 <select  class="level_5 d-none"  id="js_year"><option value="">Select Year</option>
                                 <?php for( $i = 1970; $i <= date('Y'); $i++ ) {  $sel = '';   if( $i == $result -> year ){ $sel = 'selected'; }  ?>
                                 <option  <?php echo $sel;?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                 <?php } ?>
                                 
                                 
                                 </select>
                            </div>
                        </div>
                        
                        <div class="form-group row level_5 d-none">
                            <label for="" class="col-12 col-form-label">Mileage</label>
                            <div class="col-12">
                                 <input  style="width:100%;" value="<?php echo $result -> mileage;?>"   type="range" min="0" max="1000000"  class="level_4 d-none"  id="js_mileage"  />
                                 <span id="js_mileage_span"><?php echo $result -> mileage;?></span>
                            </div>
                        </div>
                        
                        
                        <div class="form-group row level_5 d-none">
                            <label for="" class="col-12 col-form-label">Service History</label>
                            <div class="col-12">
                                 <input  class="form-control" <?php if(  $result -> service_history == '1' ){?> checked="checked"   <?php }?>    type="checkbox"   id="service_history"  />
                            </div>
                        </div>
                        
                        
                        <div class="form-group row ">
                            <label for="" class="col-12 col-form-label">Address ( select address from dropdown list)</label>
                            <div class="col-12">
                            
                            <input type="text" class="form-control" value="<?php echo $result -> address;?>" id="address" name="address"  /><br /><Br />
                            
                            <input type="hidden" id="longitude" value="<?php echo $result -> latitude;?>" />
                            <input type="hidden" id="latitude" value="<?php echo $result -> longitude;?>" />
                            <input type="hidden" id="hidden_category" value="<?php echo $result -> text;?>" />
                             <input type="hidden" id="hidden_sub_category" value="<?php echo $result -> sub_category;?>" />
                              <input type="hidden" id="hidden_level_3" value="<?php echo $result -> level_3;?>" />
                               <input type="hidden" id="hidden_level_4" value="<?php echo $result -> level_4;?>" />
								<div class="map_container">
                                <p><strong>OR</strong> Select Location by clicking on map</p>
                                     <div id="js_bigMap" style="height: 400px; border:1px solid #000; position: relative; overflow: hidden;"></div>
                                 </div>

                            </div>
                        </div>
                        
                        
                        
                        
                        
                        
                        
                        
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="button" data-id="pills-step-2-tab" class="btn js_next_first btn-primary">Next</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade" id="pills-step-2" role="tabpanel">
                    <p class="lead">Important details</p>
                   
                       
                        <div class="form-group row">
                            <label for="" class="col-12 col-form-label">Phone number</label>
                            <div class="col-12 price-ui">
                               <select class="phone_code" id="phone_code" style="width:30px;">
                            <option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
                             <option data-countryCode="US" value="1" selected>USA (+1)</option> <option data-countryCode="GB" value="44">UK (+44)</option> <option disabled="disabled">Other Countries</option> <option data-countryCode="DZ" value="213">Algeria (+213)</option> <option data-countryCode="AD" value="376">Andorra (+376)</option> <option data-countryCode="AO" value="244">Angola (+244)</option> <option data-countryCode="AI" value="1264">Anguilla (+1264)</option> <option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option> <option data-countryCode="AR" value="54">Argentina (+54)</option> <option data-countryCode="AM" value="374">Armenia (+374)</option> <option data-countryCode="AW" value="297">Aruba (+297)</option> <option data-countryCode="AU" value="61">Australia (+61)</option> <option data-countryCode="AT" value="43">Austria (+43)</option> <option data-countryCode="AZ" value="994">Azerbaijan (+994)</option> <option data-countryCode="BS" value="1242">Bahamas (+1242)</option> <option data-countryCode="BH" value="973">Bahrain (+973)</option> <option data-countryCode="BD" value="880">Bangladesh (+880)</option> <option data-countryCode="BB" value="1246">Barbados (+1246)</option> <option data-countryCode="BY" value="375">Belarus (+375)</option> <option data-countryCode="BE" value="32">Belgium (+32)</option> <option data-countryCode="BZ" value="501">Belize (+501)</option> <option data-countryCode="BJ" value="229">Benin (+229)</option> <option data-countryCode="BM" value="1441">Bermuda (+1441)</option> <option data-countryCode="BT" value="975">Bhutan (+975)</option> <option data-countryCode="BO" value="591">Bolivia (+591)</option> <option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option> <option data-countryCode="BW" value="267">Botswana (+267)</option> <option data-countryCode="BR" value="55">Brazil (+55)</option> <option data-countryCode="BN" value="673">Brunei (+673)</option> <option data-countryCode="BG" value="359">Bulgaria (+359)</option> <option data-countryCode="BF" value="226">Burkina Faso (+226)</option> <option data-countryCode="BI" value="257">Burundi (+257)</option> <option data-countryCode="KH" value="855">Cambodia (+855)</option> <option data-countryCode="CM" value="237">Cameroon (+237)</option> <option data-countryCode="CA" value="1">Canada (+1)</option> <option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option> <option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option> <option data-countryCode="CF" value="236">Central African Republic (+236)</option> <option data-countryCode="CL" value="56">Chile (+56)</option> <option data-countryCode="CN" value="86">China (+86)</option> <option data-countryCode="CO" value="57">Colombia (+57)</option> <option data-countryCode="KM" value="269">Comoros (+269)</option> <option data-countryCode="CG" value="242">Congo (+242)</option> <option data-countryCode="CK" value="682">Cook Islands (+682)</option> <option data-countryCode="CR" value="506">Costa Rica (+506)</option> <option data-countryCode="HR" value="385">Croatia (+385)</option> <option data-countryCode="CY" value="90">Cyprus - North (+90)</option> <option data-countryCode="CY" value="357">Cyprus - South (+357)</option> <option data-countryCode="CZ" value="420">Czech Republic (+420)</option> <option data-countryCode="DK" value="45">Denmark (+45)</option> <option data-countryCode="DJ" value="253">Djibouti (+253)</option> <option data-countryCode="DM" value="1809">Dominica (+1809)</option> <option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option> <option data-countryCode="EC" value="593">Ecuador (+593)</option> <option data-countryCode="EG" value="20">Egypt (+20)</option> <option data-countryCode="SV" value="503">El Salvador (+503)</option> <option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option> <option data-countryCode="ER" value="291">Eritrea (+291)</option> <option data-countryCode="EE" value="372">Estonia (+372)</option> <option data-countryCode="ET" value="251">Ethiopia (+251)</option> <option data-countryCode="FK" value="500">Falkland Islands (+500)</option> <option data-countryCode="FO" value="298">Faroe Islands (+298)</option> <option data-countryCode="FJ" value="679">Fiji (+679)</option> <option data-countryCode="FI" value="358">Finland (+358)</option> <option data-countryCode="FR" value="33">France (+33)</option> <option data-countryCode="GF" value="594">French Guiana (+594)</option> <option data-countryCode="PF" value="689">French Polynesia (+689)</option> <option data-countryCode="GA" value="241">Gabon (+241)</option> <option data-countryCode="GM" value="220">Gambia (+220)</option> <option data-countryCode="GE" value="7880">Georgia (+7880)</option> <option data-countryCode="DE" value="49">Germany (+49)</option> <option data-countryCode="GH" value="233">Ghana (+233)</option> <option data-countryCode="GI" value="350">Gibraltar (+350)</option> <option data-countryCode="GR" value="30">Greece (+30)</option> <option data-countryCode="GL" value="299">Greenland (+299)</option> <option data-countryCode="GD" value="1473">Grenada (+1473)</option> <option data-countryCode="GP" value="590">Guadeloupe (+590)</option> <option data-countryCode="GU" value="671">Guam (+671)</option> <option data-countryCode="GT" value="502">Guatemala (+502)</option> <option data-countryCode="GN" value="224">Guinea (+224)</option> <option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option> <option data-countryCode="GY" value="592">Guyana (+592)</option> <option data-countryCode="HT" value="509">Haiti (+509)</option> <option data-countryCode="HN" value="504">Honduras (+504)</option> <option data-countryCode="HK" value="852">Hong Kong (+852)</option> <option data-countryCode="HU" value="36">Hungary (+36)</option> <option data-countryCode="IS" value="354">Iceland (+354)</option> <option data-countryCode="IN" value="91">India (+91)</option> <option data-countryCode="ID" value="62">Indonesia (+62)</option> <option data-countryCode="IQ" value="964">Iraq (+964)</option> <option data-countryCode="IE" value="353">Ireland (+353)</option> <option data-countryCode="IL" value="972">Israel (+972)</option> <option data-countryCode="IT" value="39">Italy (+39)</option> <option data-countryCode="JM" value="1876">Jamaica (+1876)</option> <option data-countryCode="JP" value="81">Japan (+81)</option> <option data-countryCode="JO" value="962">Jordan (+962)</option> <option data-countryCode="KZ" value="7">Kazakhstan (+7)</option> <option data-countryCode="KE" value="254">Kenya (+254)</option> <option data-countryCode="KI" value="686">Kiribati (+686)</option> <option data-countryCode="KR" value="82">Korea - South (+82)</option> <option data-countryCode="KW" value="965">Kuwait (+965)</option> <option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option> <option data-countryCode="LA" value="856">Laos (+856)</option> <option data-countryCode="LV" value="371">Latvia (+371)</option> <option data-countryCode="LB" value="961">Lebanon (+961)</option> <option data-countryCode="LS" value="266">Lesotho (+266)</option> <option data-countryCode="LR" value="231">Liberia (+231)</option> <option data-countryCode="LY" value="218">Libya (+218)</option> <option data-countryCode="LI" value="417">Liechtenstein (+417)</option> <option data-countryCode="LT" value="370">Lithuania (+370)</option> <option data-countryCode="LU" value="352">Luxembourg (+352)</option> <option data-countryCode="MO" value="853">Macao (+853)</option> <option data-countryCode="MK" value="389">Macedonia (+389)</option> <option data-countryCode="MG" value="261">Madagascar (+261)</option> <option data-countryCode="MW" value="265">Malawi (+265)</option> <option data-countryCode="MY" value="60">Malaysia (+60)</option> <option data-countryCode="MV" value="960">Maldives (+960)</option> <option data-countryCode="ML" value="223">Mali (+223)</option> <option data-countryCode="MT" value="356">Malta (+356)</option> <option data-countryCode="MH" value="692">Marshall Islands (+692)</option> <option data-countryCode="MQ" value="596">Martinique (+596)</option> <option data-countryCode="MR" value="222">Mauritania (+222)</option> <option data-countryCode="YT" value="269">Mayotte (+269)</option> <option data-countryCode="MX" value="52">Mexico (+52)</option> <option data-countryCode="FM" value="691">Micronesia (+691)</option> <option data-countryCode="MD" value="373">Moldova (+373)</option> <option data-countryCode="MC" value="377">Monaco (+377)</option> <option data-countryCode="MN" value="976">Mongolia (+976)</option> <option data-countryCode="MS" value="1664">Montserrat (+1664)</option> <option data-countryCode="MA" value="212">Morocco (+212)</option> <option data-countryCode="MZ" value="258">Mozambique (+258)</option> <option data-countryCode="MN" value="95">Myanmar (+95)</option> <option data-countryCode="NA" value="264">Namibia (+264)</option> <option data-countryCode="NR" value="674">Nauru (+674)</option> <option data-countryCode="NP" value="977">Nepal (+977)</option> <option data-countryCode="NL" value="31">Netherlands (+31)</option> <option data-countryCode="NC" value="687">New Caledonia (+687)</option> <option data-countryCode="NZ" value="64">New Zealand (+64)</option> <option data-countryCode="NI" value="505">Nicaragua (+505)</option> <option data-countryCode="NE" value="227">Niger (+227)</option> <option data-countryCode="NG" value="234">Nigeria (+234)</option> <option data-countryCode="NU" value="683">Niue (+683)</option> <option data-countryCode="NF" value="672">Norfolk Islands (+672)</option> <option data-countryCode="NP" value="670">Northern Marianas (+670)</option> <option data-countryCode="NO" value="47">Norway (+47)</option> <option data-countryCode="OM" value="968">Oman (+968)</option> <option data-countryCode="PK" value="92">Pakistan (+92)</option> <option data-countryCode="PW" value="680">Palau (+680)</option> <option data-countryCode="PA" value="507">Panama (+507)</option> <option data-countryCode="PG" value="675">Papua New Guinea (+675)</option> <option data-countryCode="PY" value="595">Paraguay (+595)</option> <option data-countryCode="PE" value="51">Peru (+51)</option> <option data-countryCode="PH" value="63">Philippines (+63)</option> <option data-countryCode="PL" value="48">Poland (+48)</option> <option data-countryCode="PT" value="351">Portugal (+351)</option> <option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option> <option data-countryCode="QA" value="974">Qatar (+974)</option> <option data-countryCode="RE" value="262">Reunion (+262)</option> <option data-countryCode="RO" value="40">Romania (+40)</option> <option data-countryCode="RU" value="7">Russia (+7)</option> <option data-countryCode="RW" value="250">Rwanda (+250)</option> <option data-countryCode="SM" value="378">San Marino (+378)</option> <option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option> <option data-countryCode="SA" value="966">Saudi Arabia (+966)</option> <option data-countryCode="SN" value="221">Senegal (+221)</option> <option data-countryCode="CS" value="381">Serbia (+381)</option> <option data-countryCode="SC" value="248">Seychelles (+248)</option> <option data-countryCode="SL" value="232">Sierra Leone (+232)</option> <option data-countryCode="SG" value="65">Singapore (+65)</option> <option data-countryCode="SK" value="421">Slovak Republic (+421)</option> <option data-countryCode="SI" value="386">Slovenia (+386)</option> <option data-countryCode="SB" value="677">Solomon Islands (+677)</option> <option data-countryCode="SO" value="252">Somalia (+252)</option> <option data-countryCode="ZA" value="27">South Africa (+27)</option> <option data-countryCode="ES" value="34">Spain (+34)</option> <option data-countryCode="LK" value="94">Sri Lanka (+94)</option> <option data-countryCode="SH" value="290">St. Helena (+290)</option> <option data-countryCode="KN" value="1869">St. Kitts (+1869)</option> <option data-countryCode="SC" value="1758">St. Lucia (+1758)</option> <option data-countryCode="SR" value="597">Suriname (+597)</option> <option data-countryCode="SD" value="249">Sudan (+249)</option> <option data-countryCode="SZ" value="268">Swaziland (+268)</option> <option data-countryCode="SE" value="46">Sweden (+46)</option> <option data-countryCode="CH" value="41">Switzerland (+41)</option> <option data-countryCode="TW" value="886">Taiwan (+886)</option> <option data-countryCode="TJ" value="992">Tajikistan (+992)</option> <option data-countryCode="TH" value="66">Thailand (+66)</option> <option data-countryCode="TG" value="228">Togo (+228)</option> <option data-countryCode="TO" value="676">Tonga (+676)</option> <option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option> <option data-countryCode="TN" value="216">Tunisia (+216)</option> <option data-countryCode="TR" value="90">Turkey (+90)</option> <option data-countryCode="TM" value="993">Turkmenistan (+993)</option> <option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option> <option data-countryCode="TV" value="688">Tuvalu (+688)</option> <option data-countryCode="UG" value="256">Uganda (+256)</option> <option data-countryCode="UA" value="380">Ukraine (+380)</option>  <option data-countryCode="UY" value="598">Uruguay (+598)</option> <option data-countryCode="UZ" value="998">Uzbekistan (+998)</option> <option data-countryCode="VU" value="678">Vanuatu (+678)</option> <option data-countryCode="VA" value="379">Vatican City (+379)</option> <option data-countryCode="VE" value="58">Venezuela (+58)</option> <option data-countryCode="VN" value="84">Vietnam (+84)</option> <option data-countryCode="VG" value="1">Virgin Islands - British (+1)</option> <option data-countryCode="VI" value="1">Virgin Islands - US (+1)</option> <option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option> <option data-countryCode="YE" value="969">Yemen (North)(+969)</option> <option data-countryCode="YE" value="967">Yemen (South)(+967)</option> <option data-countryCode="ZM" value="260">Zambia (+260)</option> <option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
                            </select>
                            
                                <input type="text" value="<?php echo $result -> phone_number;?>" class="form-control" id="phone_number" name="phone_number" placeholder="">
                            </div>
                        </div>
                        
                        
                        <div class="form-group row">
                            <label for="" class="col-12 col-form-label">Price</label>
                            <div class="col-12 price-ui">
                            <select class="currencies" id="currencies" style="width:30px;">
                                                           <option value="AED">AED</option><option value="USD">USD</option><option value="AFN">AFN</option><option value="ALL">ALL</option><option value="DZD">DZD</option><option value="ARS">ARS</option><option value="AUD">AUD</option><option value="ATS">ATS</option><option value="BSD">BSD</option><option value="BHD">BHD</option><option value="BDT">BDT</option><option value="BBD">BBD</option><option value="BEF">BEF</option><option value="BMD">BMD</option><option value="BRL">BRL</option><option value="BGN">BGN</option><option value="CAD">CAD</option><option value="XOF">XOF</option><option value="XAF">XAF</option><option value="CLP">CLP</option><option value="CNY">CNY</option><option value="CNY">CNY</option><option value="COP">COP</option><option value="XPF">XPF</option><option value="CRC">CRC</option><option value="HRK">HRK</option><option value="CYP">CYP</option><option value="CZK">CZK</option><option value="DKK">DKK</option><option value="DEM">DEM</option><option value="DOP">DOP</option><option value="NLG">NLG</option><option value="XCD">XCD</option><option value="EGP">EGP</option><option value="EEK">EEK</option><option value="EUR">EUR</option><option value="FJD">FJD</option><option value="FIM">FIM</option><option value="FRF*">FRF*</option><option value="DEM">DEM</option><option value="XAU">XAU</option><option value="GRD">GRD</option><option value="GTQ">GTQ</option><option value="NLG">NLG</option><option value="HKD">HKD</option><option value="HUF">HUF</option><option value="ISK">ISK</option><option value="XDR">XDR</option><option value="INR">INR</option><option value="IDR">IDR</option><option value="IRR">IRR</option><option value="IQD">IQD</option><option value="IEP*">IEP*</option><option value="ILS">ILS</option><option value="ITL*">ITL*</option><option value="JMD">JMD</option><option value="JPY">JPY</option><option value="JOD">JOD</option><option value="KES">KES</option><option value="KRW">KRW</option><option value="KWD">KWD</option><option value="LBP">LBP</option><option value="LUF">LUF</option><option value="MYR">MYR</option><option value="MTL">MTL</option><option value="MUR">MUR</option><option value="MXN">MXN</option><option value="MAD">MAD</option><option value="NLG">NLG</option><option value="NZD">NZD</option><option value="NOK">NOK</option><option value="OMR">OMR</option><option value="PKR">PKR</option><option value="XPD">XPD</option><option value="PEN">PEN</option><option value="PHP">PHP</option><option value="XPT">XPT</option><option value="PLN">PLN</option><option value="PTE">PTE</option><option value="QAR">QAR</option><option value="RON">RON</option><option value="ROL">ROL</option><option value="RUB">RUB</option><option value="SAR">SAR</option><option value="XAG">XAG</option><option value="SGD">SGD</option><option value="SKK">SKK</option><option value="SIT">SIT</option><option value="ZAR">ZAR</option><option value="KRW">KRW</option><option value="ESP">ESP</option><option value="XDR">XDR</option><option value="LKR">LKR</option><option value="SDD">SDD</option><option value="SEK">SEK</option><option value="CHF">CHF</option><option value="TWD">TWD</option><option value="THB">THB</option><option value="TTD">TTD</option><option value="TND">TND</option><option value="TRY">TRY</option><option value="GBP">GBP</option><option value="USD">USD</option><option value="VEB">VEB</option><option value="VND">VND</option><option value="ZMK">ZMK</option>
                                                            </select>  
                                <input type="text"  value="<?php echo $result -> price;?>" class="form-control" id="price" name="price" placeholder="">
                            </div>
                        </div>
                        
                        
                       
                        <div class="form-group row">
                            <label for="" class="col-12 col-form-label">Description</label>
                            <div class="col-12">
                                <textarea value="" style="height:100px;" class="form-control" id="description" name="description"><?php echo $result -> description;?></textarea>
                            </div>
                        </div>
                        
                        
                        <div class="form-group row n-car">
                            <label for="" class="col-12 col-form-label">Age</label>
                            <div class="col-12">
                                <select  id="id_age" name="age" class="placeholder">
                                    <option value="" >Age</option>
                                    <option <?php if(  $result -> ages == '1' ) {?> selected="selected"  <?php }?> value="1">Brand New</option>
                                    <option  <?php if(  $result -> ages == '2' ) {?> selected="selected"  <?php }?> value="2">0-1 month</option>
                                    <option  <?php if(  $result -> ages == '3' ) {?> selected="selected"  <?php }?> value="3">1-6 months</option>
                                    <option  <?php if(  $result -> ages == '4' ) {?> selected="selected"  <?php }?> value="4">6-12 months</option>
                                    <option  <?php if(  $result -> ages == '5' ) {?> selected="selected"  <?php }?> value="5">1-2 years</option>
                                    <option <?php if(  $result -> ages == '6' ) {?> selected="selected"  <?php }?>  value="6">2-5 years</option>
                                    <option  <?php if(  $result -> ages == '7' ) {?> selected="selected"  <?php }?> value="7">5-10 years</option>
                                    <option  <?php if(  $result -> ages == '8' ) {?> selected="selected"  <?php }?> value="8">10+ years</option>
                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="form-group row  n-car">
                            <label for="" class="col-12 col-form-label">Usage</label>
                            <div class="col-12">
                                <select  id="usage" name="usage" class="placeholder">
                                    <option value="" >Usage</option>
                                    <option  <?php if(  $result -> usage == '1' ) {?> selected="selected"  <?php }?> value="1">Still in original packaging</option>
                                    <option  <?php if(  $result -> usage == '2' ) {?> selected="selected"  <?php }?> value="2">Out of original packaging, but only used once</option>
                                    <option  <?php if(  $result -> usage == '3' ) {?> selected="selected"  <?php }?> value="3">Used only a few times</option>
                                    <option <?php if(  $result -> usage == '4' ) {?> selected="selected"  <?php }?>  value="4">Used an average amount, as frequently as would be expected</option>
                                    <option <?php if(  $result -> usage == '5' ) {?> selected="selected"  <?php }?>  value="5">Used an above average amount since purchased</option>
                                </select>
                            </div>
                        </div>
                        
                         <div class="form-group row">
                            <label for="" class="col-12 col-form-label">Condition</label>
                            <div class="col-12">
                                <select  id="condition" name="condition" class="placeholder">
                                    <option value=""  >Condition</option>
                                    <option  <?php if(  $result -> conditions == '5' ) {?> selected="selected"  <?php }?> value="5">Perfect inside and out</option>
                                    <option  <?php if(  $result -> conditions == '4' ) {?> selected="selected"  <?php }?> value="4">Almost no noticeable problems or flaws</option>
                                    <option  <?php if(  $result -> conditions == '3' ) {?> selected="selected"  <?php }?> value="3">A bit of wear and tear, but in good working condition</option>
                                    <option  <?php if(  $result -> conditions == '2' ) {?> selected="selected"  <?php }?> value="2">Normal wear and tear for the age of the item, a few problems here and there</option>
                                    <option <?php if(  $result -> conditions == '1' ) {?> selected="selected"  <?php }?>  value="1">Above average wear and tear.  The item may need a bit of repair to work properly</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="" class="col-12 col-form-label">Warranty</label>
                            <div class="col-12">
                               <select  id="warranty" name="warranty" class="">
                                <option value=""  disabled="disabled">Warranty</option>
                                <option <?php if(  $result -> warranty == 'Yes' ) {?> selected="selected"  <?php }?>  value="Yes">Yes</option>
                                <option <?php if(  $result -> warranty == 'No' ) {?> selected="selected"  <?php }?>  value="No">No</option>
                                <option <?php if(  $result -> warranty == 'Does not apply' ) {?> selected="selected"  <?php }?>  value="Does not apply">Does not apply</option>
                            </select>
                                               
                            </div>
                        </div>
                        <input type="hidden" id="del_photos" />
                        <?php
							
							$previou_images = ''; $ad_photos = '';
							if( count($classifieds_images ) > 0 )
							{
								
									foreach( $classifieds_images as $obj_added_image )
									{
											$added_image = $obj_added_image -> image;
											$ad_photos .='##'. $added_image;
											$added_image  =  url( '/classifieds/'.  $added_image );
											$ico = url( '/css/ico/symbol-defs.svg' );
											$del = '<svg class="icon icon-delete"><use xlink:href="'. $ico  .'#icon-delete"></use></svg>';
											
											$previou_images .= '<div class="col-12 col-md-4 col-ad-image" >';
											$previou_images .= '<a href="javascript:void(0)"  class="sign-card ">';
											$previou_images .= '<span><svg class="icon icon-delete js_remove_image"><use xlink:href="'. $ico  .'#icon-delete"></use></svg></span>';
											$previou_images .= '<img data-src="'.   $obj_added_image -> image  .'" src="'. $added_image.'" alt="ad images">';
											$previou_images .= '</a>';
											$previou_images .= '</div>';
											
											
									}
									$ad_photos = trim( $ad_photos, '##' );
							}
						?>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                         <input type="hidden" id="ad_photos"  value="" name="ad_photos"  />
					     <input type="hidden" id="ad_id_m" value="<?php echo $result -> id;?>" name="ad_id_m"  />

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="button"  data-id="pills-step-3-tab"  class="btn js_next_second  btn-primary">Continue</button>
                            </div>
                        </div>
                    
                </div>
                
                <div class="tab-pane fade" id="pills-step-3" role="tabpanel">
                    <div class="bio">
                    <?php
                   			$cover_image			 = url( '/classifieds/'.  $result -> cover_image );
					?>
                    	<img src="<?php echo $cover_image;?>" width="100%"  />
                        <div class="pro-img-2">Upload cover photo for your ad</div>
                    </div>
                    <span class="btn btn-success fileinput-button"  data-id="pills-step-4-tab" >
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Select file</span>
                        <input id="fileupload" type="file" name="cover_image">
                    </span>
                    <div id="progress" class="progress"><div class="progress-bar progress-bar-success"></div></div>
					<p><a href="" class="text-muted skip-photo js_skip">Skip</a></p>

                </div>
                
                <div class="tab-pane fade" id="pills-step-4" role="tabpanel">
                    <p class="lead">Add More Photos </p>
                    <p>Try to add photos from different angles</p>
                    		
                           
                         <div class="form-group row ">
                            <div class="col-12">
                               	<div class="row"><?php echo $previou_images;?> </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group row d-zone">
                            <div class="col-12">
                               
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn js_submit_ad btn-primary">Confirm &amp; Submit</button>
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
    </main>


