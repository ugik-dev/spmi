<x-custom.app-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $title }}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{ asset('plugins/sweetalerts2/sweetalerts2.css') }}">
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/light/assets/components/modal.scss'])
        @vite(['resources/scss/dark/assets/components/modal.scss'])
        <link rel="stylesheet" href="{{ asset('plugins/animate/animate.css') }}">
        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])

        <style>
            .profile-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 1rem;
                /* Sesuaikan sesuai kebutuhan */
            }

            .profile-header h5 {
                /* Menghilangkan margin bawah default */
                margin-bottom: 0;
                /* Tinggi h5 */
                line-height: 24px;
                font-weight: bold;
            }

            .profile-header .btn-edit {
                /* Tinggi button */
                height: 32.1px;
            }

            .user-photo {
                width: 160px;
                height: 160px;
                border: 1px solid black;
            }
        </style>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    <x-slot:scrollspyConfig>
        data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
    </x-slot>

    <div class="row layout-top-spacing">
        <div class="col-lg-8 layout-spacing">
            <div class="statbox widget box box-shadow mt-3 mt-md-0">
                <div class="widget-content widget-content-area">
                    <x-custom.alerts />
                    <!-- User Profile Title and Edit Button -->
                    <div class="profile-header">
                        <h5>Ganti Password</h5>

                    </div>
                    <form id="editProfile-form" action="{{ route('my-profile.update-password', Auth::user()) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div style="min-height:40vh;">
                            {{-- <div class="row"> --}}
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" name="old_password"
                                        placeholder="Password Lama" value="">
                                    <label for="old_password">Password Lama</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" name="new_password"
                                        placeholder="Password Baru" value="">
                                    <label for="new_password">Password Baru</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" name="confirm_password"
                                        placeholder="Konfirmasi Password Baru" value="">
                                    <label for="confirm_password">Konfirmasi Password Baru</label>
                                </div>
                            </div>
                            {{-- </div> --}}
                        </div>

                        <button class="btn btn-primary" type="submit">
                            <span class="icon-name">Update</span>
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalTitle">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18">
                            </line>
                            <line x1="6" y1="6" x2="18" y2="18">
                            </line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingName" name="name"
                                    placeholder="Name" value="">
                                <label for="floatingName">Password Lama</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>

        <script>
            function previewImage() {
                var file = document.getElementById('fileInput').files;
                if (file.length > 0) {
                    var fileReader = new FileReader();

                    fileReader.onload = function(event) {
                        document.querySelector('.user-photo').setAttribute('src', event.target.result);
                    };

                    fileReader.readAsDataURL(file[0]);
                }
            }

            function openEditModal(id, name, email, identityNumber) {
                // Populate the form fields
                document.getElementById('floatingName').value = name;
                document.getElementById('floatingEmail').value = email;
                document.getElementById('floatingId').value = identityNumber;

                // Update the form action URL
                document.getElementById('editProfile-form').action =
                    '/profile'; // Menggunakan URL dasar untuk resource 'profile'


                // Show the modal
                new bootstrap.Modal(document.getElementById('editProfileModal')).show();
            }
        </script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>
