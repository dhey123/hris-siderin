<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login | PT Quantum Tosan International</title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>

/* RESET */
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    height: 100vh;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #06AF36 50%, #FFD200 50%);
    display: flex;
    justify-content: center;
    align-items: center;
}

/* CONTAINER */
.container {
    width: 920px;
    height: 540px;
    display: flex;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 25px 60px rgba(0,0,0,0.25);
}

/* LEFT */
.left {
    flex: 1;
    background: linear-gradient(160deg, #058f2c, #06AF36);
    color: white;
    padding: 50px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.left img {
    width: 260px;
    margin-bottom: 20px;
}

.left h1 {
    font-size: 38px;
    margin: 0;
    line-height: 1.2;
}

.left h1 span {
    font-weight: bold;
}

.left .tagline {
    margin-top: 15px;
    font-size: 14px;
    opacity: 0.9;
    max-width: 280px;
}

/* RIGHT */
.right {
    flex: 1;
    background: rgba(255,255,255,0.3);
    backdrop-filter: blur(20px);
    display: flex;
    align-items: center;
    justify-content: center;
}

/* LOGIN BOX */
.login-box {
    width: 100%;
    max-width: 340px;
    background: rgba(255,255,255,0.75);
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
}

/* HEADER */
.login-header {
    text-align: center;
    margin-bottom: 20px;
}

.login-header img {
    width: 180px;
    margin-bottom: 5px;
}

.login-header h2 {
    margin: 5px 0;
    color: #06AF36;
}

.login-header small {
    color: #777;
}

/* INPUT */
.input-group {
    margin-bottom: 15px;
}

.input-group label {
    font-size: 13px;
    display: block;
    margin-bottom: 5px;
    color: #555;
}

.input-box {
    position: relative;
}
.input-box i:not(.toggle-password) {
    position: absolute;
    top: 50%;
    left: 12px;
    transform: translateY(-50%);
    color: #888;
}

.input-box input {
    width: 100%;
    height: 46px;
    padding: 0 40px 0 40px;
    border-radius: 12px;
    border: none;
    background: #fff;
    font-size: 14px;
}

.input-box input:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(6,175,54,0.3);
}

/* PASSWORD ROW */
.password-row {
    display: flex;
    justify-content: flex-end;
    font-size: 12px;
    margin-bottom: 15px;
}

.password-row a {
    color: #06AF36;
    text-decoration: none;
}

.toggle-password {
    padding: 6px;
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #888;
    transition: 0.2s;
}


.toggle-password:hover {
    color: #06AF36;
}
/* BUTTON */
button {
    width: 100%;
    height: 48px;
    background: linear-gradient(90deg, #06AF36, #05a832);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    cursor: pointer;
    transition: 0.2s;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

/* FOOTER */
.footer {
    text-align: center;
    margin-top: 18px;
    font-size: 12px;
    color: #555;
}

.footer span {
    display: block;
    opacity: 0.7;
}

/* ERROR */
.error {
    color: red;
    font-size: 13px;
    margin-top: 10px;
    text-align: center;
}

</style>
</head>

<body>

<div class="container">

    <!-- LEFT -->
    <div class="left">
        <img src="{{ asset('logo.png') }}?v={{ time() }}">
        
        <h1>
            Together<br>
            <span>We Grow</span>
        </h1>

        <p class="tagline">
            Empowering people, driving performance, building a better future.
        </p>
    </div>

    <!-- RIGHT -->
    <div class="right">
        <div class="login-box">

            <div class="login-header">
               
                <h2>HRIS</h2>
                <small>Human Resource Information System</small>
            </div>

            <form method="POST" action="{{ route('login.process') }}">
                @csrf

                <div class="input-group">
                    <label>Email</label>
                    <div class="input-box">
                        <i class="fa fa-envelope"></i>
                        <input type="email" name="email" placeholder="Masukkan email Anda" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <div class="input-box">
                        <i class="fa fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
                        <i class="fa fa-eye toggle-password" onclick="togglePassword()"></i>
                    </div>
                </div>

                <div class="password-row">
                    <a href="#">Lupa Password?</a>
                </div>

                <button type="submit">Login</button>
            </form>

            @if(session('error'))
                <div class="error">{{ session('error') }}</div>
            @endif

            <div class="footer">
                © {{ date('Y') }} PT Quantum Tosan International
                <span>Developed with ❤️ by siDerin</span>
            </div>

        </div>
    </div>

</div>
<script>
function togglePassword() {
    const input = document.getElementById("password");
    const icon = document.querySelector(".toggle-password");

    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    }
}
</script>

</body>

</html>