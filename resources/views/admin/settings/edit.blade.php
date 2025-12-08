<x-admin-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/admin/js/collect_transaction.js') }}"></script>
        <script>
            //Initialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        </script>
    @endpush
</x-admin-layout>
