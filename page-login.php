<?php
/**
 * Template Name: Login Page
 * 
 * @package torg-vent-brest
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="py-16 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 max-w-[1200px]">
            
            <!-- Breadcrumbs -->
            <div class="mb-8 text-sm text-gray-600">
                <a href="<?php echo home_url(); ?>" class="hover:text-primary">Главная</a>
                <span class="mx-2">/</span>
                <span class="text-primary">Вход</span>
            </div>

            <!-- Login Form -->
            <div class="max-w-[660px] mx-auto">
                <h1 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-4">
                    Вход
                </h1>
                
                <p class="text-center text-gray-400 mb-8">
                    У вас ещё нет аккаунта? 
                    <a href="<?php echo home_url('/registration'); ?>" class="text-[#437FC8] hover:underline">Зарегистрироваться</a>
                </p>

                <div class="bg-white rounded-lg shadow-sm p-8 md:p-12">
                    <form id="login-form" class="space-y-6">
                        
                        <!-- Email Field -->
                        <div class="flex flex-col sm:flex-row w-full items-center justify-between gap-4 text-[14px] text-nowrap">
                            <label for="email" class="block text-sm text-gray-700 mb-2 sm:mr-4">
                                E-mail*
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition"
                                placeholder=""
                            >
                        </div>

                        <!-- Password Field -->
                        <div class="flex flex-col sm:flex-row w-full items-center justify-between gap-4 text-[14px] text-nowrap">
                            <label for="password" class="block text-sm text-gray-700 mb-2">
                                Пароль*
                            </label>
                            <div class="w-full relative">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition pr-12"
                                    placeholder="••••••••"
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePasswordVisibility()"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition"
                                    aria-label="Toggle password visibility"
                                >
                                    <i class="fa-regular fa-eye" id="password-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button and Forgot Password -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <button 
                                type="submit" 
                                class="main-button text-white font-bold py-3 px-12 rounded transition shadow-lg shadow-blue-500/30 text-sm uppercase w-full sm:w-auto"
                            >
                                Войти
                            </button>
                            <a href="<?php echo wp_lostpassword_url(); ?>" class="text-primary hover:underline text-sm">
                                Забыли пароль?
                            </a>
                        </div>

                        <!-- Messages -->
                        <div id="login-message" class="hidden"></div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
// Toggle password visibility
function togglePasswordVisibility() {
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('password-eye');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}

// Handle form submission
document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const messageDiv = document.getElementById('login-message');
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    // Prepare form data
    const formData = new FormData();
    formData.append('action', 'custom_user_login');
    formData.append('email', email);
    formData.append('password', password);
    formData.append('nonce', '<?php echo wp_create_nonce('user_login_nonce'); ?>');
    
    // Show loading state
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    submitButton.textContent = 'Вход...';
    submitButton.disabled = true;
    
    // Send AJAX request
    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        // Log response for debugging
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        // Check if response is OK
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Error response:', text);
                throw new Error(`HTTP ${response.status}: ${text.substring(0, 100)}`);
            });
        }
        
        // Try to parse as JSON
        return response.text().then(text => {
            console.log('Response text:', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('JSON parse error:', e);
                console.error('Response was:', text);
                throw new Error('Ответ сервера не является валидным JSON');
            }
        });
    })
    .then(data => {
        console.log('Parsed data:', data);
        
        if (data.success) {
            messageDiv.className = 'p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg';
            messageDiv.textContent = data.data.message || 'Вход выполнен успешно!';
            messageDiv.classList.remove('hidden');
            
            // Redirect after 1 second
            setTimeout(() => {
                window.location.href = data.data.redirect_url || '<?php echo home_url(); ?>';
            }, 1000);
        } else {
            messageDiv.className = 'p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
            messageDiv.textContent = data.data.message || 'Неверный email или пароль';
            messageDiv.classList.remove('hidden');
            
            // Reset button
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        messageDiv.className = 'p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
        messageDiv.textContent = 'Ошибка: ' + error.message;
        messageDiv.classList.remove('hidden');
        
        // Reset button
        submitButton.textContent = originalText;
        submitButton.disabled = false;
    });
});
</script>

<?php
get_footer();
