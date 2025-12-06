<?php
/**
 * Template Name: Registration Page
 * 
 * @package torg-vent-brest
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="py-16 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 max-w-[1000px]">
            
            <!-- Breadcrumbs -->
            <div class="mb-8 text-sm text-gray-600">
                <a href="<?php echo home_url(); ?>" class="hover:text-primary">Главная</a>
                <span class="mx-2">/</span>
                <span class="text-primary">Регистрация</span>
            </div>

            <!-- Registration Form -->
            <div class="bg-white rounded-lg shadow-sm p-8 md:p-12">
                <h1 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-4">
                    Зарегистрироваться
                </h1>
                
                <p class="text-center text-gray-600 mb-8">
                    У вас уже есть аккаунт? 
                    <a href="<?php echo wp_login_url(); ?>" class="text-primary hover:underline">Войти</a>
                </p>

                <form id="registration-form" class="space-y-8">
                    
                    <!-- Contact Person Section -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-6">Контактное лицо</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="last_name" class="block text-sm text-gray-700 mb-2">
                                    Фамилия<span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="last_name" 
                                    name="last_name" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition"
                                >
                            </div>
                            <div>
                                <label for="first_name" class="block text-sm text-gray-700 mb-2">
                                    Имя<span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="first_name" 
                                    name="first_name" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition"
                                >
                            </div>
                            <div>
                                <label for="email" class="block text-sm text-gray-700 mb-2">
                                    E-mail<span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition"
                                >
                                <p class="text-xs text-gray-500 mt-1">Является логином для входа на сайт</p>
                            </div>
                            <div>
                                <label for="phone" class="block text-sm text-gray-700 mb-2">
                                    Телефон<span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Password Section -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-6">Пароль</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm text-gray-700 mb-2">
                                    Пароль<span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        id="password" 
                                        name="password" 
                                        required
                                        minlength="8"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition pr-12"
                                    >
                                    <button 
                                        type="button" 
                                        onclick="togglePassword('password')"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                    >
                                        <i class="fa-regular fa-eye" id="password-eye"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Длина не менее 8 символов</p>
                            </div>
                            <div>
                                <label for="password_confirm" class="block text-sm text-gray-700 mb-2">
                                    Подтвердите пароль<span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        id="password_confirm" 
                                        name="password_confirm" 
                                        required
                                        minlength="8"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition pr-12"
                                    >
                                    <button 
                                        type="button" 
                                        onclick="togglePassword('password_confirm')"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                    >
                                        <i class="fa-regular fa-eye" id="password_confirm-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Required Fields Note -->
                    <p class="text-sm text-gray-500">
                        <span class="text-red-500">*</span> поля, обязательные для заполнения
                    </p>

                    <!-- Privacy Policy Checkbox -->
                    <div class="flex items-start gap-3">
                        <input 
                            type="checkbox" 
                            id="privacy_policy" 
                            name="privacy_policy" 
                            required
                            class="mt-1"
                        >
                        <label for="privacy_policy" class="text-sm text-gray-600">
                            Я соглашаюсь с 
                            <a href="#" class="text-primary hover:underline">Политикой обработки персональных данных</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button 
                            type="submit" 
                            class="bg-primary hover:bg-blue-700 text-white font-bold py-3 px-12 rounded transition shadow-lg shadow-blue-500/30 text-sm uppercase"
                        >
                            Зарегистрироваться
                        </button>
                    </div>

                    <!-- Messages -->
                    <div id="registration-message" class="hidden"></div>
                </form>
            </div>
        </div>
    </section>
</main>

<script>
// Toggle password visibility
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-eye');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Handle form submission
document.getElementById('registration-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const messageDiv = document.getElementById('registration-message');
    const password = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('password_confirm').value;
    
    // Validate passwords match
    if (password !== passwordConfirm) {
        messageDiv.className = 'p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
        messageDiv.textContent = 'Пароли не совпадают';
        messageDiv.classList.remove('hidden');
        return;
    }
    
    // Prepare form data
    const formData = new FormData(this);
    formData.append('action', 'custom_user_registration');
    formData.append('nonce', '<?php echo wp_create_nonce('user_registration_nonce'); ?>');
    
    // Send AJAX request
    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageDiv.className = 'p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg';
            messageDiv.textContent = data.message;
            messageDiv.classList.remove('hidden');
            
            // Redirect after 2 seconds
            setTimeout(() => {
                window.location.href = data.redirect_url;
            }, 2000);
        } else {
            messageDiv.className = 'p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
            messageDiv.textContent = data.message;
            messageDiv.classList.remove('hidden');
        }
    })
    .catch(error => {
        messageDiv.className = 'p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
        messageDiv.textContent = 'Произошла ошибка. Попробуйте еще раз.';
        messageDiv.classList.remove('hidden');
    });
});
</script>

<?php
get_footer();
