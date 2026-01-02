<!DOCTYPE html>

<html class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="{{ asset('/assets') . '/' }}" data-base-url="{{url('/')}}" data-framework="laravel" data-template="vertical-menu-laravel-template-free">

    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ config('common.APP_NAME') }} | @yield('title') </title>

    <!-- laravel CRUD token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('admin/assets/img/favicon/favicon.ico') }}" />

    <!-- Bootstrap CSS (Optional, if you're using Bootstrap) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Font Awesome Latest CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Include Styles -->
    @include('manage.layouts.sections.styles')

    <!-- Include Scripts for customizer, helper, analytics, config -->
    @include('manage.layouts.sections.scriptsIncludes')
    </head>

    <body>


    <!-- Layout Content -->
    @yield('layoutContent')
    <!--/ Layout Content -->



    <!-- Include Scripts -->
    @include('manage.layouts.sections.scripts')

    <!-- jQuery (Required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery Validate Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- jQuery & Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('extraScript')

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select",
                allowClear: true
            });
            $(document).on('select2:open', () => {
                setTimeout(() => {
                    document.querySelector('.select2-search__field').focus();
                }, 50);
            });

            //Common Status Toggle
            $(document).on('change', '.datatable-status-toggle', function() {
                var id = $(this).attr("data-row-id");
                var tableName = $(this).attr("data-table-name");
                var status = $(this).prop('checked') ? 1 : 0;
                var switchElement = $(this);

                $.ajax({
                    url: "{{route('manage.update.status')}}",
                    type: "POST",
                    data: { id: id, tableName:tableName, _token: $('meta[name="csrf-token"]').attr('content') },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: "Updated!",
                                text: response.message,
                                icon: "success",
                                confirmButtonColor: "#ED7B1B"
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error",
                                confirmButtonColor: "#ED7B1B"
                            });
                            switchElement.prop('checked', !status); // Revert on failure
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: "Error!",
                            text: "Something went wrong.",
                            icon: "error",
                            confirmButtonColor: "#ED7B1B"
                        });
                        switchElement.prop('checked', !status); // Revert on error
                    }
                });

            })

            //Common Delete
            $(document).on('click', '.datatable-delete', function() {
                var id = $(this).attr("data-row-id");
                var tableName = $(this).attr("data-table-name");
                var row = $(this).closest('tr');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This record will be permanently deleted and cannot be recovered.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ED7B1B",
                    cancelButtonColor: "#cccc",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{route('manage.delete')}}",
                            type: "POST",
                            data: { id: id, tableName:tableName, _token: $('meta[name="csrf-token"]').attr('content') },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: response.message,
                                        icon: "success",
                                        confirmButtonColor: "#ED7B1B"
                                    });
                                    row.remove();
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: response.message,
                                        icon: "error",
                                        confirmButtonColor: "#ED7B1B"
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Something went wrong.",
                                    icon: "error",
                                    confirmButtonColor: "#ED7B1B"
                                });
                            }
                        });
                    }
                });
            })

            //Common Verified Toggle
            $(document).on('change', '.datatable-verified-toggle', function() {
                var id = $(this).attr("data-row-id");
                var tableName = $(this).attr("data-table-name");
                var status = $(this).prop('checked') ? 1 : 0;
                var switchElement = $(this);

                $.ajax({
                    url: "{{route('manage.update.verifiedStatus')}}",
                    type: "POST",
                    data: { id: id, tableName:tableName, _token: $('meta[name="csrf-token"]').attr('content') },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: "Updated!",
                                text: response.message,
                                icon: "success",
                                confirmButtonColor: "#ED7B1B"
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error",
                                confirmButtonColor: "#ED7B1B"
                            });
                            switchElement.prop('checked', !status); // Revert on failure
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: "Error!",
                            text: "Something went wrong.",
                            icon: "error",
                            confirmButtonColor: "#ED7B1B"
                        });
                        switchElement.prop('checked', !status); // Revert on error
                    }
                });

            })

            $.validator.addMethod("decimalNumber", function (value, element) {
                return this.optional(element) || /^\d+(\.\d{1,2})?$/.test(value);
            }, "Please enter a valid decimal number (up to 2 decimal places).");
        });

        $(window).on('load', function() {
            var urlParams = new URLSearchParams(window.location.search);
            var currentTab = urlParams.get('currentTab');

            if (currentTab) {
                var tabSelector = decodeURIComponent(currentTab);

                var tabElement = document.querySelector(`button[data-bs-target="#${tabSelector}"]`);

                if (tabElement) {
                    tabElement.click();
                }
            }
        });

        setTimeout(function() {
            $(".alert").fadeOut("slow");
        }, 3000);

    </script>
    </body>
</html>

</html>
