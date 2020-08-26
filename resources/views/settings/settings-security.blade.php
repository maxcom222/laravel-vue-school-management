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
                              <label for="" class="col-4 col-form-label">Current Password</label> 
                              <div class="col-8">
                                <input id="current_password" name="" class="form-control form-control-sm" type="password">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="" class="col-4 col-form-label">New Password</label> 
                              <div class="col-8">
                                <input id="new_password" name="" class="form-control form-control-sm" type="password">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Confirm Password</label> 
                              <div class="col-8">
                                <input id="confirm_password" name="" class="form-control form-control-sm" type="password">
                              </div>
                            </div>
                            <div class="form-group row d-none">
                              <label for="" class="col-4 col-form-label">Security Question</label> 
                              <div class="col-8">
                                <input  class="form-control form-control-sm" type="text">
                              </div>
                            </div>
                            <div class="form-group row  d-none">
                                <label for="phone" class="col-4 col-form-label">Security Answer</label> 
                                <div class="col-8">
                                  <input  class="form-control form-control-sm" type="text">
                                </div>
                              </div>
                              <div class="form-group row ">
                                <div class="offset-4 col-8">
                                  <button name="submit" type="button" class="btn btn-sm btn-primary js_save_p">Save</button>
                                </div>
                              </div>
                          </form>                          
                    </div>
                </div>

                <div class="col-12 col-md-3 col-right">
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




