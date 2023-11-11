   <!-- Bootstrap core JavaScript-->
   <script src="{{ asset('be/vendor/jquery/jquery.min.js') }}"></script>
   <script src="{{ asset('be/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

   <!-- Core plugin JavaScript-->
   <script src="{{ asset('be/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

   <!-- Custom scripts for all pages-->
   <script src="{{ asset('be/js/sb-admin-2.min.js') }}"></script>

   <!-- Page level plugins -->
   <script src="{{ asset('be/vendor/datatables/jquery.dataTables.min.js') }}"></script>
   <script src="{{ asset('be/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

   <!-- Page level custom scripts -->
   <script src="{{ asset('be/js/demo/datatables-demo.js') }}"></script>


   <!-- Page level plugins -->
   <script src="{{ asset('be/vendor/chart.js/Chart.min.js') }}"></script>

   <!-- Page level plugins -->
   <script src="{{ asset('be/vendor/datatables/jquery.dataTables.min.js') }}"></script>
   <script src="{{ asset('be/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

   <!-- Page level custom scripts -->
   <script src="{{ asset('be/js/demo/datatables-demo.js') }}"></script>

   <!-- Page level custom scripts -->
   <script src="{{ asset('be/js/demo/chart-area-demo.js') }}"></script>
   <script src="{{ asset('be/js/demo/chart-pie-demo.js') }}"></script>

   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   <script>
       document.addEventListener('DOMContentLoaded', function() {
           const checkboxes = document.querySelectorAll('input[type="checkbox"]');
           const checkboxGroups = {};

           checkboxes.forEach(checkbox => {
               const noUrutSoal = checkbox.getAttribute('data-no-urut-soal');

               checkbox.addEventListener('change', function() {
                   if (this.checked) {
                       // Uncheck other checkboxes in the same group
                       if (checkboxGroups[noUrutSoal]) {
                           checkboxGroups[noUrutSoal].forEach(checkbox => {
                               if (checkbox !== this) {
                                   checkbox.checked = false;
                               }
                           });
                       }
                   }

                   // Update the checkbox group
                   if (!checkboxGroups[noUrutSoal]) {
                       checkboxGroups[noUrutSoal] = [this];
                   } else {
                       checkboxGroups[noUrutSoal].push(this);
                   }
               });
           });
       });
   </script>




   @stack('script')
