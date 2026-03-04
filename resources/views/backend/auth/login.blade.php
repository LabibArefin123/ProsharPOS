@extends('frontend.layouts.app')

@section('content')
    <div class="container min-vh-100 d-flex align-items-center">
        <div class="row w-100 justify-content-center">

            <div class="col-xl-9 col-lg-11">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="row g-0">
                        @include('backend.auth.login.left')
                        @include('backend.auth.login.right')
                    </div>
                </div>

                <!-- Footer -->
                <p class="text-center text-muted small mt-3">
                    Designed & Developed by
                    <a href="#" id="visitDeveloper" class="fw-semibold text-decoration-none">
                        Labib Arefin
                    </a>
                </p>
            </div>

        </div>
    </div>


    <!-- Background -->
    <style>
        body {
            background: url('{{ asset('images/wallpaper.jpg') }}') no-repeat center center fixed;
            background-size: cover;
        }

        .problem-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            /* Hidden by default */
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .problem-modal.show {
            display: flex;
            /* Show when clicked */
        }

        .problem-modal-content {
            background: #fff;
            width: 500px;
            max-width: 95%;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            animation: scaleIn 0.25s ease;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 22px;
            font-weight: bold;
            cursor: pointer;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>

    {{-- SYSTEM PROBLEM MODAL --}}
    <div id="problemModal" class="problem-modal">
        <div class="problem-modal-content">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Report a System Problem</h5>
                <button type="button" class="close-btn" onclick="closeProblemModal()">×</button>
            </div>

            <form method="POST" action="{{ route('system_problem.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Problem Title</label>
                    <input type="text" name="problem_title" class="form-control"
                        placeholder="Example: Login not working">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Describe the Problem</label>
                    <textarea name="problem_description" class="form-control" rows="4" placeholder="Please explain what happened..."></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Priority Level</label>
                    <select name="status" class="form-control">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                        <option value="critical">Critical</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Attachment (Optional)</label>
                    <input type="file" name="problem_file" class="form-control" accept="image/*,.pdf">
                </div>

                <button class="btn btn-primary w-100 rounded-pill">
                    Submit Problem
                </button>
            </form>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            window.openProblemModal = function() {
                document.getElementById('problemModal').classList.add('show');
            }

            window.closeProblemModal = function() {
                document.getElementById('problemModal').classList.remove('show');
            }

            const modal = document.getElementById('problemModal');

            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeProblemModal();
                }
            });

        });
    </script>
@endsection
