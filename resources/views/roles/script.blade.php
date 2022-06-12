<script>
    let urldatatable = "{{ route('roles.loadDatatable') }}";
    let language ="{{app()->getLocale()}}";
    let title = "{{ __('Roles') }}";
    let required = "{{ __('This camp is required') }}";
    let questiondelete = "{{ __('Do you want to delete this record?') }}";
</script>
<script src="assets/js/app/init.roles.js"></script>