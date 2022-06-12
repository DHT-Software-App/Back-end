<script>
    let urldatatable = "{{ route('customers.loadDatatable') }}";
    let language ="{{app()->getLocale()}}";
    let title = "{{ __('Customers') }}";
    let required = "{{ __('This camp is required') }}";
    let questiondelete = "{{ __('Do you want to delete this record?') }}";
</script>
<script src="assets/js/app/init.customers.js"></script>