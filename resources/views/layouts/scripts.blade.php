@auth
<script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="/js/tinymce/ar.js"></script>
@endauth
<script type="module">
@if(auth()->check())

    tinymce.init({
        selector: '.editor,#editor',
        plugins: ' advlist autolink directionality table wordcount link lists numlist bullist',
        directionality : '{{ app()->getLocale() == "ar" ? "rtl" : "ltr"}}',
        language:'{{ app()->getLocale()}}',
        quickbars_selection_toolbar: 'bold italic |h1 h2 h3 h4 h5 h6| formatselect | quicklink blockquote | numlist bullist',
        entity_encoding : "raw",
        verify_html : false 
    });
@else 
/* Guest Js */


@endif

 toastr.options = {
        closeButton: true,
        debug: false,
        onclick: null,
        showDuration: 300,
        hideDuration: 1000,
        extendedTimeOut: 1000,
        showEasing: 'swing',
        hideEasing: 'linear',
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut',
        progressBar:true,
        preventDuplicates:true,
        newestOnTop:true,
        positionClass: '{{ app()->getLocale() == "ar" ? "toast-top-left" : "toast-top-right"}}',
        timeOut:10000
    }

    @if($errors->any())
        @foreach($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif

    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

   

</script>
