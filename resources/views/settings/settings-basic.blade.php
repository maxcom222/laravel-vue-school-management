 <?php
 
 $first_name  = ''; $last_name = ''; $email = ''; $contact_number = '';
 
	if (Session::has('user'))
	{
			$user = Session::get('user');
			$first_name 	 = $user -> first_name;
			$last_name   	 = $user -> last_name;
			$email  	 	 = $user -> email;
			$contact_number  = $user -> contact_number;
			 
	}
?>
<header style="opacity:0;"></header>
    <main class="two-cloumn">
        <div class="container">

            <div class="row">
                <div class="col-12 col-md-3 col-left">
                      @include("layout/settings")
                </div>
                <div class="col-12 col-md-6">                    
                    <div class="feed">
                        <form>
                            <div class="form-group row">
                              <label for="first-name" class="col-4 col-form-label">First Name</label> 
                              <div class="col-8">
                                <input id="first-name" value="<?php echo $first_name;?>" name="first-name" class="form-control form-control-sm" type="text">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="last-name" class="col-4 col-form-label">Last Name</label> 
                              <div class="col-8">
                                <input id="last-name" value="<?php echo $last_name;?>" name="last-name" class="form-control form-control-sm" type="text">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="email" class="col-4 col-form-label">Email</label> 
                              <div class="col-8">
                                <input id="email"  value="<?php echo $email;?>"  name="email" class="form-control form-control-sm" type="text">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="phone" class="col-4 col-form-label">Phone</label> 
                              <div class="col-8">
                                <input id="phone" value="<?php echo $contact_number;?>"   name="phone" class="form-control form-control-sm" type="text">
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="offset-4 col-8">
                                <button name="submit" type="button" class="btn btn-sm btn-primary js_save_basic_information">Save</button>
                              </div>
                            </div>
                            
                            <br /><Br />
                            <p>Closing Your Account:</p>
                            <p>By closing your account, you will be logged out of expatsschools.com and your account will be removed.</p>
                           
                            <div class="form-group row">
                              <div class="offset-4 col-8">
                                <button name="close" type="button" class="btn btn-sm btn-primary js_close_account">Close your account</button>
                              </div>
                            </div>
                          </form>                          
                    </div>
                </div>

                <div class="col-12 col-md-3 col-right set-help">
                    <div class="frame recommendations">
                       
                        <div class="footer">
                            <a href="{{ url('about') }}">About</a> <span>·</span>
                            <a href="{{ url('help') }}">Help Center</a> <span>·</span>
                            <a href="{{ url('privacy') }}">Privacy Policy</a> <span>·</span>
                            <a href="{{ url('terms') }}">Term &amp; Conditions</a> <span>·</span>
                            <small>© <?php echo date('Y');?>. All Rights Reserved.</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

