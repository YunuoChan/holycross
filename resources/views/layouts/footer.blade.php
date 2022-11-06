


<section>
  <!-- Site footer -->
  <footer class="site-footer">
      <div class="container">
     
          <div class="row">
              <div class="col-sm-12 col-md-6">
                  <h6>Holy Cross College</h6>
                  <p class="text-justify">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
              </div>

              <div class="col-xs-6 col-md-3">
                  <h6>Teacher</h6>
                  <ul class="footer-links">
                      <li><a href="#">My Schedule</a></li>
                      @if (Route::has('login'))
                          @auth
                              <li><a href="{{ url('/home') }}">Home</a></li>
                          @else
                              <li><a href="{{ route('login') }}">Log in</a></li>
                              @if (Route::has('register'))
                                  <li><a href="{{ route('register') }}">Register</a></li>
                              @endif
                          @endauth
                      @endif
                      <li><a href="#">How It Works?</a></li>
                      
                  </ul>
              </div>

              <div class="col-xs-6 col-md-3">
                  <h6>I am Student</h6>
                  <ul class="footer-links">
                      <li><a href="#">My Schedule</a></li>
                      <li><a href="#">Register</a></li>
                      <li><a href="#">How It Works?</a></li>
                  </ul>
              </div>
          </div>

          <div style="width: 100%; margin-top: 15px;">
              <h6>We Are Here!</h6>
              <iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=300&amp;hl=en&amp;q=Holy%20Cross%20College,%20Sta%20Rosa,%20NE+(My%20Business%20Name)&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a href="https://www.maps.ie/distance-area-calculator.html">measure area map</a>
              </iframe>
          </div>
          <hr>
      </div>
      <div class="container">
          <div class="row">
              <div class="col-md-8 col-sm-6 col-xs-12">
                  <p class="copyright-text">Copyright &copy; 2022 All Rights Reserved by 
              <a href="#">Holy Cross College</a>.
                  </p>
              </div>

              <div class="col-md-4 col-sm-6 col-xs-12">
                  <ul class="social-icons">
                      <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                      <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                      <li><a class="dribbble" href="#"><i class="fa fa-dribbble"></i></a></li>
                      <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>   
                  </ul>
              </div>
          </div>
      </div>
      
  </footer>
</section>