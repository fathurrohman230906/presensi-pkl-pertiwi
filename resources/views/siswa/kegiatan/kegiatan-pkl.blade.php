<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Mobilekit Mobile UI Kit</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />

    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/icon/192x192.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="manifest" href="__manifest.json">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        #user-detail {
            position: relative;
        }

        .logout-button {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .card-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        p {
            font-size: 1rem;
        }

        .harian-card {
            transition: transform 0.3s ease;
        }

        .harian-card:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body style="background-color:#e9ecef;">

    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>

    <div class="">
        <div class="card shadow-sm">
            <div class="card-body d-flex align-items-center">
                <a href="{{ route('siswa.dashboard') }}">
                    <i class="bi bi-arrow-left me-3 text-primary" style="font-size: 1.5rem;"></i>
                </a>
                <p class="mb-0 fw-bold">Kembali</p>
            </div>
        </div>
    </div>

    <div class="p-3">
        <form action="{{ route('create.kegiatan.siswa') }}" method="post">
            @csrf
            <div class="card-center row">
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <select class="form-select" aria-label="Default select example">
                                <option selected disabled>---- Pilih Tahun ----</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Current Month Cards with Hover Effect -->
        <div class="row" id="monthCardsContainer"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="harianModal" tabindex="-1" aria-labelledby="harianModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="harianModalLabel">Detail Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <button type="submit" class="btn btn-success"><i class="bi bi-plus"></i> Buat</button>
                    <p>Detail kegiatan untuk <span id="modalMonthYear"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/lib/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="{{ asset('assets/js/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-circle-progress/circle-progress.min.js') }}"></script>
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="{{ asset('assets/js/base.js') }}"></script>

    <script>
        // Function to generate month cards
        function generateMonthCards() {
            const monthNames = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
    
            const currentDate = new Date();
            const currentMonth = currentDate.getMonth(); // 0-11
            const monthCardsContainer = document.getElementById('monthCardsContainer');
    
            // Clear existing cards
            monthCardsContainer.innerHTML = '';
    
            // Generate card for the current month only
            const existingCard = monthCardsContainer.querySelector(`[data-month="${currentMonth}"]`);
            if (!existingCard) {
                const monthCard = document.createElement('div');
                monthCard.className = 'col-6 col-md-4 col-lg-2';
                monthCard.setAttribute('data-month', currentMonth);
                monthCard.innerHTML = `
                    <div class="card harian-card" onclick="showModal('${monthNames[currentMonth]} ${currentDate.getFullYear()}')">
                        <div class="card-body">
                            <p class="card-center">${monthNames[currentMonth]} ${currentDate.getFullYear()}</p>
                        </div>
                    </div>
                `;
                monthCardsContainer.appendChild(monthCard);
            }
        }
    
        // Function to show modal and set the month year
        function showModal(monthYear) {
            document.getElementById('modalMonthYear').innerText = monthYear;
    
            const modalBody = document.querySelector('#harianModal .modal-body');
            modalBody.innerHTML = `
                <p>Detail kegiatan untuk <span id="modalMonthYear">${monthYear}</span></p>
                <button class="btn btn-success" id="addInputBtn">Buat</button>
                <div id="dynamicInputs"></div>
            `;
    
            document.getElementById('addInputBtn').addEventListener('click', addInputField);
    
            var myModal = new bootstrap.Modal(document.getElementById('harianModal'));
            myModal.show();
        }
    
        // Function to add input field, progress bar, and submit button
        function addInputField() {
    const dynamicInputs = document.getElementById('dynamicInputs');

    // Create a new input field container
    const inputDiv = document.createElement('div');
    inputDiv.className = 'mb-3';

    // Get the current date
    const today = new Date();
    const currentDate = today.getDate();
    const currentMonth = today.toLocaleString('default', { month: 'long' }); // Get full month name
    const currentYear = today.getFullYear();

    // Create a paragraph for date, month, and year together
    const dateParagraph = document.createElement('p');
    dateParagraph.innerText = `${currentDate} ${currentMonth} ${currentYear}`;
    dateParagraph.className = 'mt-3';

    // Create the main input field for kegiatan
    const inputField = document.createElement('input');
    inputField.type = 'text';
    inputField.placeholder = 'Input Kegiatan';
    inputField.className = 'form-control mb-2';

    // Create submit button
    const submitBtn = document.createElement('button');
    submitBtn.className = 'btn btn-primary';
    submitBtn.innerText = 'Submit';

    // Create progress bar
    const progress = document.createElement('div');
    progress.className = 'progress mb-2';
    const progressBar = document.createElement('div');
    progressBar.className = 'progress-bar progress-bar-striped progress-bar-animated';
    progressBar.style.width = '0%';
    progressBar.setAttribute('role', 'progressbar');

    // Append everything to the inputDiv
    inputDiv.appendChild(dateParagraph);
    progress.appendChild(progressBar);
    inputDiv.appendChild(progress);
    inputDiv.appendChild(inputField);
    inputDiv.appendChild(submitBtn);

    // Finally, append the inputDiv to dynamicInputs
    dynamicInputs.appendChild(inputDiv);
}


    
        // Initialize month cards on page load
        document.addEventListener('DOMContentLoaded', generateMonthCards);
    </script>
</body>

</html>
