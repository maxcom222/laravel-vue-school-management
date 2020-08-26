
<main class="authorize profile-wizard-page">
        <div class="user-box">
            <a href=""><img src="{{ asset('css/img/logoa.png') }}" alt="Expats logo"></a>
            <ul class="nav nav-wizard" id="pills-tab" role="tablist">
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
                    <p class="lead">Let's start your profile, connect to the people you know and engage with the institutes you care about.</p>
                    <form>
                       
                        <?php
						
							$last_name = ''; $first_name = '';
							if ( Session::has('user')  )
							{
								$user = Session::get('user');
								if( $user -> first_name != '' )
								{
									$first_name = $user -> first_name;
								}
								if( $user -> first_name != '' )
								{
									$last_name = $user -> last_name;
								}
							}
									?>
                                    <div class="form-group row">
                                        <label for="" class="col-12 col-form-label">First Name</label>
                                        <div class="col-12">
                                            <input type="text" value="<?php echo $first_name;?>" class="form-control" id="first_name" name="first_name" placeholder="">
                                        </div>
                                    </div>
                                    
                               
                                    <div class="form-group row">
                                        <label for="" class="col-12 col-form-label">Last Name</label>
                                        <div class="col-12">
                                            <input type="text" value="<?php echo $last_name;?>"  class="form-control" id="last_name" name="last_name" placeholder="">
                                        </div>
                                    </div>
                                    
                                 
                       
                       
                       
                       
                       
                        <div class="form-group row">
                            <label for="email" class="col-12 col-form-label">Country/Region</label>
                            <div class="col-12">
                                <select tabindex="-1" id="country"  style="width: 100%">
                                    <option value="AF">Afghanistan</option>
                                    <option value="AX">Åland Islands</option>
                                    <option value="AL">Albania</option>
                                    <option value="DZ">Algeria</option>
                                    <option value="AS">American Samoa</option>
                                    <option value="AD">Andorra</option>
                                    <option value="AO">Angola</option>
                                    <option value="AI">Anguilla</option>
                                    <option value="AQ">Antarctica</option>
                                    <option value="AG">Antigua and Barbuda</option>
                                    <option value="AR">Argentina</option>
                                    <option value="AM">Armenia</option>
                                    <option value="AW">Aruba</option>
                                    <option value="AU">Australia</option>
                                    <option value="AT">Austria</option>
                                    <option value="AZ">Azerbaijan</option>
                                    <option value="BS">Bahamas</option>
                                    <option value="BH">Bahrain</option>
                                    <option value="BD">Bangladesh</option>
                                    <option value="BB">Barbados</option>
                                    <option value="BY">Belarus</option>
                                    <option value="BE">Belgium</option>
                                    <option value="BZ">Belize</option>
                                    <option value="BJ">Benin</option>
                                    <option value="BM">Bermuda</option>
                                    <option value="BT">Bhutan</option>
                                    <option value="BO">Bolivia, Plurinational State of</option>
                                    <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                    <option value="BA">Bosnia and Herzegovina</option>
                                    <option value="BW">Botswana</option>
                                    <option value="BV">Bouvet Island</option>
                                    <option value="BR">Brazil</option>
                                    <option value="IO">British Indian Ocean Territory</option>
                                    <option value="BN">Brunei Darussalam</option>
                                    <option value="BG">Bulgaria</option>
                                    <option value="BF">Burkina Faso</option>
                                    <option value="BI">Burundi</option>
                                    <option value="KH">Cambodia</option>
                                    <option value="CM">Cameroon</option>
                                    <option value="CA">Canada</option>
                                    <option value="CV">Cape Verde</option>
                                    <option value="KY">Cayman Islands</option>
                                    <option value="CF">Central African Republic</option>
                                    <option value="TD">Chad</option>
                                    <option value="CL">Chile</option>
                                    <option value="CN">China</option>
                                    <option value="CX">Christmas Island</option>
                                    <option value="CC">Cocos (Keeling) Islands</option>
                                    <option value="CO">Colombia</option>
                                    <option value="KM">Comoros</option>
                                    <option value="CG">Congo</option>
                                    <option value="CD">Congo, the Democratic Republic of the</option>
                                    <option value="CK">Cook Islands</option>
                                    <option value="CR">Costa Rica</option>
                                    <option value="CI">Côte d'Ivoire</option>
                                    <option value="HR">Croatia</option>
                                    <option value="CU">Cuba</option>
                                    <option value="CW">Curaçao</option>
                                    <option value="CY">Cyprus</option>
                                    <option value="CZ">Czech Republic</option>
                                    <option value="DK">Denmark</option>
                                    <option value="DJ">Djibouti</option>
                                    <option value="DM">Dominica</option>
                                    <option value="DO">Dominican Republic</option>
                                    <option value="EC">Ecuador</option>
                                    <option value="EG">Egypt</option>
                                    <option value="SV">El Salvador</option>
                                    <option value="GQ">Equatorial Guinea</option>
                                    <option value="ER">Eritrea</option>
                                    <option value="EE">Estonia</option>
                                    <option value="ET">Ethiopia</option>
                                    <option value="FK">Falkland Islands (Malvinas)</option>
                                    <option value="FO">Faroe Islands</option>
                                    <option value="FJ">Fiji</option>
                                    <option value="FI">Finland</option>
                                    <option value="FR">France</option>
                                    <option value="GF">French Guiana</option>
                                    <option value="PF">French Polynesia</option>
                                    <option value="TF">French Southern Territories</option>
                                    <option value="GA">Gabon</option>
                                    <option value="GM">Gambia</option>
                                    <option value="GE">Georgia</option>
                                    <option value="DE">Germany</option>
                                    <option value="GH">Ghana</option>
                                    <option value="GI">Gibraltar</option>
                                    <option value="GR">Greece</option>
                                    <option value="GL">Greenland</option>
                                    <option value="GD">Grenada</option>
                                    <option value="GP">Guadeloupe</option>
                                    <option value="GU">Guam</option>
                                    <option value="GT">Guatemala</option>
                                    <option value="GG">Guernsey</option>
                                    <option value="GN">Guinea</option>
                                    <option value="GW">Guinea-Bissau</option>
                                    <option value="GY">Guyana</option>
                                    <option value="HT">Haiti</option>
                                    <option value="HM">Heard Island and McDonald Islands</option>
                                    <option value="VA">Holy See (Vatican City State)</option>
                                    <option value="HN">Honduras</option>
                                    <option value="HK">Hong Kong</option>
                                    <option value="HU">Hungary</option>
                                    <option value="IS">Iceland</option>
                                    <option value="IN">India</option>
                                    <option value="ID">Indonesia</option>
                                    <option value="IR">Iran, Islamic Republic of</option>
                                    <option value="IQ">Iraq</option>
                                    <option value="IE">Ireland</option>
                                    <option value="IM">Isle of Man</option>
                                    <option value="IL">Israel</option>
                                    <option value="IT">Italy</option>
                                    <option value="JM">Jamaica</option>
                                    <option value="JP">Japan</option>
                                    <option value="JE">Jersey</option>
                                    <option value="JO">Jordan</option>
                                    <option value="KZ">Kazakhstan</option>
                                    <option value="KE">Kenya</option>
                                    <option value="KI">Kiribati</option>
                                    <option value="KP">Korea, Democratic People's Republic of</option>
                                    <option value="KR">Korea, Republic of</option>
                                    <option value="KW">Kuwait</option>
                                    <option value="KG">Kyrgyzstan</option>
                                    <option value="LA">Lao People's Democratic Republic</option>
                                    <option value="LV">Latvia</option>
                                    <option value="LB">Lebanon</option>
                                    <option value="LS">Lesotho</option>
                                    <option value="LR">Liberia</option>
                                    <option value="LY">Libya</option>
                                    <option value="LI">Liechtenstein</option>
                                    <option value="LT">Lithuania</option>
                                    <option value="LU">Luxembourg</option>
                                    <option value="MO">Macao</option>
                                    <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                                    <option value="MG">Madagascar</option>
                                    <option value="MW">Malawi</option>
                                    <option value="MY">Malaysia</option>
                                    <option value="MV">Maldives</option>
                                    <option value="ML">Mali</option>
                                    <option value="MT">Malta</option>
                                    <option value="MH">Marshall Islands</option>
                                    <option value="MQ">Martinique</option>
                                    <option value="MR">Mauritania</option>
                                    <option value="MU">Mauritius</option>
                                    <option value="YT">Mayotte</option>
                                    <option value="MX">Mexico</option>
                                    <option value="FM">Micronesia, Federated States of</option>
                                    <option value="MD">Moldova, Republic of</option>
                                    <option value="MC">Monaco</option>
                                    <option value="MN">Mongolia</option>
                                    <option value="ME">Montenegro</option>
                                    <option value="MS">Montserrat</option>
                                    <option value="MA">Morocco</option>
                                    <option value="MZ">Mozambique</option>
                                    <option value="MM">Myanmar</option>
                                    <option value="NA">Namibia</option>
                                    <option value="NR">Nauru</option>
                                    <option value="NP">Nepal</option>
                                    <option value="NL">Netherlands</option>
                                    <option value="NC">New Caledonia</option>
                                    <option value="NZ">New Zealand</option>
                                    <option value="NI">Nicaragua</option>
                                    <option value="NE">Niger</option>
                                    <option value="NG">Nigeria</option>
                                    <option value="NU">Niue</option>
                                    <option value="NF">Norfolk Island</option>
                                    <option value="MP">Northern Mariana Islands</option>
                                    <option value="NO">Norway</option>
                                    <option value="OM">Oman</option>
                                    <option value="PK">Pakistan</option>
                                    <option value="PW">Palau</option>
                                    <option value="PS">Palestinian Territory, Occupied</option>
                                    <option value="PA">Panama</option>
                                    <option value="PG">Papua New Guinea</option>
                                    <option value="PY">Paraguay</option>
                                    <option value="PE">Peru</option>
                                    <option value="PH">Philippines</option>
                                    <option value="PN">Pitcairn</option>
                                    <option value="PL">Poland</option>
                                    <option value="PT">Portugal</option>
                                    <option value="PR">Puerto Rico</option>
                                    <option value="QA">Qatar</option>
                                    <option value="RE">Réunion</option>
                                    <option value="RO">Romania</option>
                                    <option value="RU">Russian Federation</option>
                                    <option value="RW">Rwanda</option>
                                    <option value="BL">Saint Barthélemy</option>
                                    <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                                    <option value="KN">Saint Kitts and Nevis</option>
                                    <option value="LC">Saint Lucia</option>
                                    <option value="MF">Saint Martin (French part)</option>
                                    <option value="PM">Saint Pierre and Miquelon</option>
                                    <option value="VC">Saint Vincent and the Grenadines</option>
                                    <option value="WS">Samoa</option>
                                    <option value="SM">San Marino</option>
                                    <option value="ST">Sao Tome and Principe</option>
                                    <option value="SA">Saudi Arabia</option>
                                    <option value="SN">Senegal</option>
                                    <option value="RS">Serbia</option>
                                    <option value="SC">Seychelles</option>
                                    <option value="SL">Sierra Leone</option>
                                    <option value="SG">Singapore</option>
                                    <option value="SX">Sint Maarten (Dutch part)</option>
                                    <option value="SK">Slovakia</option>
                                    <option value="SI">Slovenia</option>
                                    <option value="SB">Solomon Islands</option>
                                    <option value="SO">Somalia</option>
                                    <option value="ZA">South Africa</option>
                                    <option value="GS">South Georgia and the South Sandwich Islands</option>
                                    <option value="SS">South Sudan</option>
                                    <option value="ES">Spain</option>
                                    <option value="LK">Sri Lanka</option>
                                    <option value="SD">Sudan</option>
                                    <option value="SR">Suriname</option>
                                    <option value="SJ">Svalbard and Jan Mayen</option>
                                    <option value="SZ">Swaziland</option>
                                    <option value="SE">Sweden</option>
                                    <option value="CH">Switzerland</option>
                                    <option value="SY">Syrian Arab Republic</option>
                                    <option value="TW">Taiwan, Province of China</option>
                                    <option value="TJ">Tajikistan</option>
                                    <option value="TZ">Tanzania, United Republic of</option>
                                    <option value="TH">Thailand</option>
                                    <option value="TL">Timor-Leste</option>
                                    <option value="TG">Togo</option>
                                    <option value="TK">Tokelau</option>
                                    <option value="TO">Tonga</option>
                                    <option value="TT">Trinidad and Tobago</option>
                                    <option value="TN">Tunisia</option>
                                    <option value="TR">Turkey</option>
                                    <option value="TM">Turkmenistan</option>
                                    <option value="TC">Turks and Caicos Islands</option>
                                    <option value="TV">Tuvalu</option>
                                    <option value="UG">Uganda</option>
                                    <option value="UA">Ukraine</option>
                                    <option value="AE">United Arab Emirates</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="US">United States</option>
                                    <option value="UM">United States Minor Outlying Islands</option>
                                    <option value="UY">Uruguay</option>
                                    <option value="UZ">Uzbekistan</option>
                                    <option value="VU">Vanuatu</option>
                                    <option value="VE">Venezuela, Bolivarian Republic of</option>
                                    <option value="VN">Viet Nam</option>
                                    <option value="VG">Virgin Islands, British</option>
                                    <option value="VI">Virgin Islands, U.S.</option>
                                    <option value="WF">Wallis and Futuna</option>
                                    <option value="EH">Western Sahara</option>
                                    <option value="YE">Yemen</option>
                                    <option value="ZM">Zambia</option>
                                    <option value="ZW">Zimbabwe</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-12 col-form-label">City</label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="city" name="city" placeholder="">
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
                    
                </div>
                
                
                
              
                
                
                
                
                
                
                <div class="tab-pane fade" id="pills-step-3" role="tabpanel" >
                
                    <div class="bio">
                        <p class="lead js_d_name "></p>
                        <p class="js_prop js_school_name  d-none"><span class="js_school_name"></span></p>
                        <span class="text-muted loc-name d-none"></span>
                        <p class="lead mg-bottom-10">Please provide us a mug shot for your Profile</p>
                        <p><small>Please upload upto 1MB file. File size more than 1MB might result in errors</small></p>
                    </div>
                    
                     <div class="pro-img">
                        		<img id="drag-image2" src="{{ asset('css/img/user-img.png') }}" alt="User Profile Photo">
                        </div>
                        
                        
                    <span class="btn btn-success fileinput-button "  data-id="pills-step-4-tab" >
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Select file</span>
                        <!-- The file input field used as target for the file upload widget -->
                        <input id="fileupload" type="file"  onchange="readURL(this);" name="profile_image">
                    </span>
                    <br /><br />
                    
                    
                    <div id="controls" class="text-center d-none">
                      <button id='js_rotate_left'  type='button' title='Rotate left'> <i class="glyphicon glyphicon-repeat lft-icon"></i> </button>
                      <button id='js_zoom_out'     type='button' title='Zoom out'>  <i class="glyphicon glyphicon-zoom-out"></i> </button>
                      <button id='js_fit'          type='button' title='Fit image'> <i class="glyphicon glyphicon-home"></i></button>
                      <button id='js_zoom_in'      type='button' title='Zoom in'> <i class="glyphicon glyphicon-zoom-in"></i> </button>
                      <button id='js_rotate_right' type='button' title='Rotate right'>  <i class="glyphicon glyphicon-repeat"></i></button>
                    </div>
                    
      					 
                    
                    <button type="button"  data-id="pills-step-4-tab" id="add_photo"  class="btn btn-primary d-none">Add Photo</button>
                    
                    <div id="progress" class="progress d-none"><div class="progress-bar progress-bar-success"></div></div>
                    <p><a href="" class="text-muted skip-photo d-none js_skip">Skip</a></p>
                </div>
                
                
                
                  
                
                
                <div class="tab-pane fade" id="pills-step-4" role="tabpanel">
                    <p class="lead">Let's confirm your email</p>
                    <p>We have sent a code to you. Enter the code below to confirm you have access to this email.</p>
                    
                        <div class="form-group row">
                            <div class="col-12">
                            	<label>Verification Code</label>
                                <input type="text" class="form-control" id="verification_code" name="verification_code" placeholder="">
                            </div>
                        </div>
                        
                         <div class="form-group row v-c-s d-none">
                            <div class="col-12">
                            	<label>Verification Code ( School Email Address )</label>
                                <input type="text" class="form-control" id="verification_code_school" name="verification_code_school" placeholder="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="button" class="btn js_confirm_email btn-primary">Confirm</button>
                            </div>
                        </div>
                    
                    <p>Code invalid or didn’t receive it?<a class="js_send_code" href="">Send again</a></p>
                </div>
                
                
                
                
                
            </div>
        </div>
    </main>

