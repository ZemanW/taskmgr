<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | TaskManager</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        body {
            background-color: #f9fafb;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 420px;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 1.75rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.375rem;
            color: #374151;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            width: 20px;
            height: 20px;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 0.625rem 0.75rem 0.625rem 2.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: border-color 0.15s ease-in-out;
        }

        input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        input.error {
            border-color: #ef4444;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: none;
        }

        button {
            display: block;
            width: 100%;
            padding: 0.625rem 1rem;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out;
        }

        button:hover {
            background-color: #2563eb;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .login-link a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* SVG icons */
        .user-icon, .mail-icon, .lock-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sign up</h1>
        <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo '<div class="error-alert">' . htmlspecialchars($_SESSION['error']) . '</div>';
            unset($_SESSION['error']);
        }
        ?>
        <form id="signupForm" action="../controllers/signup_process.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name</label>
                <div class="input-group">
                    <div class="input-icon">
                        <svg class="user-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" id="name" name="name" placeholder="John Doe" required>
                    <div class="error-message" id="nameError">Name is required</div>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-group">
                    <div class="input-icon">
                        <svg class="mail-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input type="email" id="email" name="email" placeholder="your@email.com" required>
                    <div class="error-message" id="emailError">Please enter a valid email address</div>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-group">
                    <div class="input-icon">
                        <svg class="lock-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                    <div class="error-message" id="passwordError">Password must be at least 6 characters</div>
                </div>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <div class="input-group">
                    <div class="input-icon">
                        <svg class="lock-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="••••••••" required>
                    <div class="error-message" id="confirmPasswordError">Passwords do not match</div>
                </div>
            </div>
            <button type="submit">Create account</button>
        </form>
        <div class="login-link">
            Already have an account? <a href="http://localhost/TaskManager/view/login.php">Log in</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const signupForm = document.getElementById('signupForm');
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const nameError = document.getElementById('nameError');
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');
            const confirmPasswordError = document.getElementById('confirmPasswordError');

            // Email validation function
            function validateEmail(email) {
                const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }

            // Input event listeners for real-time validation
            nameInput.addEventListener('input', function() {
                if (nameInput.value.trim() === '') {
                    nameInput.classList.add('error');
                    nameError.style.display = 'block';
                } else {
                    nameInput.classList.remove('error');
                    nameError.style.display = 'none';
                }
            });

            emailInput.addEventListener('input', function() {
                if (!validateEmail(emailInput.value) && emailInput.value.trim() !== '') {
                    emailInput.classList.add('error');
                    emailError.style.display = 'block';
                } else {
                    emailInput.classList.remove('error');
                    emailError.style.display = 'none';
                }
            });

            passwordInput.addEventListener('input', function() {
                if (passwordInput.value.length < 6 && passwordInput.value.trim() !== '') {
                    passwordInput.classList.add('error');
                    passwordError.style.display = 'block';
                } else {
                    passwordInput.classList.remove('error');
                    passwordError.style.display = 'none';
                }
                
                // Check password match whenever password changes
                if (confirmPasswordInput.value !== '' && 
                    passwordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordInput.classList.add('error');
                    confirmPasswordError.style.display = 'block';
                } else if (confirmPasswordInput.value !== '') {
                    confirmPasswordInput.classList.remove('error');
                    confirmPasswordError.style.display = 'none';
                }
            });

            confirmPasswordInput.addEventListener('input', function() {
                if (passwordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordInput.classList.add('error');
                    confirmPasswordError.style.display = 'block';
                } else {
                    confirmPasswordInput.classList.remove('error');
                    confirmPasswordError.style.display = 'none';
                }
            });

            // Form submission
            signupForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                let isValid = true;
                
                // Validate name
                if (nameInput.value.trim() === '') {
                    nameInput.classList.add('error');
                    nameError.style.display = 'block';
                    isValid = false;
                } else {
                    nameInput.classList.remove('error');
                    nameError.style.display = 'none';
                }
                
                // Validate email
                if (!validateEmail(emailInput.value)) {
                    emailInput.classList.add('error');
                    emailError.style.display = 'block';
                    isValid = false;
                } else {
                    emailInput.classList.remove('error');
                    emailError.style.display = 'none';
                }
                
                // Validate password
                if (passwordInput.value.length < 6) {
                    passwordInput.classList.add('error');
                    passwordError.style.display = 'block';
                    isValid = false;
                } else {
                    passwordInput.classList.remove('error');
                    passwordError.style.display = 'none';
                }
                
                // Validate confirm password
                if (passwordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordInput.classList.add('error');
                    confirmPasswordError.style.display = 'block';
                    isValid = false;
                } else {
                    confirmPasswordInput.classList.remove('error');
                    confirmPasswordError.style.display = 'none';
                }
                
                // Inside your existing script tag, replace the if(isValid) block with:
                if (isValid) {
                    // Submit the form to the server
                    signupForm.submit();
                }
                
                // You would normally redirect or show a success message here
                alert('Account created successfully!');
            });
        });
    </script>
</body>
</html>