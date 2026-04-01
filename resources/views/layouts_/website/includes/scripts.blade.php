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
       <?php  session()->flash('message', __('Please log in to add to wishlist.')); ?>
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
            alert(data);
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