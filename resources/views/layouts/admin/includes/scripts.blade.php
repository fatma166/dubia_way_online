
<!-- Sweet Alerts js -->
{{--<script src="{{asset('assets/libs/sweetalert2/sweetalert2.all.min.js')}}"></script>--}}
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- Vendor js -->
<script src="{{asset('assets/js/vendor.min.js')}}"></script>
<!-- App js -->
<script src="{{asset('assets/js/app.min.js')}}"></script>
<!-- Plugins js-->
<script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/libs/selectize/js/standalone/selectize.min.js')}}"></script>
<script src="{{asset('assets/libs/mohithg-switchery/switchery.min.js')}}"></script>
<script src="{{asset('assets/libs/multiselect/js/jquery.multi-select.js')}}"></script>
<script src="{{asset('assets/libs/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/libs/jquery-mockjax/jquery.mockjax.min.js')}}"></script>
<script src="{{asset('assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
<script src="{{asset('assets/libs/dropzone/min/dropzone.min.js')}}"></script>
<script src="{{asset('assets/libs/dropify/js/dropify.min.js')}}"></script>
<!-- Init js-->
<script src="{{asset('assets/js/pages/form-fileuploads.init.js')}}"></script>
<script src="{{asset('assets/js/pages/form-advanced.init.js')}}"></script>
<!-- Dashboar 1 init js-->
<script src="{{asset('assets/js/pages/dashboard-1.init.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script>
/*
    $("select.select2, .select2").select2();

    $("select.select2[multiple]").select2({
        placeholder: $(this).data('placeholder'),
    });

    $("input[data-toggle='flatpicker']").flatpickr();*/
</script>
<script>
    /*
    @if(session()->has('success'))
   /* Swal.fire({
        title: "{{ session()->get('success') }}",
        icon: "success",
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
    });*/
    @endif
    @if(session()->has('error'))
  /*  Swal.fire({
        title: "{{ session()->get('error') }}",
        icon: "error",
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
    });*/

    @endif

    /*function deleteDoc(form_id) {
        Swal.fire({
            title: '{{__("Are you sure?")}}',
            icon: "warning",
            confirmButtonText: "{{__("Yes, delete it!")}}",
            cancelButtonText: "{{__("cancel")}}",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                $(document).find("#" + form_id).submit();
            }
        })
    }

    function darkModeToggle() {
        $("#dark-mode-toggle-form").submit();
    }


    $('.scrollspy-example').each((index)=>{
        new SimpleBar($('.scrollspy-example')[index]);
    });

    function selectpatientdoctor(type){
        if(type=="doctor")placeholder='{{__('search doctor')}}';
        if(type=="patient")placeholder='{{__('search patient')}}';
        $('#'+type).select2({
            minimumInputLength: 3,
            //placeholder: placeholder,
            ajax: {
                url:"route('SelectUserAjax')",
                dataType: 'json',
                delay: 250,

                data: function (term) {

                    console.log(term);
                    return {
                        q: term, // search term
                        type:'"'+type+'"', //Get your value from other elements using Query, for example.

                    };
                },
                processResults: function (data) {
                    console.log(data);
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.full_name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

    }
    $( document ).ready(function() {
        let searchParams = new URLSearchParams(window.location.search);
        if( searchParams.has('patient_id')==true){
            patient_id= searchParams.get(' patient_id');
            $("select[name='patient_id']").val(patient_id);
        }
        if( searchParams.has('doctor_id')==true){
            doctor_id= searchParams.get('doctor_id');
            $("select[name='doctor_id']").val(doctor_id);
        }

    });
*/


</script>
<style>
  /*  .swal-footer {
        text-align: center;
    }*/
</style>
