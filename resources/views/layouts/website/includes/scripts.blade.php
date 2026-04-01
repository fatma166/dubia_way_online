<script src="{{asset('website/assets/js/jquery-1.12.4.min.js')}}"></script>
<script src="{{asset('website/assets/js/jquery.plugin-countdown.min.js')}}"></script>
<script src="{{asset('website/assets/js/jquery-countdown.min.js')}}"></script>
<script src="{{asset('website/assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('website/assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('website/assets/js/magnific-popup.min.js')}}"></script>
<script src="{{asset('website/assets/js/isotope.min.js')}}"></script>
<script src="{{asset('website/assets/js/jquery.scrollbar.min.js')}}"></script>
<script src="{{asset('website/assets/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('website/assets/js/mobile-menu.js')}}"></script>
<script src="{{asset('website/assets/js/chosen.min.js')}}"></script>
<script src="{{asset('website/assets/js/slick.js')}}"></script>
<script src="{{asset('website/assets/js/jquery.elevateZoom.min.js')}}"></script>
<script src="{{asset('website/assets/js/jquery.actual.min.js')}}"></script>
<script src="{{asset('website/assets/js/fancybox/source/jquery.fancybox.js')}}"></script>
<script src="{{asset('website/assets/js/lightbox.min.js')}}"></script>
<script src="{{asset('website/assets/js/owl.thumbs.min.js')}}"></script>
<script src="{{asset('website/assets/js/jquery.scrollbar.min.js')}}"></script>
<script src="{{asset('website/assets/js/frontend-plugin.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
        function add_delete_fav(event, product_id) {
    // Prevent the default action of the link
    event.preventDefault();
    // Check if user is logged in
    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

    if (!isLoggedIn) {
        // Redirect to login page if not logged in
        window.location.href = '{{ route('auth.login') }}'; // Adjust the route as necessary
        return;
    }
    $.ajax({
        url: '{{ route('add_delete_fav') }}', // Adjust the URL to your API endpoint
        method: 'POST',
         headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Set the CSRF token
    },
        data: { "product_id": product_id },
        success: function(data) {
            if (data == 1) {
                Swal.fire({
                    title: '{{ __('Added to wishlist successfully!') }}',
                    text: 'success',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'custom-swal' // Apply the custom class to the popup
                    }
                });
            } else {
                Swal.fire({
                    title: '{{ __('Product removed from wishlist') }}',
                    text: 'success',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'custom-swal' // Apply the custom class to the popup
                    }
                });
            }
        },
        error: function() {
            // Handle error
            Swal.fire({
                title: '{{ __('Error!') }}',
                text: 'An error occurred',
                icon: 'error',
                confirmButtonText: '{{ __('Okay') }}'
            });
        }
    });
}



</script>


<!-- TikTok Pixel Code Start -->
<script>
!function (w, d, t) {
  w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie","holdConsent","revokeConsent","grantConsent"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(
var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var r="https://analytics.tiktok.com/i18n/pixel/events.js",o=n&&n.partner;ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=r,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};n=document.createElement("script")
;n.type="text/javascript",n.async=!0,n.src=r+"?sdkid="+e+"&lib="+t;e=document.getElementsByTagName("script")[0];e.parentNode.insertBefore(n,e)};

  ttq.load('D4U3AIRC77U2FI26UQR0');
  ttq.page();
}(window, document, 'ttq');
</script>
<!-- TikTok Pixel Code End -->