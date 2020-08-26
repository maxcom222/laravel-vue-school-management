

<main class="authorize register">
        <div class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>

  <div class="user-box"> <input type="hidden" id="login_page" value="1" /><a href=""><img src="{{ asset('css/img/logoa.png') }}" alt="Expats' Schools Logo"></a>
    <ul class="nav nav-pills" id="pills-tab" role="tablist">
      <li class="nav-item"> <a class="active" id="pills-login-tab" data-toggle="pill" href="#pills-login" role="tab" aria-controls="pills-login" aria-selected="true">Login</a> </li>
      <li class="nav-item"> <a class="" id="pills-register-tab" data-toggle="pill" href="#pills-register" role="tab" aria-controls="pills-register" aria-selected="false">Register</a> </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">
        <form id="login_form">
          <div class="form-group row">
          
            <div class="col-12 col-sm-6  d-none">
              <button type="button" class="btn btn-fb js_fb_login_d"><svg class="icon icon-facebook">
              <use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-facebook"></use>
              </svg> Login with facebook</button>
            </div>
            <div class="col-12 col-sm-6 d-none">
              <button type="button" class="btn btn-gogl js_google_login"><svg class="icon icon-google-plus">
              <use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-google-plus"></use>
              </svg> Login with Google</button>
            </div>
          </div>
          <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
              <input type="email" class="form-control js_email"  placeholder="Email">
            </div>
          </div>
          <div class="form-group row">
            <label for="password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
              <input type="password" class="form-control js_password"  placeholder="Password">
            </div>
          </div>
           <div class="form-group row">
          	 <label for="forgot" class="col-sm-2 col-form-label"></label>
              <div class="col-sm-10"><p>Forgot password? <a href="" class="js_show_reset">Reset</a> here.</p></div>
           </div>
           
          
          
          
          <div class="form-group row">
            <div class="col-sm-12">
              <button type="button" class="btn btn-primary js_login">Login</button>
              <p>Don't have an account? <a href="" class="js_show_register">Register</a> now.</p>
            </div>
          </div>
        </form>
        
        
         <form class="reset_password_form d-none" id="reset_password_form" >
         
          <div class="form-group row">
          <label for="email" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
              <p>Enter your email to receive reset password instruction</p>
            </div>
          </div>
          <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
              <input type="email" class="form-control js_email"  placeholder="Email">
            </div>
          </div>
          
         
          <div class="form-group row">
            <div class="col-sm-12">
              <button type="button" class="btn btn-primary js_reset_password">Submit</button>
              <p>go back to login <a href="" class="js_show_login">Login here</a></p>
            </div>
          </div>
		</form>
        
        
        
        
        
      </div>
      <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="pills-register-tab">
        <form>
          <div class="form-group row">
          <div class="col-12 col-sm-12">
          	<h2 class="expat-teacher-register text-center">Please enter your<span style="color:#01ae79;"> personal email address </span> and we will send you a <span style="color:#01ae79;"> verification code</span></p>
          </div>
          
          
            <div class="col-12 col-sm-6 d-none">
              <button type="button" class="btn btn-fb js_fb_login_d"><svg class="icon icon-facebook">
              <use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-facebook"></use>
              </svg> Register with facebook</button>
            </div>
            <div class="col-12 col-sm-6 d-none">
              <button type="button" class="btn btn-gogl js_google_login"><svg class="icon icon-google-plus">
              <use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-google-plus"></use>
              </svg> Register with Google</button>
            </div>
          </div>
          <div class="form-group row">
            <label for="email" class="col-sm-12 col-form-label">Personal Email (NOT your school email)</label>
            <div class="col-sm-12">
              <input type="email" class="form-control js_email" placeholder="">
            </div>
          </div>
          
          <div class="form-group row js_school_email d-none">
            <label for="email" class="col-sm-4 col-form-label">School Email</label>
            <div class="col-sm-6">
              <input type="text" class="form-control school-name js_school_email_aname split-fields-width-30" placeholder="Email">
              <select id="js_school_domain" class="js_school_domain split-fields-width-70">
                
              </select>
            </div>
          </div>
          
          
          <div class="form-group row">
            <label for="password" class="col-sm-12 col-form-label">Password</label>
            <div class="col-sm-12">
              <input type="password" class="form-control js_password" placeholder="">
            </div>
          </div>
          <div class="form-group row">
            <label for="password2" class="col-sm-12 col-form-label">Confirm Password</label>
            <div class="col-sm-12">
              <input type="password" class="form-control js_password_confirm"  placeholder="">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-12">
              <button type="button" class="btn btn-primary js_register">Register</button>
              <p>Already a member? <a href="" class="js_show_login">Login</a> here.</p>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>

