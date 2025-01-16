<template>
    <div class="back">
        <button class="back_btn" @click="goBack" style="background-color: #fff">
            <img src="../assets/img/chevron-left-solid.svg" alt="뒤로가기" width="30" height="30" />
        </button>
    </div>
    <div class="logo">
        <img src="../assets/img/nede_3.jpg" alt="NEDE logo" />
    </div>
    <div class="login-container">
        <form @submit.prevent="handleLogin">
            <input type="text" v-model="form.username" placeholder="아이디" required />
            <input
                type="password"
                v-model="form.password"
                placeholder="비밀번호(8~10자, 영문+숫자+특수문자)"
                required
            />
            <div class="options">
                <label> <input type="checkbox" v-model="form.autoLogin" /> 자동로그인 </label>
                <label> <input type="checkbox" v-model="form.saveId" /> 아이디 저장 </label>
            </div>

            <button class="login login_bg" type="submit" :disabled="loading">로그인</button>
            <button class="snslogin login_bg" type="button" @click="Easylogin">간편 로그인</button>

            <div class="links">
                <button @click="navigateTo('/register')">회원가입</button>
                <button @click="navigateTo('#')">아이디 찾기</button>
                <button @click="navigateTo('#')">비밀번호 찾기</button>
            </div>
        </form>

        <footer>
            <span>ver.1.1.1 업데이트</span>
            <span>고객센터</span>
            <span>공지사항</span>
        </footer>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                username: '',
                password: '',
                autoLogin: false,
                saveId: false
            },
            loading: false,
            message: ''
        };
    },
    methods: {
        async handleLogin() {
            if (!this.form.username || !this.form.password) {
                alert('아이디와 비밀번호를 입력해주세요.');
                return;
            }

            this.loading = true;
            try {
                const response = await fetch('http://green609b.dothome.co.kr/api/auth/login.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    credentials: 'include',
                    body: JSON.stringify(this.form)
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const result = await response.json(); // JSON으로 파싱
                console.log('Response result:', result); // 서버 응답 디버깅

                if (result.status === 'success') {
                    this.isLoggedIn = true; // 로그인 상태 설정
                    localStorage.setItem('isLoggedIn', 'true'); // 로그인 상태를 localStorage에 저장
                    // 로그인 성공 시 마이페이지로 이동
                    alert('로그인 되었습니다.');
                    this.$router.push('/mypage');
                    /* this.$router.push('/'); */
                    this.username = ''; // 입력 필드 초기화
                    this.password = '';
                } else {
                    // 서버에서 반환된 에러 메시지 표시
                    this.error = result.data?.message || 'Login failed';
                }
            } catch (error) {
                console.error('Login error:', error); // 디버깅을 위한 출력
                this.error = error.message || 'An unexpected error occurred';
            } finally {
                this.loading = false;
            }
        },
        Easylogin() {
            this.$router.push('/easylogin');
        },
        navigateTo(path) {
            this.$router.push(path);
        },
        goBack() {
            this.$router.go(-1); // 뒤로가기
        }
    }
};
</script>

<style scoped>
.back button {
    position: relative;
    top: 20px;
    left: 20px;
}

.login-container {
    max-width: 400px;
    margin: 0 auto;
    padding: 50px;
    text-align: center;
    font-family: Arial, sans-serif;
}

.logo {
    width: 1000px;
    margin: 0 auto;
}

.logo img {
    max-width: 600px;
    margin-left: 170px;
    margin-top: 50px;
}

form {
    display: flex;
    flex-direction: column;
}

input,
button {
    margin-bottom: 15px;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background-color: #333;
    color: white;
    border: none;
    cursor: pointer;
}

button:disabled {
    background-color: #aaa;
    cursor: not-allowed;
}

.options {
    display: flex;
    justify-content: space-around;
    margin-bottom: 15px;
    margin-top: -5px;
}

.links {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
}

.links button {
    background-color: #acacac;
}

.links button:hover {
    background-color: #9e9e9e;
}

.login {
    margin-top: 50px;
}

.login_bg {
    background-color: #acacac;
}

.login_bg:hover {
    background-color: #9e9e9e;
}

footer {
    margin-top: 20px;
    font-size: 12px;
    display: flex;
    justify-content: space-between;
    color: #555;
}
</style>
