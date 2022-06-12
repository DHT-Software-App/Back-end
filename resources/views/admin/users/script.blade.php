<script>
    let urldatatable = "{{ route('users.loadDatatable') }}";
    let language ="{{app()->getLocale()}}";
    let title = "{{ __('Users') }}";
    let required = "{{ __('This camp is required') }}";
    let questiondelete = "{{ __('Do you want to delete this record?') }}";
</script>
<script src="assets/js/app/init.users.js"></script>